<x-guest-layout>
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">
            Reset Password
        </h2>
        <p class="text-sm text-gray-500 text-center mb-6">
            Masukkan password baru Anda
        </p>

        <form method="POST" action="/reset-password" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

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

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Password Baru
                </label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    placeholder="Password baru"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Konfirmasi Password
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    required
                    placeholder="Konfirmasi password"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
            </div>

            <button 
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition"
            >
                Reset Password
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            <a href="/login" class="text-blue-600 hover:underline font-medium">
                Kembali ke Login
            </a>
        </p>
</x-guest-layout>