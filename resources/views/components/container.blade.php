<x-tables::container>
    <div class="filament-tables-table-container relative overflow-x-auto">
        {{ $slot }}
    </div>

    {{ $footer ?? null }}
</x-tables::container>
