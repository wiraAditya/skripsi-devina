<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?? 'Login' ?></title>
    <link href="<?= base_url('css/tailwind.css') ?>" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?= $this->renderSection('content') ?>  <!-- Only dynamic content -->
</body>
</html>