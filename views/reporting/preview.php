<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\reporting\Report */

//$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reports'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="report-view">

    <?php
echo "<p>";
    echo Html::a(Yii::t('app', 'Print PDF'), ['pdf', 'id' => $model->id], ['class' => 'btn btn-success']);
echo '</p>';
    echo GridView::widget([
        'dataProvider' => $dataProvider,
    ]);




    ?>


</div>
