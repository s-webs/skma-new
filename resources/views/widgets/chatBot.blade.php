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
            overflow: auto;
            padding: 16px 18px
        }

        .msg {
            margin: 10px 0;
            padding: 12px 14px;
            border-radius: 12px;
            max-width: 82%
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

        input, textarea {
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
    </style>
</head>
<body class="">
@php $locale = app()->getLocale(); @endphp
<div class="card" x-data="chatbot('{{ $locale }}')">
    <div class="head">
        <span class="dot"></span>
        <strong>SKMA - AI ChatBot</strong>
        <span class="small" x-text="hint"></span>
    </div>

    <div class="log" x-ref="log">
        <template x-for="m in messages">
            <div :class="m.role==='user' ? 'msg user' : 'msg ai'">
                <div x-text="m.text"></div>
                <template x-if="m.sources?.length">
                    <div class="small" style="margin-top:6px">Sources:
                        <template x-for="s in m.sources">
                            <span style="margin-right:8px" x-text="s"></span>
                        </template>
                    </div>
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
            ru: {hello: 'Привет! Чем помочь?', ph: 'Напишите вопрос', btn: 'Отправить'},
            kz: {hello: 'Сәлем! Қалай көмектесе аламын?', ph: 'Сұрақ жазыңыз', btn: 'Жіберу'},
            en: {hello: 'Hello! How can I help?', ph: 'Type your question', btn: 'Send'},
        }[locale] ?? {hello: 'Hello!', ph: 'Type...', btn: 'Send'};

        return {
            messages: [{role: 'assistant', text: ui.hello}],
            input: '', loading: false, ph: ui.ph, btn: ui.btn, locale,

            async send() {
                const text = (this.input || '').trim();
                if (!text) return;
                this.messages.push({role: 'user', text});
                this.input = '';
                this.loading = true;

                try {
                    const f = new FormData();
                    f.append('message', text);
                    f.append('locale', this.locale); // <-- ключевой момент

                    const res = await fetch("{{ route('chat.post') }}", {
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        body: f
                    });
                    const data = await res.json();
                    this.messages.push({
                        role: 'assistant',
                        text: data.ok ? data.answer : (data.error || 'Server error')
                    });
                } catch (e) {
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
