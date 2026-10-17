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

from app.config import GOOGLE_API_KEY
from app.vector_store import get_vector_store


# Template System Prompt Khusus Asisten AI Desa Ngadiluwih
SYSTEM_PROMPT_TEMPLATE = """Anda adalah "Asisten AI Desa Ngadiluwih", asisten virtual cerdas dan ramah di portal digital PojokNgadiluwih (Kecamatan Ngadiluwih, Kabupaten Kediri, Jawa Timur).

Pedoman Perilaku & Respon Anda:
1. Sapaan & Pertanyaan Umum / Panduan Chatbot:
   - Jika warga menyapa (contoh: "Halo", "Selamat pagi", "Permisi") atau menanyakan pertanyaan umum seperti:
     * "Saya bisa nanya apa aja disini?"
     * "Kamu bisa bantu apa?"
     * "Fitur apa saja yang tersedia?"
     Jawablah dengan hangat, ramah, dan jelaskan bahwa Anda siap membantu memberikan informasi resmi Desa Ngadiluwih, antara lain:
     a) Panduan & Syarat Surat Administrasi Desa (Surat Keterangan Usaha/SKU, Pengantar SKCK, Surat Domisili, SKTM).
     b) Rekomendasi & Kontak Pemesanan Produk UMKM Warga (Kuliner, Madu Murni, Anyaman Bambu, Sambal Pecel) dengan Direct WhatsApp.
     c) Cara mendaftarkan toko UMKM baru ke portal desa.
     d) Profil desa, visi & misi, struktur perangkat desa, dan wilayah 4 dusun (Krajan, Wonorejo, Sukorejo, Karangrejo).
     e) Jam pelayanan kantor balai desa (Senin - Jumat, 08.00 - 15.00 WIB).
     Sertakan contoh pertanyaan yang bisa ditanyakan warga agar mereka terarah dengan jelas.

2. Jawaban Berdasarkan Fakta Dokumen:
   - Untuk pertanyaan seputar surat, UMKM, jadwal, atau profil desa, jawablah secara akurat sesuai Dokumen Konteks di bawah ini.
   - Jika merekomendasikan UMKM, sertakan nama toko, pemilik, dusun, kisaran harga, dan nomor WhatsApp penjual untuk pemesanan langsung.

3. Mengarahkan Saat Informasi Belum Tersedia (Anti-Halusinasi):
   - Jika pertanyaan warga benar-benar di luar konteks desa (misalnya: topik gosip, resep masakan luar negeri, politik nasional):
     Sampaikan dengan sopan bahwa Anda adalah asisten khusus portal digital Desa Ngadiluwih, lalu arahkan warga kembali ke topik-topik desa yang dapat Anda jawab.

Konteks Dokumen Resmi Desa:
{context}

Pertanyaan Warga: {question}

Jawaban Asisten AI Desa Ngadiluwih:"""

_RAG_CHAIN = None


def reset_rag_cache() -> None:
    """Mereset cache RAG chain saat dokumen diperbarui."""
    global _RAG_CHAIN
    _RAG_CHAIN = None


def get_rag_chain() -> RetrievalQA:
    """Menginisialisasi RetrievalQA Chain dengan Google Gemini dan Chroma Vector Store (singleton)."""
    global _RAG_CHAIN
    if _RAG_CHAIN is not None:
        return _RAG_CHAIN

    if not GOOGLE_API_KEY or GOOGLE_API_KEY == "api-key-kamu-disini":
        raise ValueError(
            "GOOGLE_API_KEY belum disetel atau masih berupa placeholder. "
            "Harap isi GOOGLE_API_KEY yang valid di file .env!"
        )

    # 1. Load ChromaDB sebagai Retriever
    vector_store = get_vector_store()
    retriever = vector_store.as_retriever(
        search_type="similarity",
        search_kwargs={"k": 4},
    )

    # 2. Setup LLM Gemini (ChatGoogleGenerativeAI)
    model_name = os.getenv("GEMINI_MODEL", "gemini-3.8-flash")
    llm = ChatGoogleGenerativeAI(
        model=model_name,
        google_api_key=GOOGLE_API_KEY,
        temperature=0.3,
        max_output_tokens=1024,
    )

    # 3. Setup Custom Prompt
    prompt = PromptTemplate(
        template=SYSTEM_PROMPT_TEMPLATE,
        input_variables=["context", "question"],
    )

    # 4. Bangun RetrievalQA Chain
    qa_chain = RetrievalQA.from_chain_type(
        llm=llm,
        chain_type="stuff",
        retriever=retriever,
        return_source_documents=True,
        chain_type_kwargs={"prompt": prompt},
    )

    _RAG_CHAIN = qa_chain
    return qa_chain


def answer_question(question: str) -> Dict[str, Any]:
    """Menjalankan query ke RAG Chain dan mengekstrak balasan serta sumber konteks."""
    chain = get_rag_chain()


    # Eksekusi chain (LangChain invoke)
    response = chain.invoke({"query": question})

    reply_raw = response.get("result", "")
    if isinstance(reply_raw, list):
        text_parts = []
        for part in reply_raw:
            if isinstance(part, dict) and "text" in part:
                text_parts.append(part["text"])
            elif isinstance(part, str):
                text_parts.append(part)
        reply = "\n".join(text_parts)
    else:
        reply = str(reply_raw)

    source_documents = response.get("source_documents", [])

    # Ekstraksi kutipan teks dari dokumen sumber
    source_context: List[str] = []
    for doc in source_documents:
        content = doc.page_content.strip()
        if content and content not in source_context:
            source_context.append(content)

    return {
        "reply": reply,
        "source_context": source_context,
    }
