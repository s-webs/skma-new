<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SKMA ChatBot</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        :root {
            --bg: #0b0f14;
            --card: #121722;
            --text: #e9eef5;
            --muted: #9fb3c8;
            --acc: #38bdf8
        }

        @media (prefers-color-scheme: light) {
            :root {
                --bg: #f8fafc;
                --card: #ffffff;
                --text: #0b1220;
                --muted: #4b5563;
                --acc: #0284c7
            }
        }

        body {
            margin: 0;
            background: var(--bg);
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, 'Helvetica Neue', sans-serif;
            color: var(--text)
        }

        .card {
            width: 100%;
            height: 100vh;
            background: var(--card);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .35);
            overflow: hidden
        }

        .head {
            padding: 18px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, .06);
            display: flex;
            gap: 12px;
            align-items: center
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--acc)
        }

        .log {
            height: 60vh;
            overflow-y: auto;
            padding: 16px 18px
        }

        .msg {
            margin: 10px 0;
            padding: 12px 14px;
            border-radius: 12px;
            max-width: 82%;
            word-wrap: break-word; /* перенос длинных слов */
        }

        .user {
            background: #0ea5e980;
            color: #001b2d;
            margin-left: auto
        }

        .ai {
            background: rgba(148, 163, 184, .15);
            border: 1px solid rgba(148, 163, 184, .25)
        }

        .foot {
            display: flex;
            gap: 10px;
            padding: 14px;
            border-top: 1px solid rgba(255, 255, 255, .06)
        }

        input {
            flex: 1;
            background: transparent;
            border: 1px solid rgba(148, 163, 184, .35);
            border-radius: 12px;
            padding: 12px 14px;
            color: var(--text);
            outline: none
        }

        button {
            background: var(--acc);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            cursor: pointer
        }

        .small {
            color: var(--muted);
            font-size: 12px
        }

        /* Анимация печатания */
        .typing {
            display: inline-block;
            font-size: 18px;
            letter-spacing: 2px;
        }

        .typing::after {
            content: '...';
            animation: dots 1.5s steps(3, end) infinite;
        }

        @keyframes dots {
            0% {
                content: '';
            }
            33% {
                content: '.';
            }
            66% {
                content: '..';
            }
            100% {
                content: '...';
            }
        }
    </style>
</head>
<body>
@php $locale = app()->getLocale(); @endphp
<div class="card" x-data="chatbot('{{ $locale }}')">
    <div class="head">
        <span class="dot"></span>
        <strong>SKMA - AI ChatBot</strong>
    </div>

    <div class="log" x-ref="log">
        <template x-for="(m, idx) in messages" :key="idx">
            <div :class="m.role==='user' ? 'msg user' : 'msg ai'">
                <template x-if="m.typing">
                    <div class="typing"></div>
                </template>
                <template x-if="!m.typing">
                    <div x-text="m.text"></div>
                </template>
            </div>
        </template>
    </div>

    <div class="foot">
        <input type="text" :placeholder="ph" x-model="input" @keydown.enter.prevent="send()">
        <button @click="send()" x-bind:disabled="loading" x-text="loading ? '...' : btn"></button>
    </div>
</div>

<script>
    function chatbot(locale) {
        const ui = {
            // ru: {hello: 'Привет! Чем помочь?', ph: 'Напишите вопрос', btn: 'Отправить'},
            // kz: {hello: 'Привет! Чем помочь?', ph: 'Напишите вопрос', btn: 'Отправить'},
            // en: {hello: 'Привет! Чем помочь?', ph: 'Напишите вопрос', btn: 'Отправить'},
            ru: {hello: 'Hi! How can I help you?', ph: 'Write a question', btn: 'Send'},
            kz: {hello: 'Hi! How can I help you?', ph: 'Write a question', btn: 'Send'},
            en: {hello: 'Hi! How can I help you?', ph: 'Write a question', btn: 'Send'},
        }[locale] ?? {hello: 'Hello!', ph: 'Type...', btn: 'Send'};

        return {
            messages: [{role: 'assistant', text: ui.hello}],
            input: '', loading: false, ph: ui.ph, btn: ui.btn, locale,
            thread_id: null,

            async send() {
                const text = (this.input || '').trim();
                if (!text) return;
                this.messages.push({role: 'user', text});
                this.input = '';
                this.loading = true;

                // Добавляем "печатает..."
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

                    // убираем typing
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
</body>
</html>
