# 🎓 SIPUSTA - Institutional Clearance & Archiving System

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-4e56a6?style=for-the-badge&logo=livewire&logoColor=white)
![Security](https://img.shields.io/badge/Security-JWT%20%7C%202FA-success?style=for-the-badge)
![Database](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

## 📌 Project Overview
Sistem Informasi Bebas Pustaka (SIPUSTA) adalah gerbang arsitektur *backend* berskala institusi yang digunakan sebagai syarat mutlak yudisium dan pendaftaran wisuda di Institut Pemerintahan Dalam Negeri (IPDN). Sistem ini mengintegrasikan alur *clearance* (bebas pinjaman) secara terpusat dari berbagai fakultas, sekaligus memproses manajemen arsip digital secara *real-time* dengan standar keamanan *enterprise*.

## ✨ Core Architecture & Enterprise Features
Sistem ini terdiri dari **13 Modul Utama** dan **5 Modul Pendukung**, dirancang dengan fokus pada integritas data, keamanan berlapis, dan pemrosesan yang responsif.

*   **Advanced Security Matrix:** Menerapkan lapisan keamanan kelas atas menggunakan **JSON Web Token (JWT)** untuk komunikasi API yang *stateless*, integrasi **Google Auth**, perlindungan **reCAPTCHA**, dan **Two-Factor Authentication (2FA)** untuk mencegah akses tidak sah ke data kelulusan yang sangat sensitif.
*   **Real-Time Data Processing:** Menggunakan **Laravel Livewire** untuk menghadirkan pengalaman antarmuka yang sangat reaktif (SPA-like experience) dan *user-friendly*, memungkinkan perubahan status dokumen dan *clearance* terjadi secara seketika tanpa membebani muatan *server*.
*   **Adaptive Multi-Role Access (RBAC):** Sistem otorisasi dinamis yang menyesuaikan antarmuka dan hak akses secara otomatis (Super Admin, Verifikator Fakultas, dan Praja) dengan desain yang 100% responsif di berbagai perangkat.
*   **Centralized Clearance Gateway:** Algoritma verifikasi bersyarat yang mengunci kelayakan wisuda secara sistematis hingga seluruh kewajiban administrasi dan donasi perpustakaan terpenuhi tanpa celah kecurangan.

## 🛠️ Tech Stack & Environment
*   **Core Framework:** Laravel (RESTful API & Backend Logic)
*   **Frontend Reactivity:** Laravel Livewire (Real-time DOM manipulation)
*   **Authentication & Security:** JWT, 2FA, Google OAuth, reCAPTCHA
*   **Database:** MySQL (Complex Relational Queries & Transactional Safety)

## 💡 System Analyst Notes
> "Tantangan terbesar dalam membangun ekosistem institusi ini adalah menyeimbangkan antara keamanan tingkat tinggi dengan kemudahan penggunaan (*user experience*). Dengan mengimplementasikan 2FA dan JWT, sistem dikunci sangat rapat. Namun, berkat injeksi komponen Livewire, pemrosesan data verifikasi dokumen yang sangat masif tetap terasa ringan, *real-time*, dan adaptif bagi ratusan *user* yang mengaksesnya secara bersamaan menjelang masa yudisium."

## 🚀 Roadmap & Ongoing AI Integration
Sistem ini sedang dalam tahap evolusi menuju *smart institutional ecosystem*. Pembaruan yang sedang dalam tahap inkubasi difokuskan pada otomatisasi dan peningkatan *AI-driven User Experience*:

*   **Enterprise WhatsApp API (via PT. Mekari Qontak):** Implementasi *webhook* untuk pengiriman notifikasi *real-time* ke WhatsApp Praja terkait perubahan status dokumen, persetujuan verifikator, dan pengingat batas waktu yudisium.
*   **AI-Powered Virtual Assistant (RAG Implementation):** Mengintegrasikan *Large Language Model* (LLM) dengan arsitektur *Retrieval-Augmented Generation* (RAG). Chatbot cerdas ini sedang dilatih menggunakan *database* internal (SOP Institusi & Panduan Bebas Pustaka) untuk bertindak sebagai asisten virtual 24/7.
*   **Automated Helpdesk:** AI akan merespons pertanyaan spesifik dari ratusan pengguna secara otomatis dan presisi berdasarkan dokumen resmi, memangkas beban kerja admin kampus hingga 80% pada masa sibuk pendaftaran wisuda.

---
*Architected & Actively Maintained by [Indra MAulana Pratama] - System Analyst & Security-Minded Developer*
