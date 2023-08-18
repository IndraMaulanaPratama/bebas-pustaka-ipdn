import { logger } from "../applications/logger.js"
import { createRole, deleteRole, destroyRole, getDeletedRoles, getRoleById, getRoles, restoreRole, updateRole } from "../services/role-service.js"
import { updateRoleValidator } from "../validations/role-validation.js"
import { validation } from "../validations/validation.js"

export const createRoleController = async (req, res, next) => {
    try {
        const { body } = req
        const result = await createRole(body)

        res.status(200)
            .json({
                message: `Role baru berhasil dibuat`,
                data: result
            })
    } catch (error) {
        next(error)
    }
}

export const getRolesController = async (req, res, next) => {
    try {
        const result = await getRoles()

        res.status(200)
            .json({
                message: `Membaca semua data role`,
                data: result
            })
    } catch (error) {
        next(error)
    }
}

export const getRoleByIdController = async (req, res, next) => {
    try {
        const params = req.params
        const result = await getRoleById(params)

        res.status(200)
            .json({
                message: `Membaca semua data role`,
                data: result
            })
    } catch (error) {
        next(error)
    }
}

export const updateRoleController = async (req, res, next) => {
    try {
        const { params, body } = req
        const result = await updateRole({ params, body })

        res.status(200)
            .json({
                message: `Data role berhasil di update`,
                data: result
            })

    } catch (error) {
        next(error)
    }
}

export const deleteRoleController = async (req, res, next) => {
    try {

        // Inisialisasi Parameter
        const { params } = req

        // Menjalankan service delete role
        await deleteRole(params)

        // Response Sukses Penghapusan Data Role
        res.status(200)
            .json({
                message: `Data role berhasil dihapuskan`
            })
    } catch (error) {
        next(error)
    }
}

export const destroyRoleController = async (req, res, next) => {
    try {

        // Inisialisasi Parameter
        const { params } = req

        // Menjalankan service delete role
        await destroyRole(params)

        // Response Sukses Penghapusan Data Role
        res.status(200)
            .json({
                message: `Data role berhasil dihapuskan`
            })
    } catch (error) {
        next(error)
    }
}

export const getDeletedRolesController = async (req, res, next) => {
    try {
        const result = await getDeletedRoles()

        res.status(200)
            .json({
                message: `Membaca semua data role yang tidak aktif`,
                data: result
            })
    } catch (error) {
        next(error)
    }
}

export const restoreRoleController = async (req, res, next) => {
    try {
        // Mengambil query string dari route
        const { params } = req

        // Menjalankan service restore data role
        const result = await restoreRole(params)

        // Mengembalikan response sukses
        res.status(200).json({
            message: `Data role yang anda pilih, berhasil dipulihkan`,
            data: result
        })

    } catch (error) {
        next(error)
    }
}