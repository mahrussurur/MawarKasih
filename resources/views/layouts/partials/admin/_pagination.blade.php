@if ($paginator->hasPages())
<div class="flex items-center justify-between mt-4">
    <!-- Info Halaman Singkat -->
    <p class="text-xs text-gray-500">
        Halaman <span class="font-semibold text-gray-700">{{ $paginator->currentPage() }}</span> dari <span class="font-semibold text-gray-700">{{ $paginator->lastPage() }}</span>
    </p>

    <!-- Tombol Navigasi -->
    <div class="flex items-center gap-1">
        <!-- Prev -->
        <a href="{{ $paginator->previousPageUrl() ?? '#' }}"
           class="inline-flex items-center justify-center h-8 px-2.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 rounded-md transition hover:bg-gray-50 {{ $paginator->onFirstPage() ? 'pointer-events-none opacity-40' : '' }}">
            &larr; Prev
        </a>

        @php
            $current = $paginator->currentPage();
            $last    = $paginator->lastPage();
        @endphp

        {{-- Halaman 1 selalu tampil --}}
        <a href="{{ $paginator->url(1) }}"
           class="inline-flex items-center justify-center h-8 w-8 text-xs font-medium rounded-md transition {{ $current == 1 ? 'bg-blue-600 text-white font-bold shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            1
        </a>

        {{-- Halaman aktif (hanya jika bukan halaman 1 atau terakhir) --}}
        @if ($current > 1 && $current < $last)
            <a href="{{ $paginator->url($current) }}"
               class="inline-flex items-center justify-center h-8 w-8 text-xs font-medium rounded-md transition bg-blue-600 text-white font-bold shadow-sm">
                {{ $current }}
            </a>
        @endif

        {{-- Halaman terakhir selalu tampil (jika lebih dari 1) --}}
        @if ($last > 1)
            <a href="{{ $paginator->url($last) }}"
               class="inline-flex items-center justify-center h-8 w-8 text-xs font-medium rounded-md transition {{ $current == $last ? 'bg-blue-600 text-white font-bold shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                {{ $last }}
            </a>
        @endif

        <!-- Next -->
        <a href="{{ $paginator->nextPageUrl() ?? '#' }}"
           class="inline-flex items-center justify-center h-8 px-2.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 rounded-md transition hover:bg-gray-50 {{ !$paginator->hasMorePages() ? 'pointer-events-none opacity-40' : '' }}">
            Next &rarr;
        </a>
    </div>
</div>
@endif
