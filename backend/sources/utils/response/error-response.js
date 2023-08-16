class ErrorResponse extends Error {
    constructor(status, message) {
        super(status)
        this.message = message
    }
}

export { ErrorResponse }