@if ($actions)
    <x-tables::cell>
        <div
                class="filament-tables-actions-cell whitespace-nowrap px-4 py-3 flex justify-end space-x-2">
            @foreach($actions as $action)
                @php
                    $action->record($record)->setKey( str(data_get($record, $keyBy))->slug()->value()  );
                @endphp
                <div
                        wire:key="action-{{ $action->getKey() }}"
                        class="filament-tables-actions-container flex items-center gap-4 justify-end">
                    {{ $action }}
                </div>
            @endforeach
        </div>
    </x-tables::cell>
@endif
