@php
    $getSlideOver = $getSlideOver();
    $component = $getComponent();
    $record = $getRecord();
    $name = $getName();
@endphp
<div
    @if($getSlideOver)
        x-on:click="() => {
            let event = 'table-lite:show-slide-over-{{ $getKey() }}'
            $dispatch(event)
            $wire.emit(event)
        }"
    @endif
    @if(!$getSlideOver)
        wire:click="callTableAction('{{ $getName() }}', '{{ $record->id }}' )"
    @endif
>
    <x-dynamic-component :$component>
        {{ $getLabel()  }}
    </x-dynamic-component>

    @if($getSlideOver)
        <x-table-lite::slide-over event="table-lite:show-slide-over-{{ $getKey() }}">
            <div>
                @livewire($getSlideOver->getComponent(), $getSlideOver->getParams(), key($getKey()))
            </div>
        </x-table-lite::slide-over>
    @endif

</div>
