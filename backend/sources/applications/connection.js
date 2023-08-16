import { PrismaClient } from "@prisma/client";
import { logger } from "./logger.js";

export const connection = new PrismaClient({
    log: [
        { level: "info", emit: "event" },
        { level: "query", emit: "event" },
        { level: "warn", emit: "event" },
        { level: "error", emit: "event" },
    ]
})

connection.$on("info", (err) => {
    logger.info(err)
})

connection.$on("query", (err) => {
    logger.info(err)
})

connection.$on("warn", (err) => {
    logger.warn(err)
})

connection.$on("error", (err) => {
    logger.error(err)
})