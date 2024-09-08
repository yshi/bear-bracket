@props(['label', 'slot'])
<div class="w-40 text-right bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded shadow-xl flex flex-col justify-around">
    <div class="text-4xl flex justify-end">
        {{ $slot }}
    </div>
    <span class="text-gray-500 dark:text-gray-300">
        {{ $label }}
    </span>
</div>
