require('dotenv/config')
const logger = require('./application/log');
const app = require("./application/server");



app.listen(process.env.APP_PORT, () => { logger.info(`Server Running at ${process.env.APP_HOST}:${process.env.APP_PORT}`) })