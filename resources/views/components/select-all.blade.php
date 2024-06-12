<div
    class="filament-tables-selection-indicator flex flex-wrap items-center gap-1 whitespace-nowrap bg-primary-500/10 px-4 py-2 text-sm border-t"
    x-show="selectedRecords.length > 0"
>
    <div class="flex-1">
        <span class="" x-text="selectedRecordsCount + ' records selected.' "> </span>
        <span>
            <button
                x-on:click="selectAllRecords"
                class="text-sm font-medium text-primary-600" type="button"
            >
                <span x-text="'Select all ' + $wire.tableData['tableAllIds'].length  "></span>
            </button>
        </span>
        <span>
            <button
                x-on:click="deselectAllRecords"
                class="text-sm font-medium text-primary-600" type="button"
            >
                Deselect all.
            </button>
        </span>
    </div>
</div>
