<?php

use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
//use yii\grid\GridView;
use app\models\reporting\Lb1;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $model app\models\reporting\Report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php



    $colorPluginOptions =  [
        'showPalette' => true,
        'showPaletteOnly' => true,
        'showSelectionPalette' => true,
        'showAlpha' => false,
        'allowEmpty' => false,
        'preferredFormat' => 'name',
        'palette' => [
            [
                "white", "black", "grey", "silver", "gold", "brown",
            ],
            [
                "red", "orange", "yellow", "indigo", "maroon", "pink"
            ],
            [
                "blue", "green", "violet", "cyan", "magenta", "purple",
            ],
        ]
    ];












    $data = new Lb1();


    $dataarray[0] = $data->toArray();
    $data2 = [

        ['id' => 1, 'name' => 'name 1'],
        ['id' => 2, 'name' => 'name 2'],
    ];


    $dataProvider = new ArrayDataProvider([
        'allModels' => $dataarray,
        'pagination' => [
            'pageSize' => 10,
        ],
        'sort' => [
            //'attributes' => ['id', 'name'],
        ],
    ]);

//        $query =new Query();
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query->from('indicator_'),
//            'pagination' => [
//                'pageSize' => 10,
//            ],
//            'sort' => [
//                'defaultOrder' => [
//                    'created_at' => SORT_DESC,
//                    'title' => SORT_ASC,
//                ]
//            ],
//        ]);

//    echo GridView::widget([
//        'dataProvider' => $dataProvider,
//    ]);
    echo GridView::widget([
        'dataProvider'=> $dataProvider,
        //'filterModel' => $searchModel,
        //'columns' => $gridColumns,
        'columns' => [],
        'responsive'=>true,
        'hover'=>true,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true, // pjax is set to always true for this demo
    ]);


    echo Editable::widget([
        'model'=>$data,
        'attribute' => 'reportId',
        'type'=>'primary',
        'size'=>'lg',
        'inputType'=>Editable::INPUT_TEXT,
        'editableValueOptions'=>['class'=>'text-success h3']
    ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
