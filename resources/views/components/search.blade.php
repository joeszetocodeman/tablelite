<div class="flex justify-end py-3 pr-3">
    <div class="filament-tables-search-input">
        <label class="group relative flex items-center">
            <span
                class="pointer-events-none absolute inset-y-0 left-0 flex h-9 w-9 items-center justify-center text-gray-400 group-focus-within:text-primary-500">
                <x-table-lite::icons.search />
            </span>
            <input wire:model.debounce.500ms="tableData.tableSearchQuery" placeholder="Search"
                   type="search"
                   autocomplete="off"
                   class="block h-9 w-full max-w-xs rounded-lg border-gray-300 pl-9 placeholder-gray-400 shadow-sm outline-none transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500">

            <span class="sr-only"> Search </span>
        </label>
    </div>
</div>
