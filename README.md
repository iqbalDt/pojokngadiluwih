# PojokNgadiluwih 🌿
> **Portal Informasi Desa Digital & Asisten Cerdas AI (RAG Gemini) Desa Ngadiluwih**

Proyek platform digital terintegrasi untuk Desa Ngadiluwih, menghadirkan layanan administrasi desa, katalog UMKM warga dengan pemesanan langsung ke WhatsApp, berita desa, visualisasi demografi, serta asisten virtual pintar berbasis **FastAPI, LangChain, ChromaDB, dan Google Gemini**.

---

## 📖 Dokumentasi Lengkap
Untuk panduan arsitektur sistem, daftar fitur yang sudah selesai, konfigurasi AI Service, dan instruksi tim, silakan baca:
👉 **[DOKUMENTASI_PROYEK.md](file:///d:/pojokngadiluwih/DOKUMENTASI_PROYEK.md)**

---

## ⚡ Panduan Cepat Menjalankan Proyek

### 1. Web Application (Laravel 12)
```bash
composer install
npm install
npm run build
php artisan migrate
php artisan serve
```
Akses web di: `http://127.0.0.1:8000`

### 2. AI Assistant Service (Python FastAPI)
```bash
cd ai_service
python -m venv .venv
.venv\Scripts\activate
pip install -r requirements.txt
copy .env.example .env
# Masukkan GOOGLE_API_KEY di file .env
uvicorn app.main:app --host 127.0.0.1 --port 8001 --reload
```
Akses Swagger AI di: `http://127.0.0.1:8001/docs`

---

## 🛠️ Tech Stack
- **Web App**: Laravel 12 (PHP 8.4), Tailwind CSS, Blade Components
- **AI Microservice**: Python FastAPI, LangChain, Google GenAI (`gemini-3.8-flash`), ChromaDB, HuggingFace Sentence-Transformers (`all-MiniLM-L6-v2`)
