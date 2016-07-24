<?php
/**
 * @var \understeam\calendar\CalendarWidget $context
 * @var \yii\web\View $this
 * @var \understeam\calendar\CalendarItemInterface|CalendarPhotoItemInterface $item
 * @var \understeam\calendar\CalendarGridCell $cell
 */
use understeam\calendar\CalendarPhotoItemInterface;

?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body calendar-week-body">
                <?php foreach ($cell->items as $item): ?>
                    <div>
                        <?php if ($item instanceof CalendarPhotoItemInterface): ?>
                            <?= \yii\helpers\Html::a('view', $item->getImageUrl(), ['target' => '_blank', 'data-pjax' => 0]) ?>
                        <?php else: ?>
                            <i class="glyphicon glyphicon-question-sign"></i>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
