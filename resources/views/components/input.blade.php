@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-400 focus:ring-opacity-50']) !!}>
