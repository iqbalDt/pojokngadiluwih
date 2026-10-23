from typing import List
from fastapi import FastAPI, HTTPException, status
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel, Field

from app.config import GEMINI_MODEL, GOOGLE_API_KEY, KNOWLEDGE_BASE_DIR
from app.rag_chain import answer_question
from app.vector_store import build_and_persist_vector_store

# Inisialisasi FastAPI
app = FastAPI(
    title="PojokNgadiluwih AI Conversational Service",
    description="Layanan AI RAG berbasis Google Gemini untuk Asisten Virtual Desa Ngadiluwih",
    version="1.0.0",
)

# Konfigurasi CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


# Schema Request & Response
class ChatRequest(BaseModel):
    message: str = Field(
        ...,
        min_length=1,
        description="Pesan atau pertanyaan dari warga",
        example="Bagaimana syarat membuat surat keterangan usaha (SKU)?",
    )


class ChatResponse(BaseModel):
    reply: str = Field(description="Jawaban dari Asisten AI Desa Ngadiluwih")
    source_context: List[str] = Field(
        default_factory=list,
        description="Kutipan teks dokumen resmi yang dijadikan acuan jawaban",
    )


class ReindexResponse(BaseModel):
    status: str
    message: str


# Endpoint Utama
@app.get("/")
def root():
    """Root endpoint untuk memeriksa ketersediaan service."""
    return {
        "service": "PojokNgadiluwih AI Conversational Assistant",
        "engine": f"Google Gemini ({GEMINI_MODEL}) via LangChain",
        "status": "online",
    }


@app.get("/api/health")
def health_check():
    """Health check endpoint."""
    is_key_configured = bool(GOOGLE_API_KEY and GOOGLE_API_KEY != "api-key-kamu-disini")
    return {
        "status": "healthy" if is_key_configured else "warning",
        "api_key_configured": is_key_configured,
        "model": GEMINI_MODEL,
    }



@app.post("/api/chat", response_model=ChatResponse, status_code=status.HTTP_200_OK)
def chat_endpoint(payload: ChatRequest):
    """
    Endpoint pemrosesan pesan tanya-jawab warga menggunakan RAG Chain.
    Menerima JSON {"message": "string"} dan mengembalikan {"reply": "string", "source_context": [...]}.
    """
    try:
        result = answer_question(question=payload.message)
        return ChatResponse(
            reply=result["reply"],
            source_context=result["source_context"],
        )
    except ValueError as ve:
        raise HTTPException(
            status_code=status.HTTP_400_BAD_REQUEST,
            detail=str(ve),
        )
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Terjadi kesalahan saat memproses jawaban AI: {str(e)}",
        )


@app.post("/api/reindex", response_model=ReindexResponse)
def reindex_knowledge_base():
    """
    Endpoint untuk me-refresh dan memperbarui vector database Chroma
    dari dokumen .txt terbaru di direktori knowledge base.
    """
    try:
        from app.rag_chain import reset_rag_cache
        build_and_persist_vector_store()
        reset_rag_cache()
        return ReindexResponse(
            status="success",
            message="Basis pengetahuan AI berhasil diindeks ulang ke ChromaDB.",
        )

    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Gagal melakukan re-index: {str(e)}",
        )


if __name__ == "__main__":
    import uvicorn
    from app.config import HOST, PORT

    uvicorn.run("app.main:app", host=HOST, port=PORT, reload=True)
