<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-xl" onclick="event.stopPropagation()">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Konfirmasi Hapus</p>
                <h3 class="mt-2 text-lg font-bold text-gray-900">Hapus data <span id="deleteModalName"></span>?</h3>
            </div>
            <button type="button" class="rounded-full p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-900" onclick="closeDeleteModal()" aria-label="Tutup modal hapus">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <p class="mt-4 text-sm text-gray-600">Hapus data permanen. Pastikan data ini sudah tidak diperlukan lagi.</p>
        <form id="deleteForm" method="POST" class="mt-5 flex justify-end gap-3">
            @csrf
            @method('DELETE')
            <button type="button" class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50" onclick="closeDeleteModal()">Batal</button>
            <button type="submit" class="rounded-2xl bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700">Hapus</button>
        </form>
    </div>
</div>

<script>
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');

    function openDeleteModal(button) {
        const route = button.dataset.deleteRoute;
        const name = button.dataset.name;
        
        if(deleteForm && deleteModal) {
            deleteForm.action = route;
            const nameEl = document.getElementById('deleteModalName');
            if (nameEl) nameEl.textContent = name || '';
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex');
        }
    }

    function closeDeleteModal() {
        if(deleteModal) {
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
        }
    }

    if(deleteModal) {
        deleteModal.addEventListener('click', function (event) {
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        });
    }
</script>
