<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kunjungan */

$this->title = Yii::t('app', 'Create Kunjungan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kunjungans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kunjungan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
