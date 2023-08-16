import dotenv from "dotenv/config";
import { app } from "./applications/app.js";
import { logger } from "./applications/logger.js";

app.listen(process.env.APP_PORT, () => {
    logger.info(`Server running on ${process.env.APP_HOST}:${process.env.APP_PORT}`)
})