@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'error-messages']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
