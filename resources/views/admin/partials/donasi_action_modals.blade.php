<!-- Modal Validasi Donasi -->
<div id="validasiModal" class="pointer-events-auto absolute inset-0 z-50 hidden flex-col items-center justify-center bg-black/50 backdrop-blur-sm px-4">
    <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-xl" onclick="event.stopPropagation()">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Validasi Donasi</p>
                <h3 class="mt-2 text-lg font-bold text-gray-900">Kode: <span id="validasiModalKode"></span></h3>
            </div>
            <button type="button" class="rounded-full p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-900" onclick="closeValidasiModal()" aria-label="Tutup modal validasi">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <p class="mt-4 text-sm text-gray-600">Masukkan catatan admin untuk donasi yang diterima.</p>

        <form id="validasiForm" method="POST" class="mt-5 space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label for="catatan_admin_validasi" class="text-sm font-semibold text-gray-700">Catatan Admin</label>
                <textarea id="catatan_admin_validasi" name="catatan_admin" rows="4" placeholder="Contoh: Donasi telah diterima, terima kasih."
                          class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50" onclick="closeValidasiModal()">Batal</button>
                <button type="submit" class="rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">Validasi Donasi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tolak Donasi -->
<div id="tolakModal" class="pointer-events-auto absolute inset-0 z-50 hidden flex-col items-center justify-center bg-black/50 backdrop-blur-sm px-4">
    <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-xl" onclick="event.stopPropagation()">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Tolak Donasi</p>
                <h3 class="mt-2 text-lg font-bold text-gray-900">Kode: <span id="tolakModalKode"></span></h3>
            </div>
            <button type="button" class="rounded-full p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-900" onclick="closeTolakModal()" aria-label="Tutup modal tolak">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <p class="mt-4 text-sm text-gray-600">Masukkan catatan admin jika perlu, untuk donasi yang akan ditolak.</p>

        <form id="tolakForm" method="POST" class="mt-5 space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label for="catatan_admin" class="text-sm font-semibold text-gray-700">Catatan Admin</label>
                <textarea id="catatan_admin" name="catatan_admin" rows="4" placeholder="Contoh: Bukti transfer tidak valid atau data tidak sesuai."
                          class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50" onclick="closeTolakModal()">Batal</button>
                <button type="submit" class="rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700">Tolak Donasi</button>
            </div>
        </form>
    </div>
</div>

<script>
    const validasiModal = document.getElementById('validasiModal');
    const tolakModal = document.getElementById('tolakModal');
    const validasiForm = document.getElementById('validasiForm');
    const tolakForm = document.getElementById('tolakForm');

    function openValidasiModal(button) {
        const route = button.dataset.validasiRoute;
        const kode = button.dataset.kodeDonasi;

        validasiForm.action = route;
        document.getElementById('validasiModalKode').textContent = kode;
        validasiModal.classList.remove('hidden');
        validasiModal.classList.add('flex');
    }

    function closeValidasiModal() {
        validasiModal.classList.add('hidden');
        validasiModal.classList.remove('flex');
    }

    function openTolakModal(button) {
        const route = button.dataset.tolakRoute;
        const kode = button.dataset.kodeDonasi;

        tolakForm.action = route;
        document.getElementById('tolakModalKode').textContent = kode;
        tolakModal.classList.remove('hidden');
        tolakModal.classList.add('flex');
    }

    function closeTolakModal() {
        tolakModal.classList.add('hidden');
        tolakModal.classList.remove('flex');
    }

    validasiModal.addEventListener('click', function (event) {
        if (event.target === validasiModal) {
            closeValidasiModal();
        }
    });

    tolakModal.addEventListener('click', function (event) {
        if (event.target === tolakModal) {
            closeTolakModal();
        }
    });
</script>
