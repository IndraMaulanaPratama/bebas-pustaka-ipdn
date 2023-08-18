import Joi from "joi";

export const registerValidator = Joi.object({
    username: Joi.string().max(100).required(),
    password: Joi.string().max(100).required(),
    email: Joi.string().email().required(),
    name: Joi.string().max(150).required(),
    address: Joi.string().required(),
    phone_number: Joi.number().max(13).required()
})