<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Consid */

$this->title = Yii::t('app', 'BPJS ID: {name}', [
    'name' => $model->no_bpjs,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Consids'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->cons_id, 'url' => ['view', 'id' => $model->cons_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Cek Peserta');
?>
<div class="consid-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="consid-form">

<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'no_bpjs')->textInput(['maxlength' => true]) ?>
<?php
if ($isexist) {
    echo $this->render('_datapeserta', [
        'form' => $form,
        'model' => $model,
        'response' => $response
    ]);


} 




?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Cek'), ['class' => 'btn btn-success', 'name' => 'submit1','value' => 'cek']) ?>

    <?php
if ($isexist) {
   // echo Html::a('REGISTER', ['/bpjs/registration'], ['class'=>'btn btn-primary']);
    echo Html::submitButton(Yii::t('app', 'Register'), ['class' => 'btn btn-success', 'name' => 'submit1', 'value' => 'register']);
}

?>
</div>

<?php ActiveForm::end(); ?>

</div>


</div>
