<?php

$pils = $pils ?? ["Semua", "Makanan", "Minuman", "Snack"];
$selectedPils = $selectedPils ?? 'semua';
$baseUrl = $baseUrl ?? '/menu';

?>

<nav aria-label="Menu categories">
  <div class="flex overflow-x-auto mb-6 pb-2 gap-2">
    <?php foreach($pils as $row): ?>
    <a href="<?= base_url($baseUrl.'?filter='.strtolower($row)) ?>" 
       class="cursor-pointer px-4 py-2 rounded-full whitespace-nowrap 
              <?= strtolower($row) == $selectedPils ? 'bg-amber-100 text-amber-800 font-semibold' : 'bg-white text-gray-700' ?>"
       aria-current="<?= strtolower($row) == $selectedPils ? 'page' : 'false' ?>">
      <?= $row ?>
      <span class="sr-only"> category</span>
    </a>
    <?php endforeach; ?>
  </div>
</nav>
