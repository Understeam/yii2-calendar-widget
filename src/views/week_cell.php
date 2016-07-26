<?php
/**
 * @var \understeam\calendar\CalendarWidget $context
 * @var \yii\web\View $this
 * @var \understeam\calendar\ItemInterface $item
 * @var \understeam\calendar\GridCell $cell
 */

$context = $this->context;
$isActive = $context->isActive($cell->date);
?>
<div class="calendar-week-cell">
    <div class="panel panel-default">
        <div class="panel-body<?=$isActive ? ' active' : '' ?>" data-cal-date="<?=$cell->date->format('Y-m-d H:i') ?>">
            <?= count($cell->items) ?>
        </div>
    </div>
</div>
