import React from 'react';
import { createRoot } from 'react-dom/client';

// Helper to mount component safely with code-splitting (dynamic import)
async function mountComponent(elementId, loader, displayName) {
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

    try {
        const { default: Component } = await loader();
        const root = createRoot(el);
        root.render(
            <React.StrictMode>
                <Component initialData={initialData} />
            </React.StrictMode>
        );
    } catch (e) {
        console.error(`Failed to load component for ${displayName}:`, e);
    }
}

// Mount Pages (only the component present on the current page is downloaded)
mountComponent('beranda-root', () => import('./components/beranda/BerandaPage'), 'Beranda');
mountComponent('profil-root', () => import('./components/profil/ProfilPage'), 'Profil');
mountComponent('berita-root', () => import('./components/berita/BeritaPage'), 'Berita');
mountComponent('umkm-root', () => import('./components/umkm/UmkmPage'), 'UMKM');
mountComponent('guides-root', () => import('./components/layanan/GuidesPage'), 'Panduan Surat');
mountComponent('store-register-root', () => import('./components/layanan/StoreRegisterPage'), 'Daftar Toko UMKM');
mountComponent('feedback-root', () => import('./components/layanan/FeedbackPage'), 'Aspirasi & Pengaduan');
mountComponent('demografi-root', () => import('./components/demografi/DemografiPage'), 'Demografi');
mountComponent('umkm-detail-root', () => import('./components/umkm/UmkmDetailPage'), 'Detail UMKM');
mountComponent('news-detail-root', () => import('./components/berita/NewsDetailPage'), 'Detail Berita');
mountComponent('admin-umkm-root', () => import('./components/admin/AdminUmkmPage'), 'Admin UMKM');
mountComponent('admin-services-root', () => import('./components/admin/AdminServicesPage'), 'Admin Layanan & Aspirasi');
mountComponent('privacy-root', () => import('./components/public/PrivacyPage'), 'Kebijakan Privasi');
