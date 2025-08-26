<div x-data="{ open: false }" class="fixed bottom-4 right-4 z-[50]">
    <!-- Кнопка -->
    <button
        @click="open = !open"
        class="w-[70px] h-[70px] rounded-full bg-blue-600 text-white flex items-center justify-center shadow-lg hover:bg-blue-700"
    >
        <template x-if="!open"><span>AI</span></template>
        <template x-if="open"><i class="fas fa-times"></i></template>
    </button>

    <!-- Чат -->
    <div
        x-show="open"
        x-transition
        x-data="chatbot('{{ $locale }}')"
        class="mt-3 w-80 h-[400px] bg-white dark:bg-gray-900 shadow-lg rounded-xl flex flex-col overflow-hidden border border-gray-200 dark:border-gray-700"
    >
        <!-- Заголовок -->
        <div class="bg-gray-700 text-gray-200 p-3 font-semibold">
            🤖 SKMA AI Assistant
        </div>

        <!-- Сообщения -->
        <div
            class="flex-1 p-3 space-y-2 text-[13px] overflow-y-auto max-h-80"
            x-ref="log"
        >
            <template x-for="(msg, i) in messages" :key="i">
                <div
                    class="p-2 rounded-lg max-w-[80%] break-words"
                    :class="msg.role === 'user'
                        ? 'ml-auto bg-blue-500 text-white'
                        : 'mr-auto bg-gray-200 dark:bg-gray-700 dark:text-gray-100'"
                >
                    <span x-text="msg.typing ? typing : msg.text" class="break-all"></span>
                </div>
            </template>
        </div>

        <!-- Форма -->
        <div class="flex">
            <input
                type="text"
                class="flex-1 px-3 py-2 text-sm border-0 outline-none ring-0 focus:ring-0 focus:outline-none bg-transparent dark:bg-gray-700 dark:text-gray-200"
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


@once
    <script>
        function chatbot(locale) {
            const ui = {
                ru: {
                    hello: 'Привет! Чем помочь?',
                    ph: 'Напишите вопрос',
                    btn: 'Отправить',
                    typing: 'Печатает...'
                },
                kz: {
                    hello: 'Сәлем! Қалай көмектесейін?',
                    ph: 'Сұрағыңызды жазыңыз',
                    btn: 'Жіберу',
                    typing: 'Жазып жатыр...'
                },
                en: {
                    hello: 'Hi! How can I help you?',
                    ph: 'Write a question',
                    btn: 'Send',
                    typing: 'Typing...'
                }
            }[locale] ?? {hello: 'Hello!', ph: 'Type...', btn: 'Send', typing: 'Typing...'};

            return {
                messages: [{role: 'assistant', text: ui.hello}],
                input: '', loading: false, ph: ui.ph, btn: ui.btn, locale, typing: ui.typing,
                thread_id: null,

                async send() {
                    const text = (this.input || '').trim();
                    if (!text) return;
                    this.messages.push({role: 'user', text});
                    this.input = '';
                    this.loading = true;

                    // печатает...
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
@endonce
