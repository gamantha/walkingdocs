<?php

use app\models\reporting\ReportTemplate;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\reporting\Report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'report_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author_name')->textInput(['maxlength' => true]) ?>


    <?php

    $countries=ReportTemplate::find()->all();

    //use yii\helpers\ArrayHelper;
    $listData=ArrayHelper::map($countries,'id','template_name');


    echo $form->field($model, 'report_template_id')->dropDownList(
        $listData,
        ['prompt'=>'Select...']
    );

    echo $form->field($model, 'report_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Enter report date ...'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);

    ?>

    <?= $form->field($model, 'report_period')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
