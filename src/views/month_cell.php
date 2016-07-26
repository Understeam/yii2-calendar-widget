<?php
/**
 * @var \understeam\calendar\CalendarWidget $context
 * @var \yii\web\View $this
 * @var \understeam\calendar\ItemInterface $item
 * @var \understeam\calendar\GridCell $cell
 */

$context = $this->context;
$currentMonth = $context->isInPeriod($cell->date);
$isActive = $context->isActive($cell->date);
?>
<div class="calendar-month-cell">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= $cell->date->format('d') ?>
        </div>
        <div class="panel-body<?=$isActive ? ' active' : '' ?><?=$currentMonth ? '' : ' out' ?>" data-cal-date="<?=$cell->date->format('Y-m-d') ?>">
            <?= count($cell->items) ?>
        </div>
    </div>
</div>
