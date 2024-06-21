@php
    $getSlideOver = $getSlideOver();
    $component = $getComponent();
@endphp
<div
    @if($getSlideOver) x-on:click="$dispatch('table-lite:show-slide-over-{{ $getKey() }}')" @endif
>
    <x-dynamic-component :$component>
        {{  $getLabel()  }}
    </x-dynamic-component>

    @if($getSlideOver)
        <x-table-lite::slide-over event="table-lite:show-slide-over-{{ $getKey() }}">
            <div>
                @livewire($getSlideOver->component, $getSlideOver->getParams(), key($getKey()))
            </div>
        </x-table-lite::slide-over>
    @endif

</div>
