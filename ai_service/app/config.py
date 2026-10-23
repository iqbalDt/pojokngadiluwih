import os
from pathlib import Path
from dotenv import load_dotenv

# Base directory proyek ai_service
BASE_DIR = Path(__file__).resolve().parent.parent

# Load file .env jika ada
ENV_PATH = BASE_DIR / ".env"
load_dotenv(dotenv_path=ENV_PATH)

# Google Gemini API Key & Model
GOOGLE_API_KEY = os.getenv("GOOGLE_API_KEY", "")
GEMINI_MODEL = os.getenv("GEMINI_MODEL", "gemini-3.5-flash-lite")

# Direktori Vector Store & Knowledge Base
CHROMA_DB_DIR = os.getenv("CHROMA_DB_DIR", str(BASE_DIR / "data" / "chroma_db"))
KNOWLEDGE_BASE_DIR = os.getenv("KNOWLEDGE_BASE_DIR", str(BASE_DIR / "data" / "knowledge_base"))

# Server Config
HOST = os.getenv("HOST", "0.0.0.0")
PORT = int(os.getenv("PORT", "8001"))

# Pastikan direktori data selalu ada
os.makedirs(CHROMA_DB_DIR, exist_ok=True)
os.makedirs(KNOWLEDGE_BASE_DIR, exist_ok=True)
