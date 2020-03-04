<?php

use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\helpers\Html;
use yii\web\View;
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



$this->registerCss(".container { width: 100%; }");
$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '36px',
        'pageSummary' => 'Total',
        'pageSummaryOptions' => ['colspan' => 6],
      //  'header' => 'Training <br> Score',
       // 'headerOptions' => ['class' => 'kartik-sheet-style']
    ],
    [
      //  'attribute' => 'category',
        'width' => '310px',
        'value' => function ($model, $key, $index, $widget) {
            return $model->indicator->category;
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
        'label' => 'Indikator',
        'header' => false,
        'value' => function($model) {
            return $model->indicator->indicator_name;
        }

    ],
    [
         'label' => 'ICD10',
        'header' => false,
        'value' => function($model) {
            return $model->indicator->icd10;
        }

    ],
    [
        'class' => 'kartik\grid\EditableColumn',
       // 'refreshGrid' => true,
        'attribute' => 'n_m_0d7d',
        'header' => 'L',
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
        'attribute' => 'n_f_0d7d',
        'header' => 'P',
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
        'attribute' => 'o_m_0d7d',
        'header' => 'L',
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
        'attribute' => 'o_f_0d7d',
        'header' => 'P',
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

//8d28d

    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'n_m_8d28d',
        'header' => 'L',
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
        'attribute' => 'n_f_8d28d',
        'header' => 'P',
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
        'attribute' => 'o_m_8d28d',
        'header' => 'L',
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
        'attribute' => 'o_f_8d28d',
        'header' => 'P',
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

    //1m11m

    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'n_m_1m11m',
        'header' => 'L',
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
        'attribute' => 'n_f_1m11m',
        'header' => 'P',
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
        'attribute' => 'o_m_1m11m',
        'header' => 'L',
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
        'attribute' => 'o_f_1m11m',
        'header' => 'P',
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

    //1y4y

    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'n_m_1y4y',
        'header' => 'L',
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
        'attribute' => 'n_f_1y4y',
        'header' => 'P',
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
        'attribute' => 'o_m_1y4y',
        'header' => 'L',
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
        'attribute' => 'o_f_1y4y',
        'header' => 'P',
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

    //5y9y


    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'n_m_5y9y',
        'header' => 'L',
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
        'attribute' => 'n_f_5y9y',
        'header' => 'P',
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
        'attribute' => 'o_m_5y9y',
        'header' => 'L',
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
        'attribute' => 'o_f_5y9y',
        'header' => 'P',
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

    //10y14y

    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'n_m_10y14y',
        'header' => 'L',
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
        'attribute' => 'n_f_10y14y',
        'header' => 'P',
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
        'attribute' => 'o_m_10y14y',
        'header' => 'L',
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
        'attribute' => 'o_f_10y14y',
        'header' => 'P',
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

    //15y19y
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'n_m_15y19y',
        'header' => 'L',
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
        'attribute' => 'n_f_15y19y',
        'header' => 'P',
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
        'attribute' => 'o_m_15y19y',
        'header' => 'L',
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
        'attribute' => 'o_f_15y19y',
        'header' => 'P',
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

//20y44y
[
    'class' => 'kartik\grid\EditableColumn',
    'attribute' => 'n_m_20y44y',
    'header' => 'L',
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
        'attribute' => 'n_f_20y44y',
        'header' => 'P',
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
        'attribute' => 'o_m_20y44y',
        'header' => 'L',
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
        'attribute' => 'o_f_20y44y',
        'header' => 'P',
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
//45y59y
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'n_m_45y59y',
        'header' => 'L',
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
        'attribute' => 'n_f_45y59y',
        'header' => 'P',
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
        'attribute' => 'o_m_45y59y',
        'header' => 'L',
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
        'attribute' => 'o_f_45y59y',
        'header' => 'P',
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
//60y
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'n_m_60y',
        'header' => 'L',
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
        'attribute' => 'n_f_60y',
        'header' => 'P',
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
        'attribute' => 'o_m_60y',
        'header' => 'L',
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
        'attribute' => 'o_f_60y',
        'header' => 'P',
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
        'class' => 'kartik\grid\FormulaColumn',
        'header' => 'Buy + Sell<br>(BS)',
        'vAlign' => 'middle',
        'value' => function ($model, $key, $index, $widget) {
            $p = compact('model', 'key', 'index');
            return $widget->col(7, $p) + $widget->col(9, $p);
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'hAlign' => 'right',
        'width' => '7%',
       // 'format' => ['decimal', 2],
        'mergeHeader' => true,
        'pageSummary' => true,
        'footer' => true
    ],
    [
        'header' => 'KB L',
        'value' => function($data) {
    $array = \app\models\reporting\Lb1Data::find()->andWhere(['id' => $data->id])->asArray()->One();
    $sum = 0;

            $array_keys = array_keys($array);
            foreach ($array_keys as $array_key) {
                if (strpos($array_key,'n_m_') !== false) {
                    $sum = $sum + $array[$array_key];
                }
            }
    return $sum;
        }
    ],
    [
        'header' => 'KB P',
        'value' => function($data) {
            $array = \app\models\reporting\Lb1Data::find()->andWhere(['id' => $data->id])->asArray()->One();
            $sum = 0;

            $array_keys = array_keys($array);
            foreach ($array_keys as $array_key) {
                if (strpos($array_key,'n_f_') !== false) {
                    $sum = $sum + $array[$array_key];
                }
            }
            return $sum;
        }
    ],
    [
        'header' => 'KL L',
        'value' => function($data) {
            $array = \app\models\reporting\Lb1Data::find()->andWhere(['id' => $data->id])->asArray()->One();
            $sum = 0;

            $array_keys = array_keys($array);
            foreach ($array_keys as $array_key) {
                if (strpos($array_key,'o_m_') !== false) {
                    $sum = $sum + $array[$array_key];
                }
            }
            return $sum;
        }
    ],
    [
        'header' => 'KL P',
        'value' => function($data) {
            $array = \app\models\reporting\Lb1Data::find()->andWhere(['id' => $data->id])->asArray()->One();
            $sum = 0;

            $array_keys = array_keys($array);
            foreach ($array_keys as $array_key) {
                if (strpos($array_key,'o_f_') !== false) {
                    $sum = $sum + $array[$array_key];
                }
            }
            return $sum;
        }
    ]
];
?>

<div class="report-form">
    <?php Pjax::begin(['id' => 'lb1-grid']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'beforeHeader'=>[
            [
                'columns'=>[
                  //  ['content'=>'Indikator', 'options'=>['colspan'=>2, 'rowspan' => 3, 'class'=>'text-center warning']],
                    ['content'=>'', 'options'=>['colspan'=>3, 'rowspan' => 2, 'class'=>'text-center warning']],
                    ['content'=>'0-7 hari', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'8-28 hari', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'1-11 bln', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'1-4 thn', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'5-9 thn', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'10-14 thn', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'15-19 thn', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'20-44 thn', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'45-59 thn', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'>59 thn', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                    ['content'=>'>Jumlah', 'options'=>['colspan'=>4, 'class'=>'text-center warning']],
                ],
                'options'=>['class'=>'skip-export'] // remove this row from export
            ],
            [
                'columns'=>[
                    ['content'=>'KB', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KL', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KB', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KL', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KB', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KL', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KB', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KL', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KB', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KL', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KB', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KL', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KB', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KL', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KB', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KL', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KB', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KL', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KB', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KL', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KB', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                    ['content'=>'KL', 'options'=>['colspan'=>2, 'class'=>'text-center warning']],
                ],
                'options'=>['class'=>'skip-export'] // remove this row from export
            ]
        ],
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
            'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'beforeGrid'=>'My fancy content before.',
        'afterGrid'=>'My fancy content after.',
    ],
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

    <?php


    $js=<<<js
$.pjax.reload({container: '#lb1-grid', async: false});
js;
    $this->registerJs($js);



    ?>

</div>
