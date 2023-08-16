import { logger } from "../applications/logger.js"
import { ErrorResponse } from "../utils/response/error-response.js"

export const errorMiddleware = (err, req, res, next) => {
    if (!err) {
        next()
        return
    }

    
    if (err instanceof ErrorResponse) {
        res.status(400)
            .json({
                errors: err.message
            })
            .end()
    } else {
        res.status(500)
            .json({
                errors: err.message
            })
            .end()
    }
}