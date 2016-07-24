<?php
/**
 * @var \understeam\calendar\CalendarActionForm $model
 * @var array $grid
 * @var boolean $usePjax
 * @var \yii\web\View $this
 */
\understeam\calendar\CalendarAsset::register($this);
?>
<div class="row">
    <div class="col-md-12">
        <?php if ($usePjax): ?>
            <?php $pjax = \yii\widgets\Pjax::begin([
                'id' => 'calendar-pjax',
            ]); ?>
        <?php endif; ?>
        <?= \understeam\calendar\CalendarWidget::widget([
            'grid' => $model->getGrid(),
            'viewMode' => $model->viewMode,
            'period' => $model->getPeriod(),
        ]) ?>
        <?php if ($usePjax): ?>
            <?php \yii\widgets\Pjax::end(); ?>
        <?php endif; ?>
    </div>
</div>