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
        'label' => 'disease',
        'value' => function($model) {
            return $model->indicator->indicator_name;
        }

    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'm_0d7d',

        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'f_0d7d',

        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'm_8d28d',

        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'f_8d28d',

        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'm_1m1y',

        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'f_1m1y',

        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'm_1y4y',

        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'f_1y4y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'm_5y9y',

        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'f_5y9y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'm_10y14y',

        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'f_10y14y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'm_15y19y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'f_15y19y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'm_20y44y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'f_20y44y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'm_45y54y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'f_45y54y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'm_55y59y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'f_55y59y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'm_60y69y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'f_60y69y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'm_70y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'f_70y',
        'editableOptions' => [
            'header' => '',
            'formOptions'=>['action' => ['/reporting/editdata']], // point to the new action
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'pluginOptions' => ['min' => 0, 'max' => 5000]
            ]
        ],
        'hAlign' => 'right',
        'vAlign' => 'middle',
        'width' => '1%',
        'format' => ['decimal', 0],
        'pageSummary' => true
    ]
];



?>

<div class="report-form">



    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'toolbar' =>  [
            '{export}',
            // '{toggleData}',
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        // set export properties
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
            'heading' => "<i class=\"fas fa-book\"></i>  Laporan Bulanan 1",
        ],
    ]); ?>
    <?php Pjax::end(); ?>



</div>
