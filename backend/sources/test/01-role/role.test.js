import supertest from "supertest";
import { app } from "../../applications/app.js"
import { logger } from "../../applications/logger.js";
import { connection } from "../../applications/connection.js";
import { v4 as uuid } from "uuid";

describe('GET /role/', () => {
    // membuat dummy data dengan status active
    beforeEach(async () => {
        await connection.roles.create({
            data: {
                ROLE_ID: uuid(),
                ROLE_NAME: `active-role`,
                ROLE_IS_DELETED: false,
            }
        })
    })

    afterEach(async () => {
        await connection.roles.deleteMany({
            where: { ROLE_NAME: `active-role` }
        })
    })

    it('should response all data active role', async () => {
        const result = await supertest(app)
            .get("/role/")

        expect(result.status).toBe(200);
        expect(result.body.message).toBe(`Membaca semua data role`);
        expect(result.body.data).toBeDefined();
    });
});

describe('GET /role/trash', () => {
    // Membuat dummy data dengan status deleted
    beforeEach(async () => {
        await connection.roles.create({
            data: {
                ROLE_ID: uuid(),
                ROLE_NAME: `deleted-role`,
                ROLE_IS_DELETED: true,
            }
        })
    })

    // Menghapus dummy data
    afterEach(async () => {
        await connection.roles.deleteMany({
            where: { ROLE_NAME: `deleted-role` }
        })
    })

    it('should response all data deleted role', async () => {
        const result = await supertest(app)
            .get("/role/trash")

        expect(result.status).toBe(200);
        expect(result.body.message).toBe(`Membaca semua data role yang tidak aktif`);
        expect(result.body.data).toBeDefined();
    });
});

describe('POST /', () => {

    // Remove dummy data after running test
    afterEach(async () => {
        await connection.roles.deleteMany({
            where: { ROLE_NAME: `role-test` }
        })
    })


    it('should reject if request is invalid', async () => {
        const result = await supertest(app)
            .post("/role/")
            .send({
                name: ""
            })

        logger.warn(result.body)
        expect(result.status).toBe(400);
        expect(result.body.errors).toBeDefined();
    });

    it('should create new role', async () => {
        const result = await supertest(app)
            .post("/role/")
            .send({
                name: "role-test",
            })

        expect(result.status).toBe(200);
        expect(result.body.message).toBeDefined();
        expect(result.body.message).toBe(`Role baru berhasil dibuat`);
    });

    it('should reject becouse duplicate role name', async () => {
        let result = await supertest(app)
            .post("/role/")
            .send({
                name: `role-test`
            })

        expect(result.status).toBe(200);

        result = await supertest(app)
            .post("/role/")
            .send({
                name: `role-test`
            })

        expect(result.status).toBe(400);
        expect(result.body.errors).toBe(`Nama role yang anda masukan sudah terdaftar`);
    });
});

describe('PUT /role/:id', () => {
    // Membuat data dummy dengan status active
    beforeEach(async () => {
        await connection.roles.createMany({
            data: [
                {
                    ROLE_ID: `dummy-role`,
                    ROLE_NAME: `dummy-role`,
                    ROLE_IS_DELETED: false
                },
                {
                    ROLE_ID: `dummy-role-2`,
                    ROLE_NAME: `dummy-role-2`,
                    ROLE_IS_DELETED: true
                }
            ], skipDuplicates: true
        })
    })

    // Menghapus data dummy dengan nama update-role
    afterEach(async () => {
        await connection.roles.deleteMany({
            where: {
                ROLE_ID: { contains: `dummy-role` }
            }
        })
    })

    it('should reject process becouse id role not found', async () => {
        const result = await supertest(app).put(`/role/rolenotfound`)
            .send({
                name: `success-update-role`
            })

        expect(result.status).toBe(400);
        expect(result.body.errors).toBeDefined();
    });

    it('should rejected becouse failed mandatory validation', async () => {
        const result = await supertest(app)
            .put(`/role/update-role`)
            .send({ test_mandatory: null })

        expect(result.status).toBe(400);
        expect(result.body.errors).toBeDefined();
    });

    it('should rejected becouse status role is inactive', async () => {
        const result = await supertest(app)
            .put(`/role/dummy-update`)
            .send({
                name: `successed-update-role`
            })

        expect(result.status).toBe(400);
        expect(result.body.errors).toBeDefined();
    });

    it('should updated data dummy role', async () => {
        const result = await supertest(app)
            .put(`/role/dummy-role`)
            .send({
                name: `success-update-role`
            })

        expect(result.status).toBe(200);
        expect(result.body.message).toBeDefined();
        expect(result.body.message).toBe("Data role berhasil di update");
    });
});