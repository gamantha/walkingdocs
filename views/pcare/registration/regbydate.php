<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\pcare\PcareRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pcare Registrations by date');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcare Registrations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pcare-registration-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);

    $form = ActiveForm::begin();
    echo '<label class="control-label">Tanggal </label>';
    echo DatePicker::widget([
//        'model' => $model,
    'value' => $date,
        'name' => 'tanggal',
        //'language' => 'ru',
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy'
        ]
//        'dateFormat' => 'yyyy-MM-dd',
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Get registration data'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

////            'id',
            'tgldaftar',
            'noUrut',
//            'kdProviderPeserta',
//
        [
                'label' => 'No Kartu',
                'value' => function($data) {
     return $data->peserta->noKartu;
                }

        ],
            [
                'label' => 'Nama',
                'value' => function($data) {
                    return $data->peserta->nama;
                }

            ],
            [
                'label' => 'Nama Poli',
                'value' => function($data) {
                    return $data->poli->nmPoli;
                }

            ],
            [
                'label' => 'tkp',
                'value' => function($data) {
                    return $data->tkp->nmTkp;
                }

            ],
//            'noKartu',
//            'kdPoli',
//            //'kunjSakit',
            'keluhan:ntext',
            'sistole',
            'diastole',
            'beratBadan',
            'tinggiBadan',
            'respRate',
            'heartRate',
//            //'rujukBalik',
//            //'kdTkp',
//            //'created_at',
//            //'modified_at',
//            'status',
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template' => '{view}',
//                'buttons' => [
//                    'download' => function ($url) {
//                        return Html::a(
//                            '<span class="glyphicon glyphicon-arrow-down"></span>',
//                            $url,
//                            [
//                                'title' => 'Download',
//                                'data-pjax' => '0',
//                            ]
//                        );
//                    },
//                ],
//            ],
//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
