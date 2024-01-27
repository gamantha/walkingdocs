<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsidSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Integration Check');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consid-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'wd_id',                                           // title attribute (in plain text)
            'cons_id'
        ],
    ]);


    ?>


    <?php Pjax::end(); ?>

</div>
