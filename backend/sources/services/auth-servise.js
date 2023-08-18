import { connection } from "../applications/connection";
import { ErrorResponse } from "../utils/response/error-response";
import { registerValidator } from "../validations/auth-validation";
import { validation } from "../validations/validation";
import bcrypt from "bcrypt";
import { v4 as uuid } from "uuid";

export const registerService = async (req, res, next) => {

    let { username, password, email, name, address, phone_number } = req
    const inputAuth = await validation(registerValidator, req)

    const checkUsername = await connection.users.findMany({
        where: {
            AND: [
                { USER_USERNAME: username },
                { USER_IS_DELETED: false }
            ]
        },
        select: { USER_USERNAME: true }
    })

    if (null != checkUsername) {
        throw new ErrorResponse(422, "Username sudah terdaftar")
    }

    let id = uuid()
    let token = uuid()
    password = await bcrypt.hash(inputAuth, 10);

    const processProfile = await connection.profile.create({
        data: {
            PROFILE_ID: id,
            PROFILE_NAME: name,
            PROFILE_ADDRESS: address,
            PROFILE_PHONE_NUMBER: phone_number
        },

        select: { PROFILE_ID: true, PROFILE_NAME: true }
    })

    if (!processProfile) {
        throw new ErrorResponse(500, `Data profile gagal diproses`)
    }

    return await connection.users.create({
        data: {
            USER_ID: id,
            USER_USERNAME: username,
            USER_PASSWORD: password,
            USER_TOKEN: token
        },
        select: { USER_ID: true, USER_USERNAME: true }
    })
}