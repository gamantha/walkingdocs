<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\Antrean */

$this->title = Yii::t('app', 'Create Antrean');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Antreans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="antrean-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
