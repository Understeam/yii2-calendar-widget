<?php
/**
 * @var boolean $usePjax
 * @var array $widgetOptions
 * @var \yii\web\View $this
 */
\understeam\calendar\AssetBundle::register($this);
?>
<div class="row">
    <div class="col-md-12">
        <?php if ($usePjax): ?>
            <?php $pjax = \yii\widgets\Pjax::begin([
                'id' => 'calendar-pjax',
            ]); ?>
        <?php endif; ?>
        <?= \understeam\calendar\CalendarWidget::widget($widgetOptions) ?>
        <?php if ($usePjax): ?>
            <?php \yii\widgets\Pjax::end(); ?>
        <?php endif; ?>
    </div>
</div>