<header class="main-header sticky top-0 z-30 border-b border-gray-200 bg-white/95 backdrop-blur-sm">
    <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
        <!-- Kiri: Button Menu Mobile & Judul Halaman -->
        <div class="flex items-center gap-3.5">
            <button type="button" 
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 md:hidden" 
                    onclick="openSidebar()" 
                    aria-label="Buka menu">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <h1 class="text-xl font-extrabold tracking-tight text-gray-900 sm:text-2xl">
                @yield('page-title', 'Dashboard')
            </h1>
        </div>

        <!-- Kanan: Profile Dropdown Terisolasi dengan Alpine.js -->
        <div class="relative" x-data="{ open: false }">
            <button type="button" 
                    class="flex items-center gap-2.5 rounded-full border border-transparent px-2 py-1.5 text-left transition hover:bg-gray-100 focus:outline-none" 
                    @click="open = !open" 
                    aria-label="Menu profil">
                <div class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-full bg-blue-100 shrink-0">
                    <img src="/images/avatar-admin.webp" alt="Avatar" class="h-full w-full object-cover"
                         onerror="this.style.display='none';this.parentElement.innerHTML='<svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'#3b82f6\' class=\'h-5 w-5\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\'/></svg>'">
                </div>
                <span class="hidden text-sm font-bold text-gray-900 md:inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                <span class="text-gray-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" 
                 @click.outside="open = false" 
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 x-cloak
                 class="absolute right-0 top-[calc(100%+8px)] z-50 w-52 rounded-xl border border-gray-200 bg-white p-1.5 shadow-xl shadow-gray-200/80">
                
                <div class="border-b border-gray-100 px-3 py-2.5">
                    <div class="text-sm font-bold text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="text-[11px] font-medium text-gray-400">Administrator</div>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50 hover:text-gray-900">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profil Saya
                </a>

                <div class="my-1 h-px bg-gray-100"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-left text-sm font-semibold text-red-500 transition hover:bg-red-50">
                        <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>