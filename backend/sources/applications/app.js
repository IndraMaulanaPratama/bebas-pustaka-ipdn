import { errorMiddleware } from "../middlewares/error-middleware.js";
import { roleRouter as role } from "../routers/role-route.js";
import { logger } from "./logger.js";
import express from "express";

export const app = express()

app.use(express.json())

app.use("/role", role)

app.use(errorMiddleware)