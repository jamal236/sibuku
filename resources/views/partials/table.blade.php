@props(['headers' => []])
<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => 'w-full']) }}>
        <thead>
            <tr class="border-b border-forest-200">
                @foreach($headers as $header)
                    <th class="text-left py-3 px-4 text-xs font-semibold text-forest-500 uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-forest-100">
            {{ $slot }}
        </tbody>
    </table>
</div>