<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\learning\ToolInput */

$this->title = Yii::t('app', 'Create Tool Input');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tool'), 'url' => ['learning/tool']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-input-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
