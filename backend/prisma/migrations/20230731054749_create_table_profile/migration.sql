/*
  Warnings:

  - A unique constraint covering the columns `[USER_PROFILE]` on the table `Users` will be added. If there are existing duplicate values, this will fail.
  - Added the required column `USER_PROFILE` to the `Users` table without a default value. This is not possible if the table is not empty.

*/
-- AlterTable
ALTER TABLE `Users` ADD COLUMN `USER_PROFILE` VARCHAR(191) NOT NULL;

-- CreateTable
CREATE TABLE `Profile` (
    `PROFILE_ID` VARCHAR(191) NOT NULL,
    `PROFILE_NAME` VARCHAR(255) NOT NULL,
    `PROFILE_ADDRESS` TEXT NOT NULL,
    `PROFILE_PHONE_NUMBER` VARCHAR(15) NOT NULL,

    PRIMARY KEY (`PROFILE_ID`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateIndex
CREATE UNIQUE INDEX `Users_USER_PROFILE_key` ON `Users`(`USER_PROFILE`);

-- AddForeignKey
ALTER TABLE `Users` ADD CONSTRAINT `Users_USER_PROFILE_fkey` FOREIGN KEY (`USER_PROFILE`) REFERENCES `Profile`(`PROFILE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
