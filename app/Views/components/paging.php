<?php
use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<div class="flex items-center justify-between mt-8 px-4">
    <!-- Pagination -->
    <nav class="flex items-center gap-2">
        <!-- First/Previous -->
        <div class="flex items-center gap-2">
            <?php if ($pager->hasPreviousPage()) : ?>
                <a href="<?= $pager->getFirst() ?>" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors" aria-label="First">
                    <i class="fas fa-angle-double-left text-sm"></i>
                </a>
                <a href="<?= $pager->getPreviousPage() ?>" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors" aria-label="Previous">
                    <i class="fas fa-angle-left text-sm"></i>
                </a>
            <?php else : ?>
                <span class="p-2 rounded-lg text-gray-300 cursor-not-allowed">
                    <i class="fas fa-angle-double-left text-sm"></i>
                </span>
                <span class="p-2 rounded-lg text-gray-300 cursor-not-allowed">
                    <i class="fas fa-angle-left text-sm"></i>
                </span>
            <?php endif ?>
        </div>

        <!-- Page Numbers -->
        <div class="flex items-center gap-1 bg-gray-50 rounded-lg p-1">
            <?php foreach ($pager->links() as $link) : ?>
                <a href="<?= $link['uri'] ?>" class="w-8 h-8 flex items-center justify-center rounded-md text-sm font-medium <?= $link['active'] ? 'bg-white shadow-sm text-blue-600 border border-gray-200' : 'text-gray-600 hover:bg-gray-100' ?> transition-colors">
                <?= $link['title'] ?>

                </a>
            <?php endforeach ?>
        </div>

        <!-- Next/Last -->
        <div class="flex items-center gap-2">
            <?php if ($pager->hasNextPage()) : ?>
                <a href="<?= $pager->getNextPage() ?>" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors" aria-label="Next">
                    <i class="fas fa-angle-right text-sm"></i>
                </a>
                <a href="<?= $pager->getLast() ?>" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors" aria-label="Last">
                    <i class="fas fa-angle-double-right text-sm"></i>
                </a>
            <?php else : ?>
                <span class="p-2 rounded-lg text-gray-300 cursor-not-allowed">
                    <i class="fas fa-angle-right text-sm"></i>
                </span>
                <span class="p-2 rounded-lg text-gray-300 cursor-not-allowed">
                    <i class="fas fa-angle-double-right text-sm"></i>
                </span>
            <?php endif ?>
        </div>
    </nav>
</div>