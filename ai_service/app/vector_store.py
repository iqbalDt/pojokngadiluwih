import os
from typing import List

try:
    from langchain_text_splitters import RecursiveCharacterTextSplitter
except ImportError:
    from langchain.text_splitter import RecursiveCharacterTextSplitter

from langchain_community.document_loaders import DirectoryLoader, TextLoader

try:
    from langchain_huggingface import HuggingFaceEmbeddings
except ImportError:
    from langchain_community.embeddings import HuggingFaceEmbeddings

try:
    from langchain_chroma import Chroma
except ImportError:
    from langchain_community.vectorstores import Chroma

try:
    from langchain_core.documents import Document
except ImportError:
    from langchain.schema import Document

from app.config import CHROMA_DB_DIR, KNOWLEDGE_BASE_DIR



# Singleton caches untuk performa tinggi (menghindari re-loading model di setiap query)
_EMBEDDING_MODEL = None
_VECTOR_STORE = None


def get_embedding_model() -> HuggingFaceEmbeddings:
    """Menginisialisasi model text embedding lokal (singleton)."""
    global _EMBEDDING_MODEL
    if _EMBEDDING_MODEL is None:
        _EMBEDDING_MODEL = HuggingFaceEmbeddings(
            model_name="all-MiniLM-L6-v2",
            model_kwargs={"device": "cpu"},
            encode_kwargs={"normalize_embeddings": True},
        )
    return _EMBEDDING_MODEL


def load_knowledge_documents(directory: str = KNOWLEDGE_BASE_DIR) -> List[Document]:
    """Meload seluruh dokumen .txt dari direktori knowledge base."""
    if not os.path.exists(directory):
        os.makedirs(directory, exist_ok=True)

    loader = DirectoryLoader(
        path=directory,
        glob="**/*.txt",
        loader_cls=TextLoader,
        loader_kwargs={"encoding": "utf-8"},
        show_progress=False,
    )
    documents = loader.load()

    # Fallback jika folder knowledge_base masih kosong
    if not documents:
        default_doc = Document(
            page_content=(
                "PojokNgadiluwih adalah portal digital resmi Desa Ngadiluwih, Kecamatan Ngadiluwih, "
                "Kabupaten Kediri, Jawa Timur. Melayani permohonan surat keterangan usaha (SKU), "
                "pengantar SKCK, domisili, direktori UMKM lokal warga, dan kanal aspirasi desa. "
                "Jam pelayanan balai desa: Senin sampai Jumat pukul 08.00 - 15.00 WIB."
            ),
            metadata={"source": "system_default.txt"},
        )
        return [default_doc]

    return documents


def split_documents(
    documents: List[Document],
    chunk_size: int = 800,
    chunk_overlap: int = 150,
) -> List[Document]:
    """Memecah dokumen menjadi potongan teks (chunks) terstruktur."""
    text_splitter = RecursiveCharacterTextSplitter(
        chunk_size=chunk_size,
        chunk_overlap=chunk_overlap,
        separators=["\n\n", "\n", " ", ""],
    )
    return text_splitter.split_documents(documents)


def build_and_persist_vector_store(
    directory: str = KNOWLEDGE_BASE_DIR,
    persist_dir: str = CHROMA_DB_DIR,
) -> Chroma:
    """Meload dokumen teks, memecah, melakukan embedding, dan menyimpan ke ChromaDB."""
    global _VECTOR_STORE
    documents = load_knowledge_documents(directory=directory)
    chunks = split_documents(documents=documents)
    embeddings = get_embedding_model()

    vector_store = Chroma.from_documents(
        documents=chunks,
        embedding=embeddings,
        persist_directory=persist_dir,
    )
    _VECTOR_STORE = vector_store
    return vector_store


def get_vector_store(persist_dir: str = CHROMA_DB_DIR) -> Chroma:
    """Mengambil instance Chroma vector store yang telah tersimpan (singleton)."""
    global _VECTOR_STORE
    if _VECTOR_STORE is not None:
        return _VECTOR_STORE

    embeddings = get_embedding_model()

    # Jika direktori chroma_db sudah berisi indeks
    if os.path.exists(persist_dir) and os.listdir(persist_dir):
        _VECTOR_STORE = Chroma(
            persist_directory=persist_dir,
            embedding_function=embeddings,
        )
        return _VECTOR_STORE

    # Inisialisasi awal jika belum tersedia
    _VECTOR_STORE = build_and_persist_vector_store(persist_dir=persist_dir)
    return _VECTOR_STORE

