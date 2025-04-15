<?php
/**
 * Reusable Pagination Component
 * 
 * @param object $pager - The pager instance
 * @param string $group - The pager group (default: 'default')
 */

$group = isset($group) ? $group : 'default';
$template = isset($template) ? $template : 'styled';
?>

<?php if ($pager->getPageCount() > 1): ?>
<div class="mt-4 flex flex-col sm:flex-row items-center justify-between">
    <div class="text-sm text-gray-500 mb-2 sm:mb-0">
        Menampilkan <?= $pager->getCurrentPage() * $pager->getPerPage() - $pager->getPerPage() + 1 ?>
        sampai <?= min($pager->getCurrentPage() * $pager->getPerPage(), $pager->getTotal()) ?>
        dari <?= $pager->getTotal() ?> data
    </div>
    <div class="flex space-x-1">
        <?= $pager->links($group, $template) ?>
    </div>
</div>
<?php endif; ?>