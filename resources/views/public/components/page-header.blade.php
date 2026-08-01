@props(['title'])

<div class="bg-gray-100 border-b border-gray-100 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h1 class="text-2xl font-light text-gray-800">{{ $title }}</h1>
        <div class="text-sm font-medium flex items-center gap-2">
            <a href="{{ route('public.home') }}" class="text-blue-600 hover:text-blue-700 hover:underline transition-colors">Home</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-600">{{ $title }}</span>
        </div>
    </div>
</div>
