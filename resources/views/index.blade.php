@php
    $columns = $getColumns();
    $records = $getRecords();
    $selectable = $getSelectable();
    $links = $getLinks();
    $searchable = $getSearchable();
@endphp

<div x-data="{
        selectedRecords: [],
        shouldCheckUniqueSelection: true,
        debounce(fn, ms) {
            let timeout;
            return function() {
                clearTimeout(timeout);
                timeout = setTimeout(fn, ms);
            };
        },
        init() {
            const toServer = this.debounce(() => {
                this.$wire.set('tableData.selectedRecords', this.selectedRecords);
            }, 500);
            this.$watch('selectedRecords', () => {
                if (!this.shouldCheckUniqueSelection) {
                    this.shouldCheckUniqueSelection = true;

                    return;
                }
                this.selectedRecords = [...new Set(this.selectedRecords)];

                if (this.idsInPage.every(id => this.selectedRecords.includes(id))) {
                    this.$refs.checkallbox.checked = true;
                } else {
                    this.$refs.checkallbox.checked = false;
                }

                toServer()
                this.shouldCheckUniqueSelection = false;
            })
        },
        get idsInPage() {
            return this.$wire.tableData['idsInPage'].map(id => id.toString());
        },
        get selectedRecordsCount() {
            return this.selectedRecords.length;
        },
        check(e) {
            if (e.target.checked) {
                this.checkall();
                return;
            }
            this.uncheckall();
        },
        add(id) {
            if (this.selectedRecords.includes(id)) return;
            this.selectedRecords.push(id);
        },
        deselectAllRecords() {
            this.selectedRecords = [];
        },
        selectAllRecords() {
            this.$wire.tableData['tableAllIds']
                .map(id => id.toString())
                .forEach(id => this.add(id));
        },
        checkall(e) {
            this.idsInPage.forEach(id => this.add(id));
        },
        uncheckall(e) {
            this.selectedRecords = [];
        }
}">

    <x-table.container>

        @if($searchable)
            <input type="text" placeholder="search..." wire:model.debounce="tableData.tableSearchQuery">
        @endif

        <x-table-lite::select-all />

        <x-tables::table>
            <x-slot:header>
                <x-tables::header-cell>
                    <x-tables::checkbox x-ref="checkallbox" @input="check" />
                </x-tables::header-cell>
                @foreach($columns as $column)
                    <x-tables::header-cell>{{ $column->getLabel()  }}</x-tables::header-cell>
                @endforeach
            </x-slot:header>
            @if($records)
                @foreach($records as $record)
                    <x-tables::row>
                        @if($selectable)
                            <x-tables::checkbox.cell>
                                <x-tables::checkbox
                                    x-model="selectedRecords"
                                    :value="$record->id"
                                />
                            </x-tables::checkbox.cell>
                        @endif
                        @foreach($columns as $column)
                            <x-tables::cell>
                                <div class="filament-tables-column-wrapper">
                                    {{ $column->record($record)->viewData(['recordKey' => $record->id]) }}
                                </div>
                            </x-tables::cell>
                        @endforeach
                    </x-tables::row>
                @endforeach
            @endif
        </x-tables::table>
        <x-slot:footer>
            {{ $links }}
        </x-slot:footer>
    </x-table.container>
</div>


