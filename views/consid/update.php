<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Consid */

$this->title = Yii::t('app', 'Update Consid: {name}', [
    'name' => $model->wd_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Consids'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->wd_id, 'url' => ['view', 'id' => $model->wd_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="consid-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
