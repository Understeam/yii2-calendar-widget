<?php
/**
 * @var \understeam\calendar\CalendarWidget $context
 * @var \yii\web\View $this
 * @var \understeam\calendar\ItemInterface $item
 * @var \understeam\calendar\GridCell $cell
 */

use yii\helpers\Html;

$context = $this->context;
$options = $context->getCellOptions($cell, true);
Html::addCssClass($options, 'panel-body');
?>
<div class="calendar-week-cell">
    <div class="panel panel-default">
        <?= Html::beginTag('div', $options) ?>
        <?= count($cell->items) ?>
        <?= Html::endTag('div') ?>
    </div>
</div>
