<!-- MODAL PREVIEW GAMBAR (Hanya di dalam konten utama) -->
<div id="imagePreviewModal"
    class="absolute -inset-4 sm:-inset-6 lg:-inset-8 z-[60] flex flex-col bg-black/70 backdrop-blur-sm opacity-0 invisible transition-all duration-300"
    onclick="closeImagePreview(event)">

    <div class="sticky top-16 flex h-[calc(100vh-64px)] w-full items-center justify-center pointer-events-none">
        <div class="relative max-w-lg w-full mx-4 transform scale-95 transition-transform duration-300 flex justify-center pointer-events-auto" id="imagePreviewModalBox">
            <button type="button" onclick="_doCloseImagePreview()" class="absolute -top-4 -right-4 sm:-right-5 bg-white text-gray-800 hover:text-red-600 rounded-full p-2 shadow-lg transition-colors z-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="bg-white rounded-2xl overflow-hidden shadow-2xl max-h-[75vh] w-full flex items-center justify-center p-2">
                <img id="imagePreviewImg" src="" alt="Preview" class="w-full max-h-[70vh] object-contain rounded-xl">
            </div>
        </div>
    </div>
</div>

<script>
    function openImagePreview(imgSrc) {
        document.getElementById('imagePreviewImg').src = imgSrc;

        const modal = document.getElementById('imagePreviewModal');
        const box = document.getElementById('imagePreviewModalBox');

        modal.classList.remove('opacity-0', 'invisible');
        modal.classList.add('opacity-100', 'visible');
        box.classList.remove('scale-95');
        box.classList.add('scale-100');
        document.body.style.overflow = 'hidden';

        history.pushState({ imagePreviewModal: true }, '');
    }

    function _doCloseImagePreview() {
        const modal = document.getElementById('imagePreviewModal');
        const box = document.getElementById('imagePreviewModalBox');
        if (!modal || modal.classList.contains('invisible')) return;
        
        modal.classList.add('opacity-0', 'invisible');
        modal.classList.remove('opacity-100', 'visible');
        box.classList.add('scale-95');
        box.classList.remove('scale-100');
        document.body.style.overflow = '';
    }

    function closeImagePreview(event) {
        if (event && event.target !== document.getElementById('imagePreviewModal')) return;

        if (history.state && history.state.imagePreviewModal) {
            history.back();
        } else {
            _doCloseImagePreview();
        }
    }

    window.addEventListener('popstate', (e) => {
        _doCloseImagePreview();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeImagePreview();
    });
</script>
