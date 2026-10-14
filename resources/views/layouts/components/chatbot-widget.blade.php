<div id="chatbot-widget-container" class="fixed bottom-6 right-6 z-50">
    <!-- Chat Toggle Button -->
    <button id="chatbot-toggle-btn" type="button" onclick="toggleChatbot()" class="relative group flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-500 text-white shadow-xl hover:shadow-2xl hover:scale-105 active:scale-95 transition-all duration-200">
        <svg id="chat-icon-open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <svg id="chat-icon-close" class="w-7 h-7 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-400"></span>
        </span>
    </button>

    <!-- Chat Modal / Window -->
    <div id="chatbot-window" class="hidden absolute bottom-16 right-0 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col transition-all duration-200 z-50 max-h-[540px]">
        <!-- Chat Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-4 py-3 text-white flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs text-white">
                    AI
                </div>
                <div>
                    <h4 class="text-sm font-semibold leading-tight">Asisten PojokNgadiluwih</h4>
                    <p class="text-[11px] text-emerald-100 flex items-center">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 mr-1.5 inline-block"></span>
                        AI Desa Online
                    </p>
                </div>
            </div>
            <button onclick="toggleChatbot()" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Messages Container -->
        <div id="chatbot-messages" class="flex-1 p-4 space-y-3 overflow-y-auto bg-slate-50 text-xs max-h-80 min-h-64">
            <!-- Bot message -->
            <div class="flex items-start space-x-2">
                <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                    AI
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-sm p-3 text-slate-700 shadow-sm max-w-[85%] leading-relaxed">
                    Halo! Ada yang bisa saya bantu terkait layanan surat, UMKM lokal, atau informasi Desa Ngadiluwih?
                </div>
            </div>
        </div>

        <!-- Quick Prompts -->
        <div class="px-3 py-1.5 bg-slate-100/80 border-t border-slate-200 flex gap-1.5 overflow-x-auto text-[11px]">
            <button type="button" onclick="sendQuickPrompt('Bagaimana cara buat surat pengantar?')" class="whitespace-nowrap px-2.5 py-1 bg-white border border-slate-200 rounded-full text-slate-600 hover:border-emerald-500 hover:text-emerald-600 transition">
                Panduan Surat
            </button>
            <button type="button" onclick="sendQuickPrompt('Rekomendasi UMKM kuliner desa?')" class="whitespace-nowrap px-2.5 py-1 bg-white border border-slate-200 rounded-full text-slate-600 hover:border-emerald-500 hover:text-emerald-600 transition">
                UMKM Kuliner
            </button>
            <button type="button" onclick="sendQuickPrompt('Jam pelayanan kantor desa?')" class="whitespace-nowrap px-2.5 py-1 bg-white border border-slate-200 rounded-full text-slate-600 hover:border-emerald-500 hover:text-emerald-600 transition">
                Jam Layanan
            </button>
        </div>

        <!-- Chat Input Form -->
        <form id="chatbot-form" onsubmit="handleChatSubmit(event)" class="p-3 bg-white border-t border-slate-200 flex items-center space-x-2">
            @csrf
            <input id="chatbot-input" type="text" placeholder="Ketik pertanyaan Anda..." autocomplete="off" class="flex-1 bg-slate-100 border border-slate-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-emerald-500 text-slate-800">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white p-2 rounded-xl transition shadow-sm">
                <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
    function toggleChatbot() {
        const windowEl = document.getElementById('chatbot-window');
        const iconOpen = document.getElementById('chat-icon-open');
        const iconClose = document.getElementById('chat-icon-close');
        
        const isHidden = windowEl.classList.contains('hidden');
        if (isHidden) {
            windowEl.classList.remove('hidden');
            iconOpen.classList.add('hidden');
            iconClose.classList.remove('hidden');
            document.getElementById('chatbot-input').focus();
        } else {
            windowEl.classList.add('hidden');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
        }
    }

    function sendQuickPrompt(promptText) {
        document.getElementById('chatbot-input').value = promptText;
        handleChatSubmit(new Event('submit'));
    }

    async function handleChatSubmit(e) {
        e.preventDefault();
        const inputEl = document.getElementById('chatbot-input');
        const message = inputEl.value.trim();
        if (!message) return;

        appendUserMessage(message);
        inputEl.value = '';

        // Add loading state
        const loadingId = appendLoadingIndicator();

        try {
            const token = document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}';
            const response = await fetch('{{ route("chatbot.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            removeLoadingIndicator(loadingId);
            appendBotMessage(data.reply || 'Mohon maaf, asisten AI sedang sibuk. Silakan coba sesaat lagi.');
        } catch (err) {
            removeLoadingIndicator(loadingId);
            appendBotMessage('Terjadi gangguan saat menghubungkan ke asisten AI. Silakan coba kembali nanti.');
        }
    }

    function appendUserMessage(text) {
        const messages = document.getElementById('chatbot-messages');
        const div = document.createElement('div');
        div.className = 'flex justify-end';
        div.innerHTML = `
            <div class="bg-emerald-600 text-white rounded-2xl rounded-tr-sm p-3 shadow-sm max-w-[85%] leading-relaxed">
                ${escapeHtml(text)}
            </div>
        `;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function appendBotMessage(text) {
        const messages = document.getElementById('chatbot-messages');
        const div = document.createElement('div');
        div.className = 'flex items-start space-x-2';
        div.innerHTML = `
            <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                AI
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-sm p-3 text-slate-700 shadow-sm max-w-[85%] leading-relaxed">
                ${escapeHtml(text)}
            </div>
        `;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function appendLoadingIndicator() {
        const id = 'loading-' + Date.now();
        const messages = document.getElementById('chatbot-messages');
        const div = document.createElement('div');
        div.id = id;
        div.className = 'flex items-start space-x-2';
        div.innerHTML = `
            <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                AI
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-sm px-3 py-2 text-slate-500 shadow-sm flex items-center space-x-1">
                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce"></span>
                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce [animation-delay:0.2s]"></span>
                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce [animation-delay:0.4s]"></span>
            </div>
        `;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
        return id;
    }

    function removeLoadingIndicator(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }

    function escapeHtml(string) {
        const div = document.createElement('div');
        div.innerText = string;
        return div.innerHTML;
    }
</script>
