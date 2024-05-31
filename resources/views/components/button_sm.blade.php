@props(['color' => 'primary', 'type' => 'button'])

@php
$colorClasses = [
'primary' => 'text-white bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-400',
'warning' => 'text-white bg-color-warning-500 hover:bg-color-warning-600 focus:ring-4 focus:ring-color-warning-400',
'success' => 'text-white bg-color-success-500 hover:bg-color-success-600 focus:ring-4 focus:ring-color-success-400',
'danger' => 'text-white bg-color-danger-500 hover:bg-color-danger-600 focus:ring-4 focus:ring-color-danger-400',
'info' => 'text-white bg-color-info-500 hover:bg-color-info-600 focus:ring-4 focus:ring-color-info-400',
'primary-disabled' => 'text-white bg-color-primary-400 focus:ring-4 focus:ring-color-primary-400',
'warning-disabled' => 'text-white bg-color-warning-400 focus:ring-4 focus:ring-color-warning-400',
'success-disabled' => 'text-white bg-color-success-400 focus:ring-4 focus:ring-color-success-400',
'danger-disabled' => 'text-white bg-color-danger-400 focus:ring-4 focus:ring-color-danger-400',
'info-disabled' => 'text-white bg-color-info-400 focus:ring-4 focus:ring-color-info-400',
'primary-dark' => 'text-slate-800 bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4
focus:ring-color-primary-400',
'warning-dark' => 'text-slate-800 bg-color-warning-500 hover:bg-color-warning-600 focus:ring-4
focus:ring-color-warning-400',
'success-dark' => 'text-slate-800 bg-color-success-500 hover:bg-color-success-600 focus:ring-4
focus:ring-color-success-400',
'danger-dark' => 'text-slate-800 bg-color-danger-500 hover:bg-color-danger-600 focus:ring-4
focus:ring-color-danger-400',
'info-dark' => 'text-slate-800 bg-color-info-500 hover:bg-color-info-600 focus:ring-4 focus:ring-color-info-400',
'primary-outlined' => 'text-color-primary-500 bg-white border border-color-primary-500 hover:bg-color-primary-500
hover:text-white',
'warning-outlined' => 'text-color-warning-500 bg-white border border-color-warning-500 hover:bg-color-warning-500
hover:text-white',
'success-outlined' => 'text-color-success-500 bg-white border border-color-success-500 hover:bg-color-success-500
hover:text-white',
'danger-outlined' => 'text-color-danger-500 bg-white border border-color-danger-500 hover:bg-color-danger-500
hover:text-white',
'info-outlined' => 'text-color-info-500 bg-white border border-color-info-500 hover:bg-color-info-500 hover:text-white',
// tambahkan definisi warna lain di sini sesuai kebutuhan Anda
];

$class = $colorClasses[$color] ?? 'text-slate-800 bg-white hover:bg-gray-100';
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'px-3 py-2 text-sm font-medium text-center rounded-lg
    transition-color duration-300 ' .
    $class]) }}>
    {{ $slot }}
</button>