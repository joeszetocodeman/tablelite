@if($selectable && $hasFeature('bulkSelect')  )
    <x-table-lite::cell>
        @if($getSelectableRecord($record))
        <x-table-lite::checkbox
                x-model="selectedRecords"
                :value="(string) $record->id"
        />
        @endif
    </x-table-lite::cell>
@endif
