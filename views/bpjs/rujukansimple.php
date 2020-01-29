<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Bpjs;
use app\models\Icd10;
use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\bootstrap\Modal;
use yii\web\JsExpression;

use kartik\widgets\TypeaheadBasic;

/* @var $this yii\web\View */
/* @var $model app\models\Kunjungan */

//$this->title = $kunjunganModel->pendaftaran_id;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pendaftaran / Kunjungan'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);




?>



<div class="kunjungan-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php


    echo '<h2>Pulang / Rujuk</h2>';

    echo $form->field($rujukanModel, 'kunjungan_id')->textInput(['readonly' => true, 'id' => 'kunjungan-id']);
    echo $form->field($rujukanModel, 'tanggal_estimasi')->widget(DatePicker::classname(),[
        'options' => ['placeholder' => 'Select time ...','id' => 'rujukandate-id'],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'yyyy-M-d',
            //'startDate' => '01-Mar-2019 12:00 AM',
            'todayHighlight' => true
        ]

    ]);






    ?>
    <div id="4-modal" style="display: inline;">
        <?php

        $radio_ary = [
            'spesialis' => 'Spesialis',
            'khusus' => 'Kondisi Khusus'
        ];
        ?>

            <?php
            //echo Html::radioList('rujukanmodelradio ', null,$radio_ary );

            echo $form->field($rujukanModel, 'tipe_rujukan')->dropDownList(
                ['spesialis' => 'Spesialis', 'khusus' => 'Khusus'],
                ['prompt' => 'Select...']
            );
            ?>


        <div id="#spesialis">
            <?php

            echo $form->field($rujukanModel, 'kdSpesialis')->textInput();
            echo $form->field($rujukanModel, 'kdSubSpesialis1')->textInput();
            echo $form->field($rujukanModel, 'kdSarana')->textInput();
            echo $form->field($rujukanModel, 'kdppk')->textInput();



            ?>
        </div>
        <div id="#khusus">
            <h2>KHUSUS DIBAWAH INI</h2>
            <?php

            ?>
        </div>


    </div>




    <div class="form-group">

        <?= Html::submitButton(Yii::t('app', 'Save & Return'), ['class' => 'btn btn-success', 'name' => 'submit1','value' => 'save']) ?>

    </div>


    <?php ActiveForm::end(); ?>

</div>


