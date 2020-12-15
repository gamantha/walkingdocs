<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareVisit */

$this->title = "Visit Data : " . $model->pendaftaranId;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcare Registrations'), 'url' => ['pcare/registration/index']];
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kunjungan'), 'url' => ['pcare/registration/index']];
$this->params['breadcrumbs'][] = ['label' => $model->pendaftaranId, 'url' => ['pcare/registration/view', 'id' => $model->pendaftaranId]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pcare-visit-view">
    <p>
        <?php

        echo Html::a(Yii::t('app', 'Registration Data'), ['pcare/registration/view', 'id' => $model->pendaftaranId], ['class' => 'btn btn-default']);
        echo ' ';
        echo Html::a(Yii::t('app', 'Visit Data'), ['pcare/visit/view', 'id' => $model->pendaftaranId], ['class' => 'btn btn-primary disabled']);

        ?>
    </p>
    <h1><?= Html::encode($this->title) ?></h1>
<p>
    <?php

    echo Html::a(Yii::t('app', 'check peserta bpjs'), ['pcare/registration/checkpeserta', 'id' => $model->pendaftaranId], ['class' => 'btn btn-default']);
    ?>
</p>

    <p>

        <?php
        if ($model->status == 'submitted') {

        }  else {
            echo Html::a(Yii::t('app', 'Modify visit data'), ['update', 'id' => $model->pendaftaranId], ['class' => 'btn btn-warning']);

        }
echo '<p>';
        if (empty($model->pendaftaran->kdProviderPeserta)) {
            echo Html::a(Yii::t('app', 'check bpjs peserta first'), ['pcare/visit/submit', 'id' => $model->id], ['class' => 'btn btn-default disabled']);
        } else {

            if ($model->pendaftaran->status != 'registered') {
                echo Html::a(Yii::t('app', 'Register to Pcare'), ['pcare/registration/register', 'id' => $model->pendaftaranId], ['class' => 'btn btn-success']);
            }  else {


                echo Html::a(Yii::t('app', 'Pcare registered'), ['pcare/registration/register', 'id' => $model->id], ['class' => 'btn btn-default disabled']);

                if ($model->status == 'submitted') {
                    echo Html::a(Yii::t('app', 'submitted'), ['submit', 'id' => $model->id], ['class' => 'btn btn-default disabled']);
                }  else {
                    echo Html::a(Yii::t('app', 'Submit to Pcare'), ['pcare/visit/submit', 'id' => $model->id], ['class' => 'btn btn-primary']);

                }
            }





        }


        echo '</p>';

        ?>
        <?php
        if ($model->status == null) {
            echo Html::a(Yii::t('app', 'submit data to pcare'), ['pcare/visit/submit', 'id' => $model->id], ['class' => 'btn btn-primary']);
        }  else {

        }


        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'pendaftaranId',
            'status',
//            'noKunjungan',
            'kdSadar',
            'terapi:ntext',
            'kdStatusPulang',
            'tglPulang',
            'kdDokter',
            'kdDiag1',
            'kdDiag2',
            'kdDiag3',
            'kdPoliRujukInternal',
            'tglEstRujuk',
            'kdppk',
            'subSpesialis_kdSubSpesialis1',
            'subSpesialis_kdSarana',
            'khusus_kdKhusus',
            'khusus_kdSubSpesialis',
            'khusus_catatan:ntext',
            'kdTacc',
            'alasanTacc:ntext',
//            'json:ntext',

//            'created_at',
//            'modified_at',
        ],
    ]) ?>

</div>
