# 🤖 PojokNgadiluwih AI Service

Service kecerdasan buatan berbasis **FastAPI**, **LangChain**, **ChromaDB**, dan **Google Gemini API** yang melayani tanya-jawab chatbot warga Desa Ngadiluwih.

---

## 🔑 Panduan Lengkap: Cara Mendapatkan Google Gemini API Key (100% Gratis)

Untuk mengaktifkan otak AI, Anda membutuhkan **API Key** resmi dari Google:

1. **Buka Google AI Studio**
   Kunjungi link berikut di browser Anda:  
   👉 **[https://aistudio.google.com/](https://aistudio.google.com/)**

2. **Login Akun Google**
   Masuk menggunakan akun Google / Gmail Anda.

3. **Buat API Key**
   - Di dashboard Google AI Studio, klik tombol **"Get API key"** (biasanya di pojok kiri atas / sidebar).
   - Klik tombol **"Create API key"**.
   - Pilih opsi **"Create API key in new project"** (atau pilih project Google Cloud yang sudah ada).
   - Tunggu beberapa detik sampai jendela pop-up menampilkan API Key Anda (diawali dengan kode `AIzaSy...`).

4. **Salin & Tempel ke file `.env`**
   - Klik tombol **Copy** untuk menyalin kode API Key.
   - Buka file [`.env`](.env) di dalam folder `ai_service/` ini.
   - Ganti teks `"api-key-kamu-disini"` dengan kode API Key Anda:
     ```env
     GOOGLE_API_KEY="AIzaSyXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
     ```
   - Simpan file (tekan `Ctrl + S`).

---

## 🚀 Cara Menjalankan AI Service

### Pilihan 1: Paling Mudah (Sekali Klik)
Cukup jalankan script batch yang sudah disiapkan:
- Dari dalam folder `ai_service/`, klik dua kali file **`run.bat`** (atau ketik `.\run.bat` di terminal).
- Atau dari folder utama proyek `d:\pojokNgadiluwih`, klik dua kali file **`run_ai.bat`**.

### Pilihan 2: Lewat Terminal PowerShell
```powershell
cd d:\pojokNgadiluwih\ai_service
.\.venv\Scripts\uvicorn.exe app.main:app --host 127.0.0.1 --port 8001 --reload
```

---

## 🌐 Endpoint & Dokumentasi Interaktif
Setelah service berjalan:
- Status Service: **http://127.0.0.1:8001/**
- Health Check: **http://127.0.0.1:8001/api/health**
- Swagger UI (Dokumentasi API): **http://127.0.0.1:8001/docs**

