<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $title ?? 'Login' ?></title>
    <link href="<?= base_url('css/tailwind.css') ?>" rel="stylesheet">
    <script src="https://kit.fontawesome.com/bf150e08d8.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <?= $this->renderSection('content') ?>  <!-- Only dynamic content -->
</body>
</html>