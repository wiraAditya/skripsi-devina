<?php
$pils = $pils ?? ["Semua", "Makanan", "Minuman", "Snack"];
$selectedPils = $selectedPils ?? 'semua';
$baseUrl = $baseUrl ?? '/menu';
?>

<nav class="bg-white shadow-sm overflow-x-auto py-2 sticky top-16 z-10">
    <div class="container mx-auto px-4 flex space-x-2">
    <?php foreach($pils as $row): ?>
    <a href="<?= base_url($baseUrl.'?filter='.strtolower($row)) ?>" 
       class="cursor-pointer px-4 py-2 rounded-full whitespace-nowrap 
              <?= strtolower($row) == $selectedPils ? 'bg-amber-200 text-amber-800 font-semibold' : 'bg-amber-50 text-gray-700' ?>"
       aria-current="<?= strtolower($row) == $selectedPils ? 'page' : 'false' ?>">
      <?= $row ?>
      <span class="sr-only"> category</span>
    </a>
    <?php endforeach; ?>
  </div>
</nav>