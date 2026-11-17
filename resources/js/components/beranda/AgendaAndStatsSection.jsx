import React, { useState } from 'react';
import { ChevronLeft, ChevronRight, Calendar as CalendarIcon } from 'lucide-react';

export default function AgendaAndStatsSection() {
    const [viewDate, setViewDate] = useState(new Date(2026, 9, 1)); // October 2026 default as in design

    const monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    const currentMonthLabel = `${monthNames[viewDate.getMonth()]} ${viewDate.getFullYear()}`;

    const prevMonth = () => {
        setViewDate(new Date(viewDate.getFullYear(), viewDate.getMonth() - 1, 1));
    };

    const nextMonth = () => {
        setViewDate(new Date(viewDate.getFullYear(), viewDate.getMonth() + 1, 1));
    };

    const year = viewDate.getFullYear();
    const month = viewDate.getMonth();

    const firstDayIndex = (new Date(year, month, 1).getDay() + 6) % 7;
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();

    const calendarCells = [];

    // Prev month days
    for (let i = firstDayIndex - 1; i >= 0; i--) {
        calendarCells.push({
            day: daysInPrevMonth - i,
            currentMonth: false,
            key: `prev-${i}`,
        });
    }

    // Current month days
    for (let i = 1; i <= daysInMonth; i++) {
        calendarCells.push({
            day: i,
            currentMonth: true,
            isHighlighted: year === 2026 && month === 9 && (i === 28 || i === 12),
            key: `curr-${i}`,
        });
    }

    // Remaining days to complete grid
    const totalCellsTarget = calendarCells.length > 35 ? 42 : 35;
    const remaining = totalCellsTarget - calendarCells.length;
    for (let i = 1; i <= remaining; i++) {
        calendarCells.push({
            day: i,
            currentMonth: false,
            key: `next-${i}`,
        });
    }

    const dayHeaders = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

    return (
        <section className="py-12 sm:py-16 lg:py-20 bg-[#F5EFE6] w-full">
            {/* Full-width container: mengisi dari ujung kiri ke ujung kanan */}
            <div className="w-full px-4 sm:px-8 md:px-12 lg:px-16 xl:px-20">
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 xl:gap-16 items-stretch">
                    
                    {/* Left Column: Agenda Terkini Calendar Card (Rata Kiri) */}
                    <div className="lg:col-span-5 xl:col-span-5 bg-white rounded-3xl p-6 sm:p-8 xl:p-9 shadow-sm border border-[#E9DFD3] flex flex-col justify-between h-full">
                        <div>
                            <div className="flex items-center justify-between mb-1">
                                <h2 className="font-serif text-2xl sm:text-3xl font-bold text-[#BD6E37]">
                                    Agenda Terkini
                                </h2>
                                <CalendarIcon className="w-5 h-5 text-[#BD6E37]/70" />
                            </div>
                            <p className="text-xs sm:text-sm text-[#8C7063] mb-5">
                                Dapatkan informasi agenda kegiatan warga & kalender desa
                            </p>

                            {/* Month Header with navigation */}
                            <div className="flex items-center justify-between bg-[#F8F3EC] rounded-2xl px-4 py-3 mb-4 border border-[#ECE0D0]">
                                <button
                                    type="button"
                                    onClick={prevMonth}
                                    aria-label="Bulan sebelumnya"
                                    className="p-1.5 rounded-lg hover:bg-[#EAE0D3] text-[#3D1E0F] transition"
                                >
                                    <ChevronLeft className="w-4 h-4" />
                                </button>
                                <span className="font-serif font-bold text-[#3D1E0F] text-sm sm:text-base">
                                    {currentMonthLabel}
                                </span>
                                <button
                                    type="button"
                                    onClick={nextMonth}
                                    aria-label="Bulan berikutnya"
                                    className="p-1.5 rounded-lg hover:bg-[#EAE0D3] text-[#3D1E0F] transition"
                                >
                                    <ChevronRight className="w-4 h-4" />
                                </button>
                            </div>

                            {/* Calendar Grid */}
                            <div className="grid grid-cols-7 gap-1 sm:gap-1.5 text-center mb-6">
                                {dayHeaders.map((dh, idx) => (
                                    <div
                                        key={idx}
                                        className={`text-xs font-semibold py-1.5 ${
                                            idx === 6 ? 'text-red-500 font-bold' : 'text-[#6E5343]'
                                        }`}
                                    >
                                        {dh}
                                    </div>
                                ))}

                                {calendarCells.map((cell) => (
                                    <div
                                        key={cell.key}
                                        className={`py-2 sm:py-2.5 text-xs sm:text-sm font-medium rounded-xl flex items-center justify-center transition cursor-default ${
                                            !cell.currentMonth
                                                ? 'text-[#D0C2B4]'
                                                : cell.isHighlighted
                                                ? 'bg-[#BD6E37] text-white font-bold shadow-md scale-105'
                                                : 'text-[#3D1E0F] hover:bg-[#F8F3EC]'
                                        }`}
                                    >
                                        {cell.day}
                                    </div>
                                ))}
                            </div>
                        </div>

                        {/* Nearest Agenda Banner */}
                        <div className="bg-[#FAF4ED] border border-[#ECDCCB] rounded-2xl p-4 flex items-center justify-between gap-3 mt-4">
                            <div className="text-left">
                                <span className="text-[10px] sm:text-xs uppercase font-bold text-[#BD6E37] block leading-tight">
                                    Agenda terdekat:
                                </span>
                                <p className="text-xs sm:text-sm font-bold text-[#3D1E0F] mt-0.5">
                                    Pameran UMKM di Desa Ngadiluwih
                                </p>
                            </div>
                            <span className="shrink-0 px-3 py-1.5 rounded-full bg-[#BD6E37] text-white font-bold text-xs shadow-sm">
                                28/10
                            </span>
                        </div>
                    </div>

                    {/* Right Column: Tentang Website & Stats (Rata Kanan) */}
                    <div className="lg:col-span-7 xl:col-span-7 flex flex-col justify-between h-full gap-6">
                        {/* Tentang Website Pill & Card */}
                        <div className="flex flex-col gap-3">
                            <div>
                                <span className="bg-[#BD6E37] text-white px-5 sm:px-6 py-2 rounded-full font-serif font-bold text-base sm:text-lg inline-block shadow-sm">
                                    Tentang Website
                                </span>
                            </div>

                            <div className="bg-[#FFFDF9] border border-[#E4D5C5] rounded-3xl p-6 sm:p-7 xl:p-8 shadow-sm">
                                <p className="text-[#3D1E0F] text-sm sm:text-base lg:text-lg leading-relaxed font-light text-justify sm:text-left">
                                    <strong className="font-bold text-[#BD6E37]">PojokNgadiluwih</strong> adalah platform website resmi Desa Ngadiluwih yang dirancang untuk mewujudkan pelayanan publik yang modern, transparan, dan terpadu. Website ini hadir sebagai pusat informasi desa, layanan administrasi online, serta wadah promosi bagi UMKM lokal untuk mendorong perekonomian warga.
                                </p>
                            </div>
                        </div>

                        {/* 4 Stats Cards in 2x2 Grid */}
                        <div className="grid grid-cols-2 gap-4 sm:gap-5 xl:gap-6">
                            {/* Card 1 */}
                            <div className="bg-gradient-to-br from-[#E2B992] to-[#CCA077] rounded-2xl p-5 sm:p-6 text-[#3D1E0F] shadow-sm border border-[#DDB088] flex flex-col justify-between min-h-[110px] sm:min-h-[130px]">
                                <span className="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-[#4E2713] opacity-85">
                                    POPULASI
                                </span>
                                <div className="my-1.5">
                                    <p className="font-serif text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-[#2A1307] tracking-tight">
                                        6.420+
                                    </p>
                                </div>
                                <span className="text-xs sm:text-sm text-[#3D1E0F] font-medium">
                                    Jiwa Terdata
                                </span>
                            </div>

                            {/* Card 2 */}
                            <div className="bg-gradient-to-br from-[#E2B992] to-[#CCA077] rounded-2xl p-5 sm:p-6 text-[#3D1E0F] shadow-sm border border-[#DDB088] flex flex-col justify-between min-h-[110px] sm:min-h-[130px]">
                                <span className="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-[#4E2713] opacity-85">
                                    UMKM TERDAFTAR
                                </span>
                                <div className="my-1.5">
                                    <p className="font-serif text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-[#2A1307] tracking-tight">
                                        85+
                                    </p>
                                </div>
                                <span className="text-xs sm:text-sm text-[#3D1E0F] font-medium">
                                    Usaha Berdiri / Terverifikasi
                                </span>
                            </div>

                            {/* Card 3 */}
                            <div className="bg-gradient-to-br from-[#E2B992] to-[#CCA077] rounded-2xl p-5 sm:p-6 text-[#3D1E0F] shadow-sm border border-[#DDB088] flex flex-col justify-between min-h-[110px] sm:min-h-[130px]">
                                <span className="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-[#4E2713] opacity-85">
                                    LAYANAN SURAT
                                </span>
                                <div className="my-1.5">
                                    <p className="font-serif text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-[#2A1307] tracking-tight">
                                        12+
                                    </p>
                                </div>
                                <span className="text-xs sm:text-sm text-[#3D1E0F] font-medium">
                                    Panduan & Prosedur Cepat
                                </span>
                            </div>

                            {/* Card 4 */}
                            <div className="bg-gradient-to-br from-[#E2B992] to-[#CCA077] rounded-2xl p-5 sm:p-6 text-[#3D1E0F] shadow-sm border border-[#DDB088] flex flex-col justify-between min-h-[110px] sm:min-h-[130px]">
                                <span className="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-[#4E2713] opacity-85">
                                    DUSUN & RW
                                </span>
                                <div className="my-1.5">
                                    <p className="font-serif text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-[#2A1307] tracking-tight">
                                        4 Dusun
                                    </p>
                                </div>
                                <span className="text-xs sm:text-sm text-[#3D1E0F] font-medium">
                                    Wilayah Desa Ngadiluwih
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>
    );
}
