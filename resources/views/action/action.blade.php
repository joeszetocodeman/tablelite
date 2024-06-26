@php
    $getSlideOver = $getSlideOver();
    $component = $getComponent();
    $record = $getRecord();
    $name = $getName();
    $disable = $getDisable();
@endphp
<div>
    <div
        @if($getSlideOver && !$disable)
            x-on:click="() => {
                let event = 'table-lite:show-slide-over-{{ $getKey() }}'
                $dispatch(event)
                $wire.emit(event)
            }"
        @endif
        @if (!$getSlideOver && !$disable)
            wire:click="callTableAction('{{ $getName() }}', '{{ $record->id }}' )"
        @endif
    >
        @if($disable)
            <x-dynamic-component :$component disabled="disabled" class="opacity-50 disabled:cursor-not-allowed">
                {{ $getLabel()  }}
            </x-dynamic-component>
        @else
            <x-dynamic-component :$component>
                {{ $getLabel()  }}
            </x-dynamic-component>
        @endif
    </div>

    @if($getSlideOver)
        <x-table-lite::slide-over event="table-lite:show-slide-over-{{ $getKey() }}">
            <div>
                @livewire($getSlideOver->getComponent(), $getSlideOver->getParams(), key($getKey()))
            </div>
        </x-table-lite::slide-over>
    @endif
</div>
