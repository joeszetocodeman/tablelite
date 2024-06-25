<div
    x-data="{ loading: false }"
    x-on:{{ $event }}.window="async() => {
          loading = true
          await $wire.call('{{ $method }}')
          loading = false
    }"
>
    @if($loading)
        <x-skeleton-loading x-show="loading" pattern="{{ $pattern }}"></x-skeleton-loading>
    @endif
</div>
