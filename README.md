# 🎓 IPDN Graduation Clearance System (SIPUSTA)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Status](https://img.shields.io/badge/Status-Active_Production-success?style=for-the-badge)

## 📌 Project Overview
Sistem Informasi Bebas Pustaka (SIPUSTA) adalah gerbang arsitektur *backend* krusial yang digunakan sebagai syarat mutlak yudisium dan pendaftaran wisuda di Institut Pemerintahan Dalam Negeri (IPDN). Sistem ini menangani alur *clearance* (bebas pinjaman) secara terpusat, mengintegrasikan data antara Perpustakaan Pusat dan berbagai Perpustakaan Fakultas, serta mengelola pengumpulan arsip tugas akhir secara digital.

## ✨ Core Architecture & Business Value
Aplikasi ini berskala institusi dengan **13 Modul Utama** dan **5 Modul Pendukung**, dirancang untuk memastikan nol toleransi terhadap kesalahan data kelulusan.
*   **Centralized Clearance Gateway:** Algoritma *conditional logic* yang mengunci status kelulusan Praja (mahasiswa) hingga seluruh tahapan verifikasi dokumen dan donasi dari berbagai cabang perpustakaan terpenuhi.
*   **Digital Archive Management:** Modul pemrosesan dan penyimpanan *soft-copy* serta *hard-copy* tugas akhir dengan sistem pelacakan (tracking) status penyerahan.
*   **Multi-Role Authorization:** Sistem manajemen hak akses ketat yang memisahkan otoritas antara Admin Pusat, Admin Fakultas, dan Praja.
*   **Long-Term Maintenance & Scalability:** Dibangun dengan standar *clean code* Laravel, memungkinkan sistem terus beroperasi stabil dan terus menerima pembaruan modul tanpa mengganggu *data integrity* tahun-tahun sebelumnya.

## 🛠️ Tech Stack
*   **Framework:** Laravel (Blade & RESTful API)
*   **Database:** MySQL (Complex Relational Queries & Transactional Safety)
*   **Environment:** Linux Server / Cpanel / aaPanel

## 💡 System Analyst Notes
> "Tantangan terbesar dalam mengembangkan sistem ini adalah membangun arsitektur *database* yang mampu menjembatani berbagai aturan spesifik dari masing-masing fakultas ke dalam satu gerbang *clearance* terpusat. Saya mendesain skema relasional yang fleksibel namun ketat, memastikan setiap Praja yang tervalidasi oleh sistem ini 100% bersih dari tanggungan institusi secara *real-time*."

---
*Architected & Actively Maintained by [Nama Kamu] - Independent IT Consultant & System Analyst*
