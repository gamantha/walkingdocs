<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareVisit */

$this->title = "Registration : " . $model->pendaftaranId;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcare Registrations'), 'url' => ['pcare/registration/index']];
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kunjungan'), 'url' => ['pcare/registration/index']];
$this->params['breadcrumbs'][] = ['label' => $model->pendaftaranId, 'url' => ['pcare/registration/view', 'id' => $model->pendaftaranId]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pcare-visit-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    <p>
    <h3>Process tracker</h3>
    <?php

    $statusoptions2 = ['ready'];
    $statusoptions3 = ['ready', 'not ready'];

    if (in_array($model->pendaftaran->status, $statusoptions2)) {
        echo Html::a(Yii::t('app', 'Register to Pcare'), ['pcare/registration/register', 'id' => $model->pendaftaran->id], ['class' => 'btn btn-primary']);
    } else {
        echo Html::button(Yii::t('app', 'Registered to Pcare'),['class' => 'btn btn-success', 'disabled' => 'true']);
    }

    if ($model->pendaftaran->status == 'registered') {
        echo ' <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> ';
        echo Html::a(Yii::t('app', 'Submit to Pcare'), ['pcare/visit/submit', 'id' => $model->pendaftaran->id], ['class' => 'btn btn-default']);
    } else if (in_array($model->pendaftaran->status, $statusoptions3)) {
        echo ' <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> ';
        echo Html::button(Yii::t('app', 'finish registration first'),['class' => 'btn btn-danger', 'disabled' => 'true']);

    } else {
        echo ' <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> ';

        echo Html::button(Yii::t('app', 'Data Submitted'),['class' => 'btn btn-success', 'disabled' => 'true']);
    }

    ?>

    </p>
    <hr/>

    <p>
    <ul class="nav nav-tabs">
        <li role="presentation" class=""><a href="<?php
            echo Url::toRoute(['pcare/registration/view', 'id' => $model->pendaftaranId]);
            ?>">Registration Data</a></li>
        <li role="presentation" class="active"><a href="<?php
            echo Url::toRoute(['pcare/visit/view', 'id' => $model->pendaftaranId]);
            ?>">Visit Data</a></li>

    </ul>
</p>
<p>
    <?php

//    echo Html::a(Yii::t('app', 'check peserta bpjs'), ['pcare/registration/checkpeserta', 'id' => $model->pendaftaranId], ['class' => 'btn btn-default']);
    ?>
</p>

    <p>

        <?php
        if ($model->status == 'submitted') {

        }  else {
            echo Html::a(Yii::t('app', 'Modify visit data'), ['update', 'id' => $model->pendaftaranId], ['class' => 'btn btn-warning']);

        }
echo '<p>';
//        if (empty($model->pendaftaran->kdProviderPeserta)) {
//            echo Html::a(Yii::t('app', 'check bpjs peserta first'), ['pcare/visit/submit', 'id' => $model->id], ['class' => 'btn btn-default disabled']);
//        } else {
//
//            if ($model->pendaftaran->status != 'registered') {
//                echo Html::a(Yii::t('app', 'Register to Pcare'), ['pcare/registration/register', 'id' => $model->pendaftaranId], ['class' => 'btn btn-success']);
//            }  else {
//
//
//                echo Html::a(Yii::t('app', 'Pcare registered'), ['pcare/registration/register', 'id' => $model->id], ['class' => 'btn btn-default disabled']);
//
//                if ($model->status == 'submitted') {
//                    echo Html::a(Yii::t('app', 'submitted'), ['submit', 'id' => $model->id], ['class' => 'btn btn-default disabled']);
//                }  else {
//                    echo Html::a(Yii::t('app', 'Submit to Pcare'), ['pcare/visit/submit', 'id' => $model->id], ['class' => 'btn btn-primary']);
//
//                }
//            }
//
//
//
//
//
//        }


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
//            'pendaftaranId',
//            'status',
            'noKunjungan',
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
