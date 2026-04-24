<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">
        Lupa Password
    </h2>
    <p class="text-sm text-gray-500 text-center mb-6">
        Masukkan email untuk menerima link reset password
    </p>
    @if(session('status'))
        <div class="mb-4 text-sm text-green-600 text-center">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="/forgot-password" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Email
            </label>
            <input 
                type="email" 
                name="email" 
                required
                placeholder="Masukkan email"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
            >
        </div>
        <button 
            type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition"
        >
            Kirim Link Reset
        </button>
    </form>
    <p class="text-center text-sm text-gray-500 mt-6">
        Ingat password?
        <a href="/login" class="text-blue-600 hover:underline font-medium">
            Kembali ke Login
        </a>
    </p>

    @error('email')
        <p class="text-sm text-red-500 mt-1">Email tidak valid</p>
    @enderror
</x-guest-layout>