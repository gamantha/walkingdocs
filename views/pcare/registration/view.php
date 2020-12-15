<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareRegistration */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcare Registrations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pcare-registration-view">

    <p>
        <?php

        echo Html::a(Yii::t('app', 'Registration Data'), ['pcare/registration/view', 'id' => $model->id], ['class' => 'btn btn-primary disabled']);
        echo ' ';
        echo Html::a(Yii::t('app', 'Visit Data'), ['pcare/visit/view', 'id' => $model->id], ['class' => 'btn btn-default']);


        ?>
    </p>

    <h1>Registration Data : <?= Html::encode($this->title) ?></h1>
<p>
    <?php
    echo Html::a(Yii::t('app', 'check peserta bpjs'), ['checkpeserta', 'id' => $model->id], ['class' => 'btn btn-default']);
    ?>
</p>

    <p>

        <?php
        if ($model->status != 'registered') {
            echo Html::a(Yii::t('app', 'Modify registration data'), ['update', 'id' => $model->id], ['class' => 'btn btn-warning']);
        }

        else {

            echo Html::a(Yii::t('app', 'Pcare registered'), ['register', 'id' => $model->id], ['class' => 'btn btn-default disabled']);

            if ($model->status == 'submitted') {
                echo Html::a(Yii::t('app', 'submitted'), ['pcare/visit/submit', 'id' => $model->id], ['class' => 'btn btn-default disabled']);
            }  else {
                echo Html::a(Yii::t('app', 'Submit to Pcare'), ['pcare/visit/submit', 'id' => $model->id], ['class' => 'btn btn-primary']);

            }





        }

        ?>

    </p>
    <p>
<?php
if (empty($model->kdProviderPeserta)) {
    echo Html::a(Yii::t('app', 'check bpjs peserta first'), ['register', 'id' => $model->id], ['class' => 'btn btn-default disabled']);
} else {
    echo Html::a(Yii::t('app', 'Register to Pcare'), ['register', 'id' => $model->id], ['class' => 'btn btn-success']);
}
   ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'no_urut',
            'status',
            'kdProviderPeserta',
            'tglDaftar',
            'noKartu',
            'kdPoli',
            'kunjSakit',
            'keluhan:ntext',
//            'sistole',
//            'sistole',
//            'diastole',
//            'beratBadan',
//            'tinggiBadan',
//            'respRate',
//            'heartRate',
//            'rujukBalik',
            'kdTkp',
//            'created_at',
//            'modified_at',
        ],
    ]) ?>

</div>
