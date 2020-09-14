<?php
/* @var $this yii\web\View */

?>


<?php
/**
- Number users
- Number of users by profession (Medical student, Resident, Attending, PA, Nurse, other)
- Number of users added per week
- Average time per user on WD app per day (total/checklist section / quiz section / tools)
- Most popular checklists (1-20)
- Average “Star” rating for app– number of ratings
- Average “Star” rating for checklists– number of ratings
- Average “Star” rating for quiz– number of ratings
- Average “Star” rating for tools– number of ratings
- % Thumbs Up for Checklists – total # ratings
- % Thumbs Up for images – total # ratings
- % Thumbs Up for background – total # ratings
- % Thumbs Up for comprehensive – total # ratings
- Comments listed in app but also categorized and displayed in Metrics/Dashboard
**/
use \fruppel\googlecharts\GoogleCharts;
use kartik\grid\GridView;
echo '<h3># of Users : '.sizeof($users['Users']).'</h3><hr/>';
echo '<h3># of Users by profession: </h3>';
echo '<table>';
foreach ($occupation_array as $occupation_key => $occupation_value) {
    echo '<tr><td>';
    echo $occupation_key . '</td> <td>' . sizeof($occupation_value);
    echo '</td></tr>';
}
echo '</table>';
//echo '<pre>';
//print_r($occupation_array);
//echo '</pre>';
echo '<h3># of Users added per week : ' . htmlspecialchars('<UNDER CONSTRUCTION>') . '</h3><hr/>';
echo '<h3>Average time per user on WD app per day : '. htmlspecialchars('<UNDER CONSTRUCTION>') .'<UNDER CONSTRUCTION></h3><hr/>';
echo '<h3>Most Popular checklist</h3>';

use app\models\learning\Like;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn', // <-- here
            // you may configure additional properties here
        ],
            [
                'attribute' => 'name',
                'format' => 'text'
            ],
'count',
    ],
]);

echo '<hr/><h3>Average "Star" rating for app-number of ratings : '. $average_rating .'</h3><hr/>';

echo '<h3>% Thumbs Up for Checklists – total # ratings : ' . $checklist_rating .'</h3><hr/>';

echo '<h3>Comments listed in app but also categorized and displayed in Metrics/Dashboard</h3><hr/>';


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
$gridColumns = [
//[
//    'class'=>'kartik\grid\SerialColumn',
//    'contentOptions'=>['class'=>'kartik-sheet-style'],
//    'width'=>'36px',
//    'pageSummary'=>'Total',
//    'pageSummaryOptions' => ['colspan' => 6],
//    'header'=>'',
//    'headerOptions'=>['class'=>'kartik-sheet-style']
//],
    [
        'attribute' => 'rating',
        'width' => '310px',
//        'value' => function ($model, $key, $index, $widget) {
//            return $model->supplier->company_name;
//        },
//        'filterType' => GridView::FILTER_SELECT2,
//        'filter' => ArrayHelper::map(Suppliers::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],

        'group' => true,  // enable grouping
    ],
//'rating',
    [
        'attribute' => 'userId',
        'width' => '250px',
//        'value' => function ($model, $key, $index, $widget) {
//            return $model->category->category_name;
//        },
//        'filterType' => GridView::FILTER_SELECT2,
//        'filter' => ArrayHelper::map(Categories::find()->orderBy('category_name')->asArray()->all(), 'id', 'category_name'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Any category'],
        'group' => true,  // enable grouping
        'subGroupOf' => 0 // supplier column index is the parent group
    ],
//    'userId',
    'comment'
];



echo GridView::widget([
    'id' => 'kv-grid-demo',
    'dataProvider' => $ratingsprovider,
//    'filterModel' => $searchModel,
    'columns' => $gridColumns, // check the configuration for grid columns by clicking button above
    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'pjax' => true, // pjax is set to always true for this demo
    // set your toolbar
    'toolbar' =>  [
        [
            'content' =>
                Html::button('<i class="fas fa-plus"></i>', [
                    'class' => 'btn btn-success',
                    'title' => Yii::t('kvgrid', 'Add Book'),
                    'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");'
                ]) . ' '.
                Html::a('<i class="fas fa-redo"></i>', ['grid-demo'], [
                    'class' => 'btn btn-outline-secondary',
                    'title'=>Yii::t('kvgrid', 'Reset Grid'),
                    'data-pjax' => 0,
                ]),
            'options' => ['class' => 'btn-group mr-2']
        ],
        '{export}',
        '{toggleData}',
    ],
    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
    // set export properties
    'export' => [
        'fontAwesome' => true
    ],
    // parameters from the demo form
//    'bordered' => $bordered,
//    'striped' => $striped,
//    'condensed' => $condensed,
//    'responsive' => $responsive,
//    'hover' => $hover,
//    'showPageSummary' => $pageSummary,
//    'panel' => [
//        'type' => GridView::TYPE_PRIMARY,
//        'heading' => $heading,
//    ],
//    'persistResize' => false,
//    'toggleDataOptions' => ['minCount' => 10],
//    'exportConfig' => $exportConfig,
//    'itemLabelSingle' => 'book',
//    'itemLabelPlural' => 'books'
]);
?>

</body>