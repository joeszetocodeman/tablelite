@if($selectable && $hasFeature('bulkSelect')  )
    <x-table-lite::cell>
        @if($getSelectableRecord($record))
        <x-table-lite::checkbox
                x-model="selectedRecords"
                :value="$record->id"
        />
        @endif
    </x-table-lite::cell>
@endif
