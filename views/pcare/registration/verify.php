<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pcare\PcareRegistration */

$this->title = Yii::t('app', 'Verify BPJS Status', [
//    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcare Registrations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Verify');
?>
<div class="pcare-registration-update">

    <div class="pcare-registration-form">

        <?php $form = ActiveForm::begin(); ?>

    <h1><?= Html::encode($this->title) ?></h1>
<div <?= $nikflag?"hidden" : ""?> class="form-group">
    <label class="control-label">No Kartu</label>
        <?= Html::input('text', 'noKartu', $noKartu, ['class' => 'form-control']) ?>
</div>
        <div <?= $nikflag?"" : "hidden"?> class="form-group">
            <label class="control-label">NIK</label>
        <?= Html::input('text', 'nik', $nik, ['class' => 'form-control']) ?>
        </div>



        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Verify'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<div class="well">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//                'noKartu','nik',
//        'ketAktif',
        [
                'label' => 'STATUS',
            'format' => 'raw',
            'value' => function($data){
        $textcolor = 'white';
        $backgroundcolor = 'white';

        $ketaktif = '';

        if (isset($data['ketAktif'])) {
            $ketaktif = $data['ketAktif'];
        }
        if (isset($data['aktif'])) {


            if ($data['aktif']) {
                $backgroundcolor = 'green';
            } else {
                $backgroundcolor = 'red';
            }
        }

        $returnedtext = '<span style="color: '.$textcolor.'; background-color: '.$backgroundcolor.';"><strong>' .$ketaktif. '</strong></span>';
        return $returnedtext;
//        return json_encode($data);
            }
        ],
            'noKartu',
        'noKTP',
'nama','hubunganKeluarga',
            'tglLahir',
            //'sex',
            'golDarah',
            //'tglMulaiAktif', 'tglAkhirBerlaku',
          //      'noHP',
            //'jnsPeserta_kode',

            [
                    'label' => 'Jenis peserta',
                'value' => function($data) {
        return $data['jnsPeserta_nama'];
                }
            ],

            [
                'label' => 'Kelas',
                'value' => function($data) {
                    return $data['jnsKelas_nama'];
                }
            ],

            [
                'label' => 'Provider',
                'value' => function($data) {
                    return $data['providerPeserta_nama'];
                }
            ],

//            'jnsPeserta_nama',
            //'providerPeserta_kode',
//             'providerPeserta_nama',
            //'aktif'
        ],
    ]) ?>
</div>
