@php
    $getSlideOver = $getSlideOver();
    $component = $getComponent();
    $record = $getRecord();
    $name = $getName();
    $disable = $getDisable();
    $url = $getUrl();
    $openInNewTab = $shouldOpenUrlInNewTab();
@endphp
<div>
    @if($url && !$disable)
        <a href="{{ $url }}" @if($openInNewTab) target="_blank" @endif>
            <x-dynamic-component :$component>
                {{ $getLabel() }}
            </x-dynamic-component>
        </a>
    @else
        <div
            @if($getSlideOver && !$disable)
                x-on:click="() => {
                    let event = 'table-lite:show-slide-over-{{ $getKey() }}'
                    $dispatch(event)
                    $wire.dispatch(event)
                }"
            @endif
            @if (!$getSlideOver && !$url && !$disable)
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
    @endif

    @if($getSlideOver)
        <x-table-lite::slide-over wire:key="{{ str()->uuid() }}" event="table-lite:show-slide-over-{{ $getKey() }}">
            <div>
                @livewire($getSlideOver->getComponent(), $getSlideOver->getParams(), key($getKey()))
            </div>
        </x-table-lite::slide-over>
    @endif
</div>
