<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\reporting\Report */

$this->title = Yii::t('app', 'Update Report: {name}', [
    'name' => $report->report_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $_GET['id'], 'url' => ['view', 'id' => $_GET['id']]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="report-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_'. $report->reportTemplate->template_code.'form', [
        'model' => $model,
    ]) ?>

</div>
