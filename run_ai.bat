@echo OFF
title PojokNgadiluwih AI Service (Port 8001)
echo ===================================================
echo Menjalankan PojokNgadiluwih AI Service di Port 8001
echo ===================================================
cd /d "%~dp0ai_service"
".venv\Scripts\uvicorn.exe" app.main:app --host 127.0.0.1 --port 8001 --reload
pause

