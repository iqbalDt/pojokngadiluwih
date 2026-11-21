import React from 'react';
import { createRoot } from 'react-dom/client';
import BerandaPage from './components/beranda/BerandaPage';
import ProfilPage from './components/profil/ProfilPage';
import BeritaPage from './components/berita/BeritaPage';
import UmkmPage from './components/umkm/UmkmPage';
import GuidesPage from './components/layanan/GuidesPage';
import StoreRegisterPage from './components/layanan/StoreRegisterPage';
import FeedbackPage from './components/layanan/FeedbackPage';
import DemografiPage from './components/demografi/DemografiPage';
import AdminUmkmPage from './components/admin/AdminUmkmPage';
import AdminServicesPage from './components/admin/AdminServicesPage';

// Helper to mount component safely
function mountComponent(elementId, Component, displayName) {
    const el = document.getElementById(elementId);
    if (!el) return;

    let initialData = {};
    try {
        const rawProps = el.getAttribute('data-props');
        if (rawProps) {
            initialData = JSON.parse(rawProps);
        }
    } catch (e) {
        console.error(`Failed to parse initial data for ${displayName}:`, e);
    }

    const root = createRoot(el);
    root.render(
        <React.StrictMode>
            <Component initialData={initialData} />
        </React.StrictMode>
    );
}

// Mount Pages
mountComponent('beranda-root', BerandaPage, 'Beranda');
mountComponent('profil-root', ProfilPage, 'Profil');
mountComponent('berita-root', BeritaPage, 'Berita');
mountComponent('umkm-root', UmkmPage, 'UMKM');
mountComponent('guides-root', GuidesPage, 'Panduan Surat');
mountComponent('store-register-root', StoreRegisterPage, 'Daftar Toko UMKM');
mountComponent('feedback-root', FeedbackPage, 'Aspirasi & Pengaduan');
mountComponent('demografi-root', DemografiPage, 'Demografi');
mountComponent('admin-umkm-root', AdminUmkmPage, 'Admin UMKM');
mountComponent('admin-services-root', AdminServicesPage, 'Admin Layanan & Aspirasi');
