<footer class="bg-coffee text-cream/85 mt-auto">
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid md:grid-cols-3 gap-8 items-start">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <img src="<?= htmlspecialchars(logoSrc()); ?>" alt="Taking Order Cafe" class="brand-logo">
                    <div>
                        <p class="font-display text-lg text-cream leading-none">Taking Order Cafe</p>
                        <p class="text-xs text-cream/60 mt-1">Sistem Pemesanan Berbasis Web</p>
                    </div>
                </div>
                <p class="text-sm text-cream/70 max-w-xs">
                    Nikmati kopi terbaik dan suasana hangat tanpa harus mengantre.
                </p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-soft-pink mb-3">Kunjungi</p>
                <ul class="space-y-1.5 text-sm text-cream/80">
                    <li><i class="bi bi-geo-alt me-2 text-rose-pink"></i>Jl. Contoh Alamat No. 123, Kota Anda</li>
                    <li><i class="bi bi-telephone me-2 text-rose-pink"></i>021-1234567</li>
                    <li><i class="bi bi-envelope me-2 text-rose-pink"></i>info@takingordercafe.com</li>
                </ul>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-soft-pink mb-3">Jam Buka</p>
                <ul class="space-y-1.5 text-sm text-cream/80">
                    <li><i class="bi bi-clock me-2 text-rose-pink"></i>Senin–Jumat · 08.00–22.00</li>
                    <li><i class="bi bi-clock me-2 text-rose-pink"></i>Sabtu–Minggu · 09.00–23.00</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-cream/15 mt-8 pt-5 text-center text-xs text-cream/60">
            &copy; <?= date('Y'); ?> Taking Order Cafe · Semua hak dilindungi
        </div>
    </div>
</footer>
<script src="<?= htmlspecialchars(asset('assets/js/main.js')); ?>"></script>
</body>
</html>