@props([
    'name',
    'title' => 'Filters',
    'show' => false,
    'width' => 'max-w-md'
])

<div
    x-data="{ 
        show: @js($show),
        close() { this.show = false }
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:open-drawer.window="if ($event.detail == '{{ $name }}') show = true"
    x-on:close-drawer.window="if ($event.detail == '{{ $name }}') show = false"
    x-on:keydown.escape.window="close()"
    x-show="show"
    class="fixed inset-0 z-99999"
    style="display: none;"
>
    <!-- Backdrop -->
    <div
        x-show="show"
        x-transition:enter="ease-in-out duration-500"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="close()"
        class="absolute inset-0 bg-gray-500/75 transition-opacity dark:bg-gray-900/80 backdrop-blur-sm"
    ></div>

    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
        <!-- Drawer Panel -->
        <div
            x-show="show"
            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="pointer-events-auto w-screen {{ $width }}"
        >
            <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl dark:bg-[#1E293B]">
                <div class="px-4 py-6 sm:px-6 border-b border-gray-200 dark:border-gray-800">
                    <div class="flex items-start justify-between">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90" id="slide-over-title">
                            {{ $title }}
                        </h2>
                        <div class="ml-3 flex h-7 items-center">
                            <button
                                type="button"
                                x-on:click="close()"
                                class="rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-white/5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                            >
                                <span class="sr-only">Close panel</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="relative flex-1 px-4 py-6 sm:px-6">
                    {{ $slot }}
                </div>

                @if(isset($footer))
                    <div class="border-t border-gray-200 px-4 py-6 sm:px-6 dark:border-gray-800">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
