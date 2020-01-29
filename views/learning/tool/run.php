<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use FormulaParser\FormulaParser;
/* @var $this yii\web\View */
/* @var $model app\models\learning\Tool */
/* @var $form yii\widgets\ActiveForm */


$this->title = Yii::t('app', 'Run');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tool'), 'url' => ['learning/tool']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="tool-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php



    foreach($inputs as $input) {
        //echo $form->field($input, 'input_name')->textInput(['maxlength' => true]);
        echo $input->input_name . " : " . Html::textInput($input->input_name, $inputVals[$input->input_name], []) . ' ' . $input->input_type;
        //echo $input->input_name;
        echo '<br/>';
    }


    foreach($outputs as $output) {
        echo '<hr/><h1>';
        echo $output->output_name  . ' = ' . $model->toolCalculations[0]->formula;
        echo '</h1><hr/>';

        echo $output->output_name . " : " . Html::textInput($result, $result, ['readonly' => true]) . ' ' . $output->output_type;

        echo '<br/>';
    }
    ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Run'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
