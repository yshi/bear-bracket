@php
    $columns = 13;
    $rows = 8;

    $cellWidth = $cellHeight = 25;
    $viewWidth = $cellWidth * ($columns + 1);
    $viewHeight = $cellHeight * ($rows + 1);

    $dimCells = [
        16, 17, 23, 24,
        ...range(30, 36),
        42, 43, 45, 46, 47, 49, 50,
        ...range(55, 58),
        ...range(60, 63),
        69, 70, 74, 75,
        ...range(83, 87),
    ];

    $cellIndex = 0;
@endphp
<svg viewBox="0 0 {{ $viewWidth }} {{ $viewHeight }}" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <style>
        /* fill-amber-900 dark:fill-white */
        rect {
            fill: #78350f;
        }

        @media(prefers-color-scheme: dark) {
            rect {
                fill: white;
            }
        }
    </style>

    @foreach (range(1, $rows) as $rowNumber)
        @foreach (range(1, $columns) as $columnNumber)
            @php
                $cellIndex++;
                $x = $columnNumber * $cellWidth;
                $y = $rowNumber * $cellHeight;

                if (! in_array($cellIndex, $dimCells)) {
                    continue;
                }
            @endphp
            <rect width="{{ $cellWidth }}" height="{{ $cellHeight }}" x="{{ $x }}" y="{{ $y }}"></rect>
        @endforeach
    @endforeach
</svg>
