<?php
/**
 * @var \understeam\calendar\CalendarWidget $context
 * @var \yii\web\View $this
 * @var \understeam\calendar\CalendarItemInterface|CalendarPhotoItemInterface $item
 * @var \understeam\calendar\CalendarGridCell $cell
 */
use understeam\calendar\CalendarPhotoItemInterface;

?>
<div class="calendar-month-day">
    <div class="panel panel-default">
        <div class="panel-heading calendar-day-heading">
            <?= $cell->date->format('d') ?>
        </div>
        <div class="panel-body calendar-day-body">
            <?php foreach ($cell->items as $item): ?>
                <div>
                    <?php if ($item instanceof CalendarPhotoItemInterface): ?>
                        <?= \yii\helpers\Html::a('image', $item->getImageUrl(), ['target' => '_blank', 'data-pjax' => 0]) ?>
                    <?php else: ?>
                        <i class="glyphicon glyphicon-question-sign"></i>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>