{{--
    GLOBAL TOAST NOTIFICATION
    Shared across admin & public layouts.
--}}

<div id="{{ $id ?? 'toastContainer' }}"
     class="pointer-events-none fixed left-1/2 top-6 z-[9999] flex -translate-x-1/2 flex-col gap-3"
     style="min-width: 300px; max-width: 420px;">
</div>

<style>
    .toast-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 14px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.15), 0 2px 8px rgba(0,0,0,0.08);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 500;
        line-height: 1.5;
        pointer-events: all;
        transform: translateY(-150%);
        opacity: 0;
        transition: transform 0.38s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
    }

    .toast-item.show {
        transform: translateY(0);
        opacity: 1;
    }

    .toast-item.hide {
        transform: translateY(-150%);
        opacity: 0;
    }

    .toast-success { background: #22c55e; }
    .toast-error   { background: #ef4444; }
    .toast-warning { background: #f59e0b; }
    .toast-info    { background: #3b82f6; }

    .toast-icon {
        flex-shrink: 0;
        width: 20px;
        height: 20px;
        margin-top: 1px;
    }

    .toast-close {
        flex-shrink: 0;
        margin-left: auto;
        opacity: 0.75;
        cursor: pointer;
        background: none;
        border: none;
        color: inherit;
        padding: 0;
        font-size: 18px;
        line-height: 1;
        transition: opacity 0.2s;
    }

    .toast-close:hover {
        opacity: 1;
    }
</style>

<script>
(function() {
    const ICONS = {
        success: `<svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke-opacity=".4" fill="none"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 13l3.5 3.5L17 9"/></svg>`,
        error: `<svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke-opacity=".4" fill="none"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6M9 9l6 6"/></svg>`,
        warning: `<svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 3h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>`,
        info: `<svg class="toast-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke-opacity=".4" fill="none"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8h.01M12 12v4"/></svg>`,
    };

    window.showToast = function(message, type = 'success', duration = 4000, containerId = 'toastContainer') {
        const container = document.getElementById(containerId);
        if (!container || !message) return;

        const toast = document.createElement('div');
        toast.className = `toast-item toast-${type} relative overflow-hidden`;
        toast.innerHTML = `
            ${ICONS[type] || ICONS.info}
            <span style="flex: 1;">${message}</span>
            <button class="toast-close" onclick="this.closest('.toast-item').remove()" aria-label="Tutup">&times;</button>
        `;

        container.appendChild(toast);
        requestAnimationFrame(() => requestAnimationFrame(() => toast.classList.add('show')));

        const timer = setTimeout(() => dismissToast(toast), duration);
        toast.addEventListener('mouseenter', () => clearTimeout(timer));
        toast.addEventListener('mouseleave', () => setTimeout(() => dismissToast(toast), 1500));
    };

    function dismissToast(toast) {
        if (!toast.isConnected) return;
        toast.classList.remove('show');
        toast.classList.add('hide');
        toast.addEventListener('transitionend', () => toast.remove(), { once: true });
    }

    function initToastFromSession() {
        @if(session('success'))
            showToast(@json(session('success')), 'success');
        @endif

        @if(session('error'))
            showToast(@json(session('error')), 'error');
        @endif

        @if(session('warning'))
            showToast(@json(session('warning')), 'warning');
        @endif

        @if(session('info'))
            showToast(@json(session('info')), 'info');
        @endif

        @if(session('status'))
            @php
                $status = session('status');
                $statusMessages = [
                    'profile-updated' => 'Profil berhasil diperbarui.',
                    'password-updated' => 'Password berhasil diperbarui.',
                    'verification-link-sent' => 'Link verifikasi telah dikirim ke email Anda.',
                ];
                $statusMsg = $statusMessages[$status] ?? $status;
            @endphp
            showToast(@json($statusMsg), 'success');
        @endif

        @if($errors->any() && !session('success') && !session('error'))
            @php $firstError = $errors->first(); @endphp
            showToast(@json($firstError), 'error');
        @endif
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initToastFromSession);
    } else {
        initToastFromSession();
    }
})();
</script>
