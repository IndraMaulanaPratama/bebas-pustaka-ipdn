import { Router } from "express";
import {
    createRoleController,
    deleteRoleController,
    destroyRoleController,
    getDeletedRolesController,
    getRoleByIdController,
    getRolesController,
    restoreRoleController,
    updateRoleController
} from "../controllers/role-controller.js";

export const roleRouter = Router()

roleRouter.get("/", getRolesController)
roleRouter.get("/trash", getDeletedRolesController)
roleRouter.get("/:id", getRoleByIdController)

roleRouter.put("/trash/:id", restoreRoleController)
roleRouter.put("/:id", updateRoleController)

roleRouter.post("/", createRoleController)

roleRouter.delete("/:id", deleteRoleController)
roleRouter.delete("/delete/:id", destroyRoleController)

