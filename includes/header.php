<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($judul) ? htmlspecialchars($judul) : 'Taking Order Cafe'; ?></title>

    <!-- Preload logo -->
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(logoSrc()); ?>">
    <link rel="preload" as="image" href="<?= htmlspecialchars(logoSrc()); ?>">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'soft-pink':  '#F7B5CA',
                        'rose-pink':  '#D86B88',
                        'deep-berry': '#8A2B43',
                        'wood-brown': '#7A4B3A',
                        'cream':      '#FFF5F7',
                        'coffee':     '#331A21',
                    },
                    fontFamily: {
                        sans:    ['Plus Jakarta Sans','system-ui','sans-serif'],
                        display: ['Playfair Display','serif'],
                    },
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= htmlspecialchars(asset('assets/css/custom.css')); ?>">
</head>
<body class="bg-cream text-coffee font-sans antialiased min-h-screen flex flex-col">