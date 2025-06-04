<div class="px-4 py-2 bg-gray-100 rounded-[10px]">
    <template x-for="(part, index) in breadcrumbs" :key="index">
        <div class="inline-flex items-center">
            <a href="#"
               @click.prevent="goToBreadcrumb(index)"
               :class="index === breadcrumbs.length - 1
                   ? 'text-gray-700 cursor-default'
                   : 'text-gray-500 hover:text-gray-700'"
               class="transition-colors">
                <template x-if="part === 'root'">
                    <i class="ph ph-house text-lg"></i>
                </template>
                <template x-if="part !== 'root'">
                    <span x-text="part"></span>
                </template>
            </a>
            <i x-show="index < breadcrumbs.length - 1"
               class="ph ph-caret-right mx-2 text-gray-400 text-sm"></i>
        </div>
    </template>
</div>
