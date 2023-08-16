import supertest from "supertest";
import { app } from "../applications/app.js"
import { logger } from "../applications/logger.js";
import { connection } from "../applications/connection.js";

describe('GET /role/', () => {
    it('should response all data active role', async () => {
        const result = await supertest(app)
            .get("/role/")

        expect(result.status).toBe(200);
        expect(result.body.message).toBe(`Membaca semua data role`);
        expect(result.body.data).toBeDefined();
    });
});

describe('GET /role/trash', () => {
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