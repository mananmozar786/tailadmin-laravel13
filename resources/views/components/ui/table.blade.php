@props([
    'headers' => [],
])

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
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
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
