@if($selectable && $hasFeature('bulkSelect')  )
    <x-tables::checkbox.cell>
        @if($getSelectableRecord($record))
            <x-tables::checkbox
                    x-model="selectedRecords"
                    :value="$record->id"
            />
        @endif
    </x-tables::checkbox.cell>
@endif
