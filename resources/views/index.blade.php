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
    $emptyMsg = $getEmptyMsg();
    $detailAction = collect($actions)->first(fn($action) => $action InstanceOf \Tablelite\SupportActions\DetailAction);
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

            <x-tables::table>
                @if($records)
                    <x-slot:header>
                        @if ( $hasFeature('bulkSelect'))
                            <x-tables::header-cell>
                                <x-tables::checkbox x-ref="checkallbox" @input="check" />
                            </x-tables::header-cell>
                        @endif
                        @foreach($columns as $column)
                            <x-tables::header-cell
                                :isSortColumn="true"
                                :sortable="$column->isSortable()"
                                name="{{ $column->getName() }}"
                                sortDirection="{{ $getSortDirection($column->getName()) }}"
                            >{{ $column->getLabel()  }}
                            </x-tables::header-cell>
                        @endforeach
                        @if($actions)
                            <x-tables::header-cell></x-tables::header-cell>
                        @endif
                    </x-slot:header>
                    @foreach($records as $record)
                        <x-tables::row>
                            @include('table-lite::partials.checkbox')
                            @foreach($columns as $column)
                                <x-tables::cell>
                                    @if( $detailAction )
                                        <a href="{{ $detailAction->record($record)->getUrl() }}" class="filament-tables-column-wrapper">
                                            {{ $column->record($record)->viewData(['recordKey' => $record->id]) }}
                                        </a>
                                    @else
                                        <div class="filament-tables-column-wrapper">
                                            {{ $column->record($record)->viewData(['recordKey' => $record->id]) }}
                                        </div>
                                    @endif
                                </x-tables::cell>
                            @endforeach
                            @include('table-lite::partials.actions')
                        </x-tables::row>
                    @endforeach
                @else
                    <x-tables::row>
                    @include('table-lite::partials.empty', ['emptyMsg' => $emptyMsg])
                    </x-tables::row>
                @endif
            </x-tables::table>
            @if ( $hasFeature('pagination') )
                <x-slot:footer>
                    {{ $links }}
                </x-slot:footer>
            @endif

        </x-table-lite::container>
    </div>
</div>


