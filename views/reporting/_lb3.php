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
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\reporting\Report */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'pageSummary' => 'Total',
        'pageSummaryOptions' => ['colspan' => 6],
        'header' => '',
        'headerOptions' => ['class' => 'kartik-sheet-style']
    ],
    [
        'attribute' => 'indicator_id',
        'width' => '310px',
        'value' => function ($model, $key, $index, $widget) {
            return $model->indicator->indicator_category;
        },
        'filterType' => GridView::FILTER_SELECT2,
       // 'filter' => ArrayHelper::map(Suppliers::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'),
//        'filterWidgetOptions' => [
//            'pluginOptions' => ['allowClear' => true],
//        ],
       // 'filterInputOptions' => ['placeholder' => 'Any supplier'],
        'group' => true,  // enable grouping,
        'groupedRow' => true,                    // move grouped column to a single grouped row
        'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
        'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
    ],

    [
        'label' => 'Indicator',
        'value' => function($model) {
            return $model->indicator->display_text;
        }

    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'value',

        'editableOptions' => [
                'name' => function($model,$key,$index) {
            return $key;
        },
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editlb3data']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_TEXT,
            'containerOptions' => [
                'id' => 'sasa',
                // popover content harusnya key bukan index
                ],
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],];



?>
<div class="report-form">



    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'toolbar' =>  [
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export' => [
            'fontAwesome' => true
        ],
        'condensed' =>true,
       'columns' => $gridColumns,
        'exportConfig' => [
            GridView::EXCEL => [
            ],

        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => "<i class=\"fas fa-book\"></i>Kesehatan Ibu dan Anak : Gizi",
        ],
    ]); ?>

    <?php Pjax::end(); ?>



</div>
