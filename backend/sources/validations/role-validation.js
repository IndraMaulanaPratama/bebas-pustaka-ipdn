import Joi from "joi";

export const createRoleValidator = Joi.object({
    name: Joi.string().max(150).required(),
})

export const updateRoleValidator = Joi.object({
    name: Joi.string().max(150).required(),
})