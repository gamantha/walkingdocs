<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\learning\ToolOutput */

$this->title = Yii::t('app', 'Update Tool Output: {name}', [
    'name' => $model->id,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tool'), 'url' => ['learning/tool']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-output-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
