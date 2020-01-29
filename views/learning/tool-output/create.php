<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\learning\ToolOutput */

$this->title = Yii::t('app', 'Create Tool Output');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tool'), 'url' => ['learning/tool']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-output-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
