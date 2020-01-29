<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\learning\Tool */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tool-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Enable'), ['enable', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Disable'), ['disable', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'status',
            'background:ntext',
        ],
    ]) ?>
    <h1><?= Html::encode("Inputs") ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Add'), ['learning/tool-input/create', 'toolId'=>$model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $inputDataProvider,
        'filterModel' => $inputSearchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

        //    'id',
         //   'tool_id',
            'input_name',
            'input_type',

            //['class' => 'yii\grid\ActionColumn'],



            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{learning/tool-input/update} {learning/tool-input/delete}',
                'buttons' => [
                    'learning/tool-input/update' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            $url,
                            [
                                'title' => 'Update',
                                'data-pjax' => '0',

                            ]
                        );
                    },

                    'learning/tool-input/delete' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            $url,
                            [
                                'title' => 'Delete',
                                'data-pjax' => '0',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                ],
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>




    <h1><?= Html::encode("Outputs") ?></h1>
    <p>


        <?php

        $outputs = $outputDataProvider->getModels();

        if (!sizeof($outputs) == 0) {
       echo '';
        } else {
            echo Html::a(Yii::t('app', 'Add'), ['learning/tool-output/create', 'toolId'=>$model->id], ['class' => 'btn btn-primary']);
        }
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $outputDataProvider,
        'filterModel' => $outputSearchModel,
        'columns' => [
         //   ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'tool_id',
            'output_name',
            'output_type',

            //['class' => 'yii\grid\ActionColumn'],



            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{learning/tool-output/update} {learning/tool-output/delete}',
                'buttons' => [
                    'learning/tool-output/update' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            $url,
                            [
                                'title' => 'Update',
                                'data-pjax' => '0',

                            ]
                        );
                    },

                    'learning/tool-output/delete' => function ($url) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            $url,
                            [
                                'title' => 'Delete',
                                'data-pjax' => '0',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                ],
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <h1><?= Html::encode("Calculation") ?></h1>
    <p>
        <?php
            if (isset($toolCalculation->tool_id)) {
                echo Html::a(Yii::t('app', 'Update'), ['learning/tool-calculation/update', 'toolId'=>$toolCalculation->id], ['class' => 'btn btn-primary']);
            } else {
                echo Html::a(Yii::t('app', 'Add'), ['learning/tool-calculation/create', 'toolId'=>$model->id], ['class' => 'btn btn-primary']);
            }


        ?>

    </p>
    <?= DetailView::widget([
        'model' => $toolCalculation,
        'attributes' => [
            //'id',
            'formula',
            //'background:ntext',
        ],
    ]) ?>
</div>
