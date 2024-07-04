@php
    $columns = $getColumns();
    $records = $getRecords();
    $selectable = $getSelectable();
    if ( $hasFeature('pagination') ) {
        $links = $getLinks();
    }
    $searchable = $getSearchable();
    $headerActions = $getHeaderActions();
    $actions = $getActions();
    $keyBy = $getKeyBy();
@endphp
<div>
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
            let ids = [];
            for (let checkbox of this.$root.querySelectorAll('.filament-tables-checkbox-cell input[type=checkbox]')) {
                  ids.push(checkbox.value);
            }
            return ids
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
        <x-table-lite::container>
            @if($headerActions)
                <div class="flex justify-end p-4">
                    <div>
                        @foreach($headerActions as $action)
                            {{ $action }}
                        @endforeach
                    </div>
                </div>
            @endif

            @if($searchable)
                <x-table-lite::search />
            @endif

            @if ( $hasFeature('bulkSelect'))
                <x-table-lite::select-all />
            @endif

            <x-table-lite::table>
                <x-slot:header>
                    @if ( $hasFeature('bulkSelect'))
                        <x-table-lite::header-cell>
                            <x-table-lite::checkbox x-ref="checkallbox" @input="check" />
                        </x-table-lite::header-cell>
                    @endif
                    @foreach($columns as $column)
                        <x-table-lite::header-cell>{{ $column->getLabel()  }}</x-table-lite::header-cell>
                    @endforeach
                    @if($actions)
                        <x-table-lite::header-cell></x-table-lite::header-cell>
                    @endif
                </x-slot:header>
                @if($records)
                    @foreach($records as $record)
                        <x-table-lite::row>
                            @include('table-lite::partials.checkbox')
                            @foreach($columns as $column)
                                <x-table-lite::cell>
                                    <div class="filament-tables-column-wrapper">
                                        {{ $column->record($record)->viewData(['recordKey' => $record->id]) }}
                                    </div>
                                </x-table-lite::cell>
                            @endforeach
                            @include('table-lite::partials.actions')
                        </x-table-lite::row>
                    @endforeach
                @endif
            </x-table-lite::table>
            @if ( $hasFeature('pagination') )
                <x-slot:footer>
                    {{ $links }}
                </x-slot:footer>
            @endif

        </x-table-lite::container>
    </div>
</div>


