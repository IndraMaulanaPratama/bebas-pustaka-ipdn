const { PrismaClient, Prisma } = require('@prisma/client')
const logger = require('./log')

const connection = new PrismaClient({
    log: [
        {
            emit: 'event',
            level: 'query',
        },
        {
            emit: 'event',
            level: 'error',
        },
        {
            emit: 'event',
            level: 'info',
        },
        {
            emit: 'event',
            level: 'warn',
        },
    ],

    errorFormat: 'minimal'
})

connection.$on('info', (err) => {
    logger.info(err)
})

connection.$on('query', (err) => {
    logger.query(err)
})

connection.$on('warn', (err) => {
    logger.warn(err)
})

connection.$on('error', (err) => {
    logger.error(err)
})

module.exports = connection