import { connection } from "../applications/connection.js";
import { logger } from "../applications/logger.js";
import { ErrorResponse } from "../utils/response/error-response.js";
import { createRoleValidator, updateRoleValidator } from "../validations/role-validation.js";
import { validation } from "../validations/validation.js";
import { v4 as uuid } from "uuid";

export const createRole = async (req, res, next) => {

    const inputRole = await validation(createRoleValidator, req)

    const checkDuplicatedData = await connection.roles.findUnique({
        where: { ROLE_NAME: inputRole.name },
        select: { ROLE_NAME: true }
    })

    if (null != checkDuplicatedData) {
        throw new ErrorResponse(422, `Nama role yang anda masukan sudah terdaftar`)
    }

    return await connection.roles.create({
        data: {
            ROLE_ID: uuid(),
            ROLE_NAME: inputRole.name,
        },
        select: {
            ROLE_NAME: true,
            ROLE_CREATED_AT: true
        }
    })
}

export const getRoles = async () => {
    const result = await connection.roles.findMany({
        where: { ROLE_IS_DELETED: false },
        select: {
            ROLE_NAME: true
        }
    })

    if (0 == result.length) {
        throw new ErrorResponse(404, `Tidak ada data role untuk ditampilkan`)
    } else {
        return result
    }
}

export const getRoleById = async (params) => {

    const result = await connection.roles.findMany({
        where: {
            AND: [
                { ROLE_IS_DELETED: false },
                { ROLE_ID: params.id }
            ]
        },
        select: {
            ROLE_NAME: true
        }
    })

    if (0 == result.length) {
        throw new ErrorResponse(404, `Tidak ada data role untuk ditampilkan`)
    } else {
        return result
    }
}

export const updateRole = async (req) => {

    // Mencari data yang akan d update
    const dataRole = await connection.roles.findUnique({
        where: { ROLE_ID: req.params.id },
        select: { ROLE_NAME: true }
    })

    // Return Error ketika data role tidak ditemukan
    if (null == dataRole) {
        throw new ErrorResponse(404, `Data role tidak ditemukan`)
    }

    logger.warn(req)

    // Validasi data mandatory
    const inputData = await validation(updateRoleValidator, req.body)

    // check duplicate role name
    const checkDuplicatedData = await connection.roles.findUnique({
        where: { ROLE_NAME: inputData.name },
        select: { ROLE_NAME: true }
    })

    // Response error ketika duplikat role name
    if (null != checkDuplicatedData) {
        throw new ErrorResponse(422, `Nama role yang anda masukan sudah terdaftar`)
    }

    // Proses Update Data Role
    return await connection.roles.update({
        where: { ROLE_ID: req.params.id },
        data: {
            ROLE_NAME: inputData.name,
            // ROLE_UPDATED_AT: Date()
        }
    })

}

export const deleteRole = async (req) => {
    // Inisialisasi Parameter
    const { id } = req

    // Mencari data role berdasarkan id
    const dataRole = await connection.roles.findMany({
        where: {
            AND: [
                { ROLE_ID: id },
                { ROLE_IS_DELETED: false }
            ]
        },
        select: { ROLE_NAME: true }
    })

    logger.warn(dataRole)

    // Response Error saat data role tidak ditemukan
    if (0 == dataRole.length) {
        throw new ErrorResponse(404, `Data role tidak ditemukan`)
    }

    // Proses penghapusan data role
    return await connection.roles.update({
        where: { ROLE_ID: id },
        data: { ROLE_IS_DELETED: true }
    })
}

export const destroyRole = async (req) => {
    // Inisialisasi variable
    const { id } = req

    // Mencari data role yang akan dihapus berdasarkan id
    const searchRole = await connection.roles.findUnique({
        where: { ROLE_ID: id },
        select: { ROLE_NAME: true }
    })

    // Mengembalikan response error ketika data role tidak ditemukan
    if (null == searchRole) {
        throw new ErrorResponse(404, `Data role tidak ditemukan`)
    }

    // Proses penghapusan data role
    return await connection.roles.delete({
        where: { ROLE_ID: id }
    })
}

export const getDeletedRoles = async () => {
    const result = await connection.roles.findMany({
        where: { ROLE_IS_DELETED: true },
        select: { ROLE_NAME: true }
    })

    logger.warn(result)

    if (0 == result.length) {
        throw new ErrorResponse(422, `Data role tidak ditemukan`)
    } else {
        return result
    }
}

export const restoreRole = async (req) => {

    // Inisialisasi Variable
    const { id } = req

    // Mencari data yang akan d update
    const dataRole = await connection.roles.findMany({
        where: {
            AND: [
                { ROLE_IS_DELETED: true },
                { ROLE_ID: id }
            ]
        },
        select: { ROLE_NAME: true }
    })

    // Return Error ketika data role tidak ditemukan
    if (0 == dataRole.length) {
        throw new ErrorResponse(404, `Data role tidak ditemukan`)
    }

    // Proses Update Data Role
    return await connection.roles.update({
        where: { ROLE_ID: id },
        data: { ROLE_IS_DELETED: false },
        select: { ROLE_NAME: true }
    })

}
