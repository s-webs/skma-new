<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/bvi.min.css">
    <link rel="icon" href="/assets/img/icon.png">
    @vite('resources/css/app.css')
    <title>SKMA-AI</title>
</head>
<body>
@php $locale = app()->getLocale(); @endphp

<div class="min-h-screen bg-gray-900 dark:bg-gray-950 flex items-center justify-center p-6">
    <div
        x-data="chatbot('{{ $locale }}')"
        class="w-full md:max-w-[900px] h-screen md:h-[80vh] bg-white dark:bg-gray-900 shadow-2xl md:rounded-2xl flex flex-col overflow-hidden md:border border-gray-200 dark:border-gray-700"
    >
        <!-- Шапка с ссылками на отдельные страницы ботов -->
        <div class="bg-gray-800 text-gray-100 px-4 py-3 flex items-center justify-between">
            <span class="font-semibold">🤖 SKMA AI Assistant</span>
            <nav class="flex gap-2">
                <a href="/ru/chatbot-page"
                   class="px-2 py-1 rounded-md text-xs font-semibold
                          {{ $locale==='ru' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-200 hover:bg-gray-600' }}"
                   @if($locale==='ru') aria-current="page" @endif>RU</a>
                <a href="/kz/chatbot-page"
                   class="px-2 py-1 rounded-md text-xs font-semibold
                          {{ $locale==='kz' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-200 hover:bg-gray-600' }}"
                   @if($locale==='kz') aria-current="page" @endif>KZ</a>
                <a href="/en/chatbot-page"
                   class="px-2 py-1 rounded-md text-xs font-semibold
                          {{ $locale==='en' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-200 hover:bg-gray-600' }}"
                   @if($locale==='en') aria-current="page" @endif>EN</a>
            </nav>
        </div>

        <div class="flex-1 p-3 space-y-2 text-[13px] overflow-y-auto" x-ref="log">
            <template x-for="(msg, i) in messages" :key="i">
                <div
                    class="p-2 rounded-lg max-w-[80%] break-words"
                    :class="msg.role === 'user'
                        ? 'ml-auto bg-blue-600 text-white'
                        : 'mr-auto bg-gray-200 dark:bg-gray-700 dark:text-gray-100'"
                >
                    <span x-text="msg.typing ? typing : msg.text" class="break-all"></span>
                </div>
            </template>
        </div>

        <div class="flex border-t border-gray-200 dark:border-gray-700">
            <input
                type="text"
                class="flex-1 px-3 py-3 text-sm border-0 outline-none ring-0 focus:ring-0 bg-transparent dark:bg-gray-800 dark:text-gray-100"
                x-model="input"
                :placeholder="ph"
                @keydown.enter.prevent="send()"
            />
            <button
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 disabled:opacity-50"
                :disabled="loading"
                @click="send()"
                x-text="btn"
            ></button>
        </div>
    </div>
</div>

<script>
    function chatbot(locale) {
        const uiMap = {
            ru: { hello: 'Привет! Чем помочь?', ph: 'Напишите вопрос', btn: 'Отправить', typing: 'Печатает...' },
            kz: { hello: 'Сәлем! Қалай көмектесейін?', ph: 'Сұрағыңызды жазыңыз', btn: 'Жіберу', typing: 'Жазып жатыр...' },
            en: { hello: 'Hi! How can I help you?', ph: 'Write a question', btn: 'Send', typing: 'Typing...' }
        };
        const ui = uiMap[locale] ?? { hello: 'Hello!', ph: 'Type...', btn: 'Send', typing: 'Typing...' };

        return {
            messages: [{role: 'assistant', text: ui.hello}],
            input: '',
            loading: false,
            ph: ui.ph,
            btn: ui.btn,
            typing: ui.typing,
            locale,
            thread_id: null,

            async send() {
                const text = (this.input || '').trim();
                if (!text) return;
                this.messages.push({role: 'user', text});
                this.input = '';
                this.loading = true;

                const typingMsg = {role: 'assistant', text: '', typing: true};
                this.messages.push(typingMsg);

                try {
                    const f = new FormData();
                    f.append('message', text);
                    f.append('locale', this.locale);
                    if (this.thread_id) f.append('thread_id', this.thread_id);

                    const res = await fetch("{{ route('chat.post') }}", {
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        body: f
                    });
                    const data = await res.json();

                    this.messages = this.messages.filter(m => !m.typing);

                    if (data.ok) {
                        this.thread_id = data.thread_id;
                        this.messages.push({role: 'assistant', text: data.answer});
                    } else {
                        this.messages.push({role: 'assistant', text: data.error || 'Server error'});
                    }
                } catch (e) {
                    this.messages = this.messages.filter(m => !m.typing);
                    this.messages.push({role: 'assistant', text: 'Network error: ' + e.message});
                } finally {
                    this.loading = false;
                    this.$nextTick(() => this.$refs?.log && (this.$refs.log.scrollTop = this.$refs.log.scrollHeight));
                }
            }
        }
    }
</script>

<script src="/assets/js/pro.min.js"></script>
<script src="/assets/js/bvi.min.js"></script>
@vite('resources/js/app.js')
@stack('scripts')
</body>
</html>
