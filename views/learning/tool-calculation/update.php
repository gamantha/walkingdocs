<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\learning\ToolCalculation */

$this->title = Yii::t('app', 'Update Tool Calculation: {name}', [
    'name' => $model->id,
]);
$this->title = Yii::t('app', 'Tool Calculations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tool'), 'url' => ['learning/tool']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-calculation-update">

    <h1><?= Html::encode($this->title) ?></h1>
</hr>
<div class="" style="color:#999;">
        <strong>Math Function Examples : </strong>

        <br>
        sqrt(16) = 4
        <br>
        abs(-5) = 5
        <br>
        max(4,2) = 4
        <br>
        min(4,2) = 2
        <br/>
        pow(4,2) = 16
        <br>
        fmod(19,10) = 9
    </div><hr/>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
