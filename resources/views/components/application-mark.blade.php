{{--
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
  <path d="M11.395 44.428C4.557 40.198 0 32.632 0 24 0 10.745 10.745 0 24 0a23.891 23.891 0 0113.997 4.502c-.2 17.907-11.097 33.245-26.602 39.926z" fill="#6875F5"/>
  <path d="M14.134 45.885A23.914 23.914 0 0024 48c13.255 0 24-10.745 24-24 0-3.516-.756-6.856-2.115-9.866-4.659 15.143-16.608 27.092-31.75 31.751z" fill="#6875F5"/>
</svg>
--}}
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
    @foreach (range(1, $rows) as $rowNumber)
        @foreach (range(1, $columns) as $columnNumber)
            @php
                $cellIndex++;
                $x = $columnNumber * $cellWidth;
                $y = $rowNumber * $cellHeight;

                $fillColour = 'none';
                if (in_array($cellIndex, $dimCells)) {
                    $fillColour = '';
                }
            @endphp
            <rect width="{{ $cellWidth }}" height="{{ $cellHeight }}" x="{{ $x }}" y="{{ $y }}"
                  fill="{{ $fillColour }}"></rect>
        @endforeach
    @endforeach
</svg>
