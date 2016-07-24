<?php
/**
 * @var array $grid
 * @var \understeam\calendar\CalendarWidget $context
 * @var \yii\web\View $this
 */
use understeam\calendar\CalendarHelper;

echo $this->render('header');
$context = $this->context;
?>
<div class="row">
    <div class="calendar-week-day"></div>
    <?php foreach ($grid as $column => $day): ?>
        <?php $time = reset($day); ?>
        <div class="calendar-week-day text-center">
            <?= Yii::$app->formatter->asDate($time->date->getTimestamp(), 'E') ?>
            <?php
            $count = CalendarHelper::getWeekColumnCount($grid, $column);
            ?>
            <?php if ($count > 0): ?>
                <b>(<?= $count ?>)</b>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<div class="row">
    <div class="calendar-week-day">
        <?php
        $day = reset($grid);
        ?>
        <?php foreach ($day as $cell): ?>
            <div class="panel panel-default">
                <div class="panel-body text-center calendar-week-body">
                    <?=$cell->date->format('H:i') ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php foreach ($grid as $day): ?>
        <div class="calendar-week-day">
            <?php foreach ($day as $cell): ?>
                <?= $this->render($context->weekCellView, ['cell' => $cell]) ?>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

