<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Consid */

$this->title = Yii::t('app', 'Create Consid');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Consids'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consid-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
