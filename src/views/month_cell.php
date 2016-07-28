<?php
/**
 * @var \understeam\calendar\CalendarWidget $context
 * @var \yii\web\View $this
 * @var \understeam\calendar\ItemInterface $item
 * @var \understeam\calendar\GridCell $cell
 */

use yii\helpers\Html;

$context = $this->context;
$options = $context->getCellOptions($cell);
Html::addCssClass($options, 'panel-body');
?>
<div class="calendar-month-cell">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= $cell->date->format('d') ?>
        </div>
        <?= Html::beginTag('div', $options) ?>
        <?= count($cell->items) ?>
        <?= Html::endTag('div') ?>
    </div>
</div>
