document.addEventListener('DOMContentLoaded', () => {

    // 1. Auto-dismiss alert
    document.querySelectorAll('[data-autohide]').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-8px)';
            setTimeout(() => el.remove(), 300);
        }, 4000);
    });

    // 2. Preview upload gambar
    const fileInput = document.querySelector('input[type="file"][name="gambar"]');
    const preview = document.getElementById('previewGambar');
    if (fileInput && preview) {
        fileInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran gambar maksimal 2MB.');
                fileInput.value = '';
                return;
            }
            if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                alert('Format gambar harus JPG, PNG, atau WEBP.');
                fileInput.value = '';
                return;
            }
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        });
    }

    // 3. Konfirmasi hapus global
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', e => {
            if (!confirm(el.dataset.confirm)) e.preventDefault();
        });
    });
});