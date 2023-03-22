<div {{$attributes->merge(['class' => 'border border-amber-400 rounded-lg p-3 bg-white'])}}>
    <h2 class="font-medium text-amber-400">
        <x-icon name="warning" class="inline mr-1" /> Warning
    </h2>
    <p class="mt-1.5 indent-6 md:intent-8">
        {{ $slot }}
    </p>
</div>