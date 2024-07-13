@component($typeForm, get_defined_vars())
    @empty(!$value)
        <p {{ $attributes }}>
            @if(is_array($value))
                {{ implode(',', $value) }}
            @else
                {{ $value }}
            @endif
        </p>
    @endempty
@endcomponent
