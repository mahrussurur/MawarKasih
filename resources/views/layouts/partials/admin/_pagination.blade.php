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

        <!-- Angka Halaman Aktif & Sekitarnya -->
        @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 1), min($paginator->lastPage(), $paginator->currentPage() + 1)) as $page => $url)
            <a href="{{ $url }}"
               class="inline-flex items-center justify-center h-8 w-8 text-xs font-medium rounded-md transition {{ $page == $paginator->currentPage() ? 'bg-blue-600 text-white font-bold shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                {{ $page }}
            </a>
        @endforeach

        <!-- Next -->
        <a href="{{ $paginator->nextPageUrl() ?? '#' }}"
           class="inline-flex items-center justify-center h-8 px-2.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 rounded-md transition hover:bg-gray-50 {{ !$paginator->hasMorePages() ? 'pointer-events-none opacity-40' : '' }}">
            Next &rarr;
        </a>
    </div>
</div>
@endif
