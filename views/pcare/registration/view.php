<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareRegistration */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcare Registrations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pcare-registration-view">
    <h1>Registration : <?= Html::encode($this->title) ?></h1>
    <hr/>
    <p>
<h3>Process tracker</h3>
        <?php

        $statusoptions2 = ['ready'];
        $statusoptions3 = ['ready', 'not ready'];

        if (in_array($model->status, $statusoptions2)) {
            echo Html::a(Yii::t('app', 'Register to Pcare'), ['pcare/registration/register', 'id' => $model->id], ['class' => 'btn btn-primary']);
        } else {
            echo Html::button(Yii::t('app', 'Registered to Pcare'),['class' => 'btn btn-success', 'disabled' => 'true']);
        }

        if ($model->status == 'registered') {
            echo ' <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> ';
            echo Html::a(Yii::t('app', 'Submit to Pcare'), ['pcare/visit/submit', 'id' => $model->id], ['class' => 'btn btn-default']);
        } else if (in_array($model->status, $statusoptions3)) {
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
        <li role="presentation" class="active"><a href="<?php
            echo Url::toRoute(['pcare/registration/view', 'id' => $model->id]);
            ?>">Registration Data</a></li>
        <li role="presentation" class=""><a href="<?php
            echo Url::toRoute(['pcare/visit/view', 'id' => $model->id]);
            ?>">Visit Data</a></li>

    </ul>


        <?php
//
//        echo Html::a(Yii::t('app', 'Registration Data'), ['pcare/registration/view', 'id' => $model->id], ['class' => 'btn btn-primary disabled']);
//        echo ' ';
//        echo Html::a(Yii::t('app', 'Visit Data'), ['pcare/visit/view', 'id' => $model->id], ['class' => 'btn btn-default']);


        ?>
    </p>


<p>
    <?php
//    echo Html::a(Yii::t('app', 'check peserta bpjs'), ['checkpeserta', 'id' => $model->id], ['class' => 'btn btn-default']);
    ?>
</p>

    <p>

        <?php

        $modifyregistrationstatuses = ['registered', 'submitted'];
        if (in_array($model->status, $modifyregistrationstatuses)) {
//        echo Html::a(Yii::t('app', 'Modify registration data'), ['update', 'id' => $model->id], ['class' => 'btn btn-warning']);
        } else {
            echo Html::a(Yii::t('app', 'Modify registration data'), ['update', 'id' => $model->id], ['class' => 'btn btn-warning']);
        }


        ?>

    </p>
    <p>
<?php
//if (empty($model->kdProviderPeserta)) {
//    echo Html::a(Yii::t('app', 'check bpjs peserta first'), ['register', 'id' => $model->id], ['class' => 'btn btn-default disabled']);
//} else {
//    echo Html::a(Yii::t('app', 'Register to Pcare'), ['register', 'id' => $model->id], ['class' => 'btn btn-success']);
//}
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
