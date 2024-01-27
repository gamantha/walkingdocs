<?php

//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\reporting\Report */

$this->title = $model->report_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);






?>
<div class="report-view">





    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'report_name',
            'report_date',
            'report_period',
            'author_name',
        ],
    ]) ?>
    <?php



    ?>
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    <?= Html::a(Yii::t('app', 'Additional Info'), ['extrainfo', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    <br/><hr/>


    <?= $this->render('_' . $model->reportTemplate->template_code, [
        'model' => $model,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
