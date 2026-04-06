@props([
    'headers' => [],
])

<div class="relative overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Loading Progress Bar -->
    <div wire:loading class="absolute top-0 left-0 right-0 z-20">
        <div class="h-0.5 w-full bg-blue-500/10 overflow-hidden">
            <div class="h-full bg-blue-600 animate-progress origin-left"></div>
        </div>
    </div>

    <div class="max-w-full overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    @if(isset($thead))
                        {{ $thead }}
                    @else
                        @foreach($headers as $header)
                            <th class="px-5 py-4 text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                {{ $header }}
                            </th>
                        @endforeach
                    @endif
                </tr>
            </thead>
            <tbody 
                wire:loading.class="opacity-50 blur-[0.5px] transition-all duration-200"
                class="divide-y divide-gray-100 dark:divide-gray-800"
            >
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
