import os
from typing import Any, Dict, List
from langchain_google_genai import ChatGoogleGenerativeAI

try:
    from langchain_classic.chains import RetrievalQA
except ImportError:
    try:
        from langchain.chains import RetrievalQA
    except ImportError:
        from langchain.chains.retrieval_qa.base import RetrievalQA

try:
    from langchain_core.prompts import PromptTemplate
except ImportError:
    from langchain.prompts import PromptTemplate

from app.config import GOOGLE_API_KEY, GEMINI_MODEL
from app.vector_store import get_vector_store


# Template System Prompt Khusus Asisten AI Desa Ngadiluwih yang Luwes & Cerdas
SYSTEM_PROMPT_TEMPLATE = """Anda adalah "Asisten AI Desa Ngadiluwih", asisten cerdas, ramah, dan solutif pada portal digital PojokNgadiluwih (Kecamatan Ngadiluwih, Kabupaten Kediri, Jawa Timur).

Pedoman Perilaku & Respon Anda:
1. Nalar Cerdas, Luwes & Alami (Gunakan Akal Sehat):
   - Jawablah layaknya asisten manusia yang pintar dan ramah. Gunakan nalar dan logika Anda sendiri untuk menjawab pertanyaan umum, sapaan, percakapan santai, maupun pertanyaan saran/opini.
   - Contoh: Jika warga bertanya "kalo mau nanya2 enakan langsung ke kantor apa disini?", jelaskan dengan bijak bahwa jika hanya mencari info syarat surat, rekomendasi UMKM, atau profil desa, bertanya lewat portal ini sangat praktis 24 jam tanpa perlu repot datang. Namun untuk pengurusan berkas fisik, tanda tangan kepala desa, atau legalisir, warga tetap perlu datang langsung ke kantor balai desa pada jam kerja (Senin-Jumat, 08.00-15.00 WIB).
   - Jangan pernah mengulang-ulang jawaban template kaku yang membosankan.

2. Rujukan Konteks Resmi Desa:
   - Untuk pertanyaan seputar layanan administrasi surat (SKU, SKCK, Surat Domisili, SKTM), profil aparatur/kepala desa (Bapak H. Bambang Sutrisno, S.E.), direktori UMKM warga, dan jam kantor, utamakan fakta pada "Konteks Dokumen Resmi Desa" di bawah.
   - Sampaikan langkah-langkah atau syarat surat secara jelas, terstruktur, dan mudah dipahami warga.

3. Pertanyaan Umum / Di Luar Desa:
   - Jika warga bertanya hal umum (seperti hari, salam, atau tanya santai), jawablah secara singkat, ramah, dan tetap bersahabat, lalu tawarkan bantuan seputar layanan desa jika diperlukan.

Konteks Dokumen Resmi Desa:
{context}

Pertanyaan Warga: {question}

Jawaban Asisten AI:"""

_RAG_CHAIN = None
_CURRENT_MODEL_NAME = None

FALLBACK_MODELS = [
    "gemini-3.5-flash-lite",
    "gemini-flash-lite-latest",
    "gemini-3.5-flash",
]


def reset_rag_cache() -> None:
    """Mereset cache RAG chain saat dokumen atau model diperbarui."""
    global _RAG_CHAIN, _CURRENT_MODEL_NAME
    _RAG_CHAIN = None
    _CURRENT_MODEL_NAME = None


def create_chain_for_model(model_name: str) -> RetrievalQA:
    """Membuat instance RetrievalQA Chain untuk model tertentu."""
    vector_store = get_vector_store()
    retriever = vector_store.as_retriever(
        search_type="similarity",
        search_kwargs={"k": 3},
    )

    llm = ChatGoogleGenerativeAI(
        model=model_name,
        google_api_key=GOOGLE_API_KEY,
        max_output_tokens=768,
    )

    prompt = PromptTemplate(
        template=SYSTEM_PROMPT_TEMPLATE,
        input_variables=["context", "question"],
    )

    return RetrievalQA.from_chain_type(
        llm=llm,
        chain_type="stuff",
        retriever=retriever,
        return_source_documents=True,
        chain_type_kwargs={"prompt": prompt},
    )


def get_rag_chain(preferred_model: str = None) -> RetrievalQA:
    """Menginisialisasi RetrievalQA Chain dengan Google Gemini dan Chroma Vector Store (singleton)."""
    global _RAG_CHAIN, _CURRENT_MODEL_NAME

    target_model = preferred_model or GEMINI_MODEL or "gemini-3.5-flash-lite"

    if _RAG_CHAIN is not None and _CURRENT_MODEL_NAME == target_model:
        return _RAG_CHAIN

    if not GOOGLE_API_KEY or GOOGLE_API_KEY == "api-key-kamu-disini":
        raise ValueError(
            "GOOGLE_API_KEY belum disetel atau masih berupa placeholder. "
            "Harap isi GOOGLE_API_KEY yang valid di file .env!"
        )

    _RAG_CHAIN = create_chain_for_model(target_model)
    _CURRENT_MODEL_NAME = target_model
    return _RAG_CHAIN


def extract_reply_text(reply_raw: Any) -> str:
    """Mengekstrak teks jawaban dari berbagai format return LangChain/Gemini."""
    if isinstance(reply_raw, list):
        text_parts = []
        for part in reply_raw:
            if isinstance(part, dict) and "text" in part:
                text_parts.append(part["text"])
            elif isinstance(part, str):
                text_parts.append(part)
        return "\n".join(text_parts).strip()
    return str(reply_raw).strip()


def answer_question(question: str) -> Dict[str, Any]:
    """Menjalankan query ke RAG Chain dengan fallback model otomatis jika terjadi kendala kuota."""
    candidate_models = [GEMINI_MODEL] if GEMINI_MODEL else []
    for m in FALLBACK_MODELS:
        if m not in candidate_models:
            candidate_models.append(m)

    last_error = None

    for model_name in candidate_models:
        try:
            chain = get_rag_chain(preferred_model=model_name)
            response = chain.invoke({"query": question})

            reply = extract_reply_text(response.get("result", ""))
            if not reply:
                reply = "Maaf, saat ini saya belum dapat menyusun jawaban. Silakan ulangi pertanyaan Anda."

            source_documents = response.get("source_documents", [])
            source_context: List[str] = []
            for doc in source_documents:
                content = doc.page_content.strip()
                if content and content not in source_context:
                    source_context.append(content)

            return {
                "reply": reply,
                "source_context": source_context,
                "model_used": model_name,
            }

        except Exception as e:
            last_error = e
            reset_rag_cache()
            # Coba model berikutnya jika terjadi rate limit / quota exhausted
            continue

    # Jika semua model Google gagal
    raise RuntimeError(f"Gagal memproses jawaban dari seluruh model AI: {str(last_error)}")
