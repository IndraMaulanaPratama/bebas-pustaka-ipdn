import { ErrorResponse } from "../utils/response/error-response.js"
import { createRoleValidator } from "./role-validation.js"

export const validation = (schema, req) => {
    const result = schema.validate(req, {
        abortEarly: false,
        allowUnknown: false
    })

    if (result.error) {
        throw new ErrorResponse(400, result.error.message)
    } else {
        return result.value
    }
}