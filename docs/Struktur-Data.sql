/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET SQL_NOTES=0 */;
DROP TABLE IF EXISTS dosen;
CREATE TABLE "dosen" (
  "nim" bigint unsigned NOT NULL AUTO_INCREMENT,
  "nama" varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  "kontak" bigint NOT NULL,
  "email" varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL,
  PRIMARY KEY ("nim"),
  UNIQUE KEY "dosen_email_unique" ("email")
);

DROP TABLE IF EXISTS dosen_matakuliah;
CREATE TABLE "dosen_matakuliah" (
  "id" bigint unsigned NOT NULL AUTO_INCREMENT,
  "id_dosen" bigint unsigned NOT NULL,
  "id_matakuliah" bigint unsigned NOT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL,
  PRIMARY KEY ("id"),
  KEY "dosen_matakuliah_id_dosen_foreign" ("id_dosen"),
  KEY "dosen_matakuliah_id_matakuliah_foreign" ("id_matakuliah"),
  CONSTRAINT "dosen_matakuliah_id_dosen_foreign" FOREIGN KEY ("id_dosen") REFERENCES "dosen" ("nim") ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT "dosen_matakuliah_id_matakuliah_foreign" FOREIGN KEY ("id_matakuliah") REFERENCES "matakuliah" ("kode") ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS dosen_pembimbing;
CREATE TABLE "dosen_pembimbing" (
  "id" bigint unsigned NOT NULL AUTO_INCREMENT,
  "id_dosen" bigint unsigned NOT NULL,
  "id_mahasiswa" bigint unsigned NOT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL,
  PRIMARY KEY ("id"),
  KEY "dosen_pembimbing_id_dosen_foreign" ("id_dosen"),
  KEY "dosen_pembimbing_id_mahasiswa_foreign" ("id_mahasiswa"),
  CONSTRAINT "dosen_pembimbing_id_dosen_foreign" FOREIGN KEY ("id_dosen") REFERENCES "dosen" ("nim") ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT "dosen_pembimbing_id_mahasiswa_foreign" FOREIGN KEY ("id_mahasiswa") REFERENCES "mahasiswa" ("nim") ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS mahasiswa;
CREATE TABLE "mahasiswa" (
  "nim" bigint unsigned NOT NULL AUTO_INCREMENT,
  "nama" varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  "kontak" bigint NOT NULL,
  "email" varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  "alamat" varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL,
  PRIMARY KEY ("nim"),
  UNIQUE KEY "mahasiswa_email_unique" ("email")
);

DROP TABLE IF EXISTS matakuliah;
CREATE TABLE "matakuliah" (
  "kode" bigint unsigned NOT NULL AUTO_INCREMENT,
  "nama_matakuliah" varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  "daya_tampung" bigint unsigned NOT NULL,
  "jadwal" datetime NOT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL,
  PRIMARY KEY ("kode")
);

DROP TABLE IF EXISTS matakuliah_mahasiswa;
CREATE TABLE "matakuliah_mahasiswa" (
  "id" bigint unsigned NOT NULL AUTO_INCREMENT,
  "id_mahasiswa" bigint unsigned NOT NULL,
  "id_matakuliah" bigint unsigned NOT NULL,
  "created_at" timestamp NULL DEFAULT NULL,
  "updated_at" timestamp NULL DEFAULT NULL,
  PRIMARY KEY ("id"),
  KEY "matakuliah_mahasiswa_id_matakuliah_foreign" ("id_matakuliah"),
  KEY "matakuliah_mahasiswa_id_mahasiswa_foreign" ("id_mahasiswa"),
  CONSTRAINT "matakuliah_mahasiswa_id_mahasiswa_foreign" FOREIGN KEY ("id_mahasiswa") REFERENCES "mahasiswa" ("nim") ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT "matakuliah_mahasiswa_id_matakuliah_foreign" FOREIGN KEY ("id_matakuliah") REFERENCES "matakuliah" ("kode") ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS migrations;
CREATE TABLE "migrations" (
  "id" int unsigned NOT NULL AUTO_INCREMENT,
  "migration" varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  "batch" int NOT NULL,
  PRIMARY KEY ("id")
);