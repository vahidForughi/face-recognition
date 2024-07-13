@push('head')
    <link href="{{ URL::asset('assets/favicon.png?i=2') }}" id="favicon" rel="icon" >
@endpush

<div class="h2 d-flex align-items-center">
    @auth
        <x-orchid-icon path="bs.house" class="d-inline d-xl-none"/>
    @endauth
    <p class="my-0 {{ auth()->check() ? 'd-none d-xl-block' : '' }}">
        {{ config('app.name') }}
        <small class="align-top opacity">{{ config('app.env') }}</small>
    </p>
</div>
