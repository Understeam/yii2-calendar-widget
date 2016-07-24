<?php
/**
 * @var array $grid
 * @var \understeam\calendar\CalendarWidget $context
 * @var \yii\web\View $this
 */
use understeam\calendar\CalendarHelper;

echo $this->render('header');
$context = $this->context;
$firstWeek = reset($grid);
?>
<div class="row calendar-month">
    <?php foreach ($firstWeek as $column => $day): ?>
        <div class="calendar-month-day text-center">
            <?= Yii::$app->formatter->asDate($day->date->getTimestamp(), 'E') ?>
            <?php
            $count = CalendarHelper::getMonthColumnCount($grid, $column);
            ?>
            <?php if ($count > 0): ?>
                <b>(<?= $count ?>)</b>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php foreach ($grid as $week): ?>
    <div class="row">
        <?php foreach ($week as $cell): ?>
            <?= $this->render($context->monthCellView, ['cell' => $cell]) ?>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
