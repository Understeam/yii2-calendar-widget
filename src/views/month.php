<?php
/**
 * @var array $grid
 * @var \understeam\calendar\CalendarWidget $context
 * @var \yii\web\View $this
 */
use understeam\calendar\CalendarHelper;

$context = $this->context;
echo $this->render($context->headerView);

$firstWeek = reset($grid);
?>
<div class="row">
    <div class="calendar-month-header-cell"></div>
    <?php foreach ($firstWeek as $column => $day): ?>
        <div class="calendar-month-header-cell">
            <?= Yii::$app->formatter->asDate($day->date->getTimestamp(), 'E') ?>
            <?php
            $count = CalendarHelper::getRowItemsCount($grid, $column);
            ?>
            <?php if ($count > 0): ?>
                <span class="badge"><?= $count ?></span>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php foreach ($grid as $week): ?>
    <div class="row">
        <div class="calendar-month-cell">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php
                    $weekStr = reset($week)->date->format('W');
                    ?>
                    <?=$weekStr ?>
                    <?php
                    $count = CalendarHelper::getColumnItemsCount($grid, $weekStr);
                    ?>
                    <?php if ($count > 0): ?>
                        <span class="badge"><?= $count ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php foreach ($week as $cell): ?>
            <?= $this->render($context->monthCellView, ['cell' => $cell]) ?>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
