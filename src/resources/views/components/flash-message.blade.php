@php
  if (session('status') === 'info') { $textColor = 'text-blue-700'; $bgColor = 'bg-blue-100'; $borderColor = 'border-blue-500'; }
  if (session('status') === 'error') { $textColor = 'text-red-700'; $bgColor = 'bg-red-100'; $borderColor = 'border-red-500'; }
@endphp

@if (session('message'))
  <div class="{{ $textColor . ' ' . $bgColor . ' ' .  $borderColor }}  border-y mt-3 px-4 py-3 font-bold text-sm dark:bg-gray-800 dark:text-gray-400 dark:border-gray-400">
    {{ session('message') }}
  </div>
@endif