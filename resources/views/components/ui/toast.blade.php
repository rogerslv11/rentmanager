<div
    x-data="{
        items: [],
        push(notification) {
            const id = Date.now() + Math.random();
            this.items.push({ id, ...notification });
            setTimeout(() => this.remove(id), notification.duration || 4500);
        },
        remove(id) {
            this.items = this.items.filter(i => i.id !== id);
        }
    }"
    x-on:toast.window="push($event.detail)"
    class="fixed top-4 right-4 z-[100] flex flex-col gap-2 pointer-events-none"
    style="min-width: 320px; max-width: 420px;">
    <template x-for="item in items" :key="item.id">
        <div
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8 scale-95"
            x-transition:enter-end="opacity-100 translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 translate-x-8"
            class="pointer-events-auto bg-[#0F0F12] border rounded-xl shadow-2xl p-4 flex items-start gap-3"
            :class="{
                'border-[rgba(34,197,94,0.30)] shadow-[0_0_30px_-10px_rgba(34,197,94,0.30)]': item.type === 'success',
                'border-[rgba(244,63,94,0.30)] shadow-[0_0_30px_-10px_rgba(244,63,94,0.30)]': item.type === 'error',
                'border-[rgba(245,158,11,0.30)] shadow-[0_0_30px_-10px_rgba(245,158,11,0.30)]': item.type === 'warning',
                'border-[#27272A]': !item.type || item.type === 'info'
            }">
            <div class="flex-shrink-0">
                <template x-if="item.type === 'success'">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#22C55E] to-[#15803D] text-[#052E16]">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </div>
                </template>
                <template x-if="item.type === 'error'">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#F43F5E] to-[#BE123C] text-white">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </div>
                </template>
                <template x-if="item.type === 'warning'">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#F59E0B] to-[#B45309] text-[#451A03]">
                        <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                    </div>
                </template>
                <template x-if="!item.type || item.type === 'info'">
                    <div class="icon-box icon-box-md bg-gradient-to-br from-[#3B82F6] to-[#1D4ED8] text-white">
                        <i data-lucide="info" class="w-4 h-4"></i>
                    </div>
                </template>
            </div>
            <div class="flex-1 min-w-0">
                <div x-show="item.title" class="text-sm font-semibold text-white" x-text="item.title"></div>
                <div class="text-sm text-[#A1A1AA] mt-0.5" x-text="item.message"></div>
            </div>
            <button @click="remove(item.id)" class="text-[#52525B] hover:text-white transition-colors p-0.5 rounded hover:bg-[#1F1F23]">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    </template>
</div>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: @json(session('success')) } }));
        });
    </script>
@endif
@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: @json(session('error')) } }));
        });
    </script>
@endif
