/*
  Warnings:

  - The primary key for the `Users` table will be changed. If it partially fails, the table could be left without primary key constraint.
  - A unique constraint covering the columns `[USER_EMAIL]` on the table `Users` will be added. If there are existing duplicate values, this will fail.
  - Added the required column `USER_EMAIL` to the `Users` table without a default value. This is not possible if the table is not empty.
  - Added the required column `USER_ROLE` to the `Users` table without a default value. This is not possible if the table is not empty.

*/
-- AlterTable
ALTER TABLE `Users` DROP PRIMARY KEY,
    ADD COLUMN `USER_EMAIL` VARCHAR(255) NOT NULL,
    ADD COLUMN `USER_ROLE` VARCHAR(191) NOT NULL,
    MODIFY `USER_ID` VARCHAR(191) NOT NULL,
    MODIFY `USER_TOKEN` VARCHAR(191) NOT NULL,
    ALTER COLUMN `USER_LAST_LOGIN` DROP DEFAULT,
    ADD PRIMARY KEY (`USER_ID`);

-- CreateTable
CREATE TABLE `Roles` (
    `ROLE_ID` VARCHAR(191) NOT NULL,
    `ROLE_NAME` VARCHAR(150) NOT NULL,
    `ROLE_CREATED_AT` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    `ROLE_UPDATED_AT` DATETIME(3),
    `ROLE_IS_DELETED` BOOLEAN NOT NULL DEFAULT false,

    UNIQUE INDEX `Roles_ROLE_NAME_key`(`ROLE_NAME`),
    PRIMARY KEY (`ROLE_ID`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateIndex
CREATE UNIQUE INDEX `Users_USER_EMAIL_key` ON `Users`(`USER_EMAIL`);

-- AddForeignKey
ALTER TABLE `Users` ADD CONSTRAINT `Users_USER_ROLE_fkey` FOREIGN KEY (`USER_ROLE`) REFERENCES `Roles`(`ROLE_ID`) ON DELETE RESTRICT ON UPDATE CASCADE;
