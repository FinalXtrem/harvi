<?php

/* @var $this yii\web\View */
/* @var $sort string */
/* @var $asc string */

use yii\helpers\Html;

$url = Yii::$app->controller->getRoute();

$this->title = 'Statistic LB01 - Algorithm and Programming';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-stat">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Refresh', [$url, 'refresh' => 1], ['class' => 'btn btn-primary']); ?>
    <?php \yii\widgets\Pjax::begin(); ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th><?= Html::a('NIM', [$url, 'sort' => 'nim', 'order' => ('nim' == $sort && $order == 'asc' ? 'desc' : null)], ['class' => $sort == 'nim' ? ($order != 'asc' ? 'desc' : 'asc') : false]) ?></th>
            <th><?= Html::a('Name', [$url, 'sort' => 'name', 'order' => ('name' == $sort && $order == 'asc' ? 'desc' : null)], ['class' => $sort == 'name' ? ($order != 'asc' ? 'desc' : 'asc') : false]) ?></th>
            <th><?= Html::a('Username', [$url, 'sort' => 'username', 'order' => ('username' == $sort && $order == 'asc' ? 'desc' : null)], ['class' => $sort == 'username' ? ($order != 'asc' ? 'desc' : 'asc') : false]) ?></th>
            <?php foreach ($verdicts as $key => $val) { ?>
                <th><?= Html::a($key, [$url, 'sort' => $key, 'order' => ($key == $sort && $order == 'asc' ? 'desc' : null)], ['class' => $sort == $key ? ($order != 'asc' ? 'desc' : 'asc') : false, 'title' => $val]) ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $i => $val) { ?>
            <tr>
                <td><?= $i + 1; ?></td>
                <td><?= $val['nim']; ?></td>
                <td><?= ucwords(strtolower($val['name'])); ?></td>
                <td><a target="_blank"
                       href="https://jollybeeoj.com/user/view/<?= strtolower($val['username']); ?>"><?= strtolower($val['username']); ?></a>
                </td>
                <?php foreach ($verdicts as $key => $val2) { ?>
                    <td><?= isset($val[$key]) ? $val[$key] : 0; ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
