<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareVisit */

$this->title = Yii::t('app', 'Create Pcare Visit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcare Visits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pcare-visit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
