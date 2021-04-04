<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;

use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Consid */

$this->title = Yii::t('app', 'Create Schedule');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Schedule'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consid-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="consid-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'clinicId')->textInput(['maxlength' => true, 'readonly' => true]) ?>


        <?php

        echo $form->field($model, 'dayofweek')->dropDownList(
            ['1' => 'Minggu', '2' => 'Senin', '3' => 'Selasa', '4' => 'Rabu','5' => 'Kamis', '6'=>'Jumat', '7' => 'Sabtu']
        );


        echo '<label class="control-label">Start Time</label>';
        echo TimePicker::widget(['model' => $model, 'attribute' => 'starttime',
            'pluginOptions' => [
                'showSeconds' => false,
                'showMeridian' => false,
            ]

            ]);

        echo '<label class="control-label">End Time</label>';
        echo TimePicker::widget(['model' => $model, 'attribute' => 'endtime',
            'pluginOptions' => [
                'showSeconds' => false,
                'showMeridian' => false,
            ]
            ]);


        echo $form->field($model, 'status')->dropDownList(
            ['active' => 'Aktif', 'inaktif' => 'Non-aktif']
        );
        ?>



        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
