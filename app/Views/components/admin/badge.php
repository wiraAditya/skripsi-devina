<?php
/**
 * Reusable Badge Component
 * 
 * @param string $text - Text to display in the badge
 * @param string $type - Type of badge (success, danger, info, warning, primary)
 * @param string $customClass - Optional custom class to add
 */

$colors = [
    'success' => 'bg-green-100 text-green-800',
    'danger' => 'bg-red-100 text-red-800',
    'info' => 'bg-blue-100 text-blue-800',
    'warning' => 'bg-yellow-100 text-yellow-800',
    'primary' => 'bg-purple-100 text-purple-800',
];

$colorClass = isset($colors[$type]) ? $colors[$type] : 'bg-gray-100 text-gray-800';
$extraClass = isset($customClass) ? $customClass : '';
?>

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $colorClass ?> <?= $extraClass ?>">
    <?= esc($text) ?>
</span>