<?php
if (!empty($alert)):
    $colors = [
        'success' => 'bg-green-50 border-green-200 text-green-700',
        'error'   => 'bg-red-50 border-red-200 text-red-700',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
        'info'    => 'bg-blue-50 border-blue-200 text-blue-700',
    ];
    $icons = [
        'success' => 'bi-check-circle-fill',
        'error'   => 'bi-exclamation-circle-fill',
        'warning' => 'bi-exclamation-triangle-fill',
        'info'    => 'bi-info-circle-fill',
    ];
    $type = $alert['type'] ?? 'info';
?>
<div class="<?= $colors[$type] ?? $colors['info']; ?> border px-4 py-3 rounded-lg mb-5 text-sm flex items-start gap-2" data-autohide>
    <i class="bi <?= $icons[$type] ?? $icons['info']; ?> mt-0.5"></i>
    <span><?= htmlspecialchars($alert['msg']); ?></span>
</div>
<?php endif; ?>