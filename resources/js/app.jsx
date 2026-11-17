import React from 'react';
import { createRoot } from 'react-dom/client';
import BerandaPage from './components/beranda/BerandaPage';
import ProfilPage from './components/profil/ProfilPage';
import BeritaPage from './components/berita/BeritaPage';
import UmkmPage from './components/umkm/UmkmPage';

// Mount Beranda React Page if the root container exists
const berandaRootEl = document.getElementById('beranda-root');
if (berandaRootEl) {
    let initialData = {};
    try {
        const rawProps = berandaRootEl.getAttribute('data-props');
        if (rawProps) {
            initialData = JSON.parse(rawProps);
        }
    } catch (e) {
        console.error('Failed to parse initial data for Beranda:', e);
    }

    const root = createRoot(berandaRootEl);
    root.render(
        <React.StrictMode>
            <BerandaPage initialData={initialData} />
        </React.StrictMode>
    );
}

// Mount Profil React Page if the root container exists
const profilRootEl = document.getElementById('profil-root');
if (profilRootEl) {
    let initialData = {};
    try {
        const rawProps = profilRootEl.getAttribute('data-props');
        if (rawProps) {
            initialData = JSON.parse(rawProps);
        }
    } catch (e) {
        console.error('Failed to parse initial data for Profil:', e);
    }

    const root = createRoot(profilRootEl);
    root.render(
        <React.StrictMode>
            <ProfilPage initialData={initialData} />
        </React.StrictMode>
    );
}

// Mount Berita React Page if the root container exists
const beritaRootEl = document.getElementById('berita-root');
if (beritaRootEl) {
    let initialData = {};
    try {
        const rawProps = beritaRootEl.getAttribute('data-props');
        if (rawProps) {
            initialData = JSON.parse(rawProps);
        }
    } catch (e) {
        console.error('Failed to parse initial data for Berita:', e);
    }

    const root = createRoot(beritaRootEl);
    root.render(
        <React.StrictMode>
            <BeritaPage initialData={initialData} />
        </React.StrictMode>
    );
}

// Mount UMKM React Page if the root container exists
const umkmRootEl = document.getElementById('umkm-root');
if (umkmRootEl) {
    let initialData = {};
    try {
        const rawProps = umkmRootEl.getAttribute('data-props');
        if (rawProps) {
            initialData = JSON.parse(rawProps);
        }
    } catch (e) {
        console.error('Failed to parse initial data for UMKM:', e);
    }

    const root = createRoot(umkmRootEl);
    root.render(
        <React.StrictMode>
            <UmkmPage initialData={initialData} />
        </React.StrictMode>
    );
}


