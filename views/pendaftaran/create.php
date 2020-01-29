<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pendaftaran */

$this->title = Yii::t('app', 'Create Pendaftaran');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pendaftarans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pendaftaran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
