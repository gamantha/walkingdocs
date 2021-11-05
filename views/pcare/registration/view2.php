<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareRegistration */

$this->title = 'Pilihan';
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcare Registrations'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pcare-registration-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    <p>
<!--<h3>Pcare Bridging</h3>-->
        <?php
//echo '<pre>';
//print_r($payload);
//echo '</pre>';



        https://localhost/walkingdocs/web/index.php/pcare/registration/updatekunjungan?consid=4566&noKartu=0001240629862&date=29-10-2021&kdPoli=003

//        echo Html::a(Yii::t('app', 'Edit'), ['pcare/visit/submit', 'id' => $model->id], ['class' => 'btn btn-default']);
        echo Html::a(Yii::t('app', 'Edit'), ['pcare/registration/updatekunjungan', 'consid' => $clinicmodel->cons_id,'noKartu' => $payload->noKartu, 'date' => $payload->tglDaftar,'kdPoli' => $payload->kdPoli], ['class' => 'btn btn-default']);
echo '<br/>';
        if ($isrujukan) {
            echo Html::a(Yii::t('app', 'Print Rujukan'), ['pcare/registration/printrujukan', 'consid' => $clinicmodel->cons_id,'noKartu' => $payload->noKartu, 'date' => $payload->tglDaftar,'kdPoli' => $payload->kdPoli], ['class' => 'btn btn-default']);

        } else {

        }


        ?>

    </p>
<hr/>

    <p>


        <?php
//
//        echo Html::a(Yii::t('app', 'Registration Data'), ['pcare/registration/view', 'id' => $model->id], ['class' => 'btn btn-primary disabled']);
//        echo ' ';
//        echo Html::a(Yii::t('app', 'Visit Data'), ['pcare/visit/view', 'id' => $model->id], ['class' => 'btn btn-default']);


        ?>
    </p>


<p>

</p>

    <p>

        <?php

        $modifyregistrationstatuses = ['registered', 'submitted'];
//        if (in_array($model->status, $modifyregistrationstatuses)) {
////        echo Html::a(Yii::t('app', 'Modify registration data'), ['update', 'id' => $model->id], ['class' => 'btn btn-warning']);
//        } else {
////            echo Html::a(Yii::t('app', 'Modify registration data'), ['update', 'id' => $model->id], ['class' => 'btn btn-warning']);
//        }


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
</div>
