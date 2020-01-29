<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Kunjungan;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PendaftaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pendaftarans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pendaftaran-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Pendaftaran'), ['/bpjs/cekpeserta'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'id',
            'no_bpjs',
            'nama',
            'status_peserta',
            //'jenis_peserta',
            'bpjs_pendaftaran_status',
            //'bpjs_pendaftaran_status',
            'bpjs_pendaftaran_nourut',
            [
                'label' => 'bpjs kunjungan status',
                'value' => function ($model){
                    $res = Kunjungan::find()->andWhere(['pendaftaran_id' => $model->id])->One();
                    if (isset($res))
                        return $res->bpjs_kunjungan_status;
                        else 
                        return 'No record';
                }
            ],
            
            [
                'label' => 'bpjs kunjungan no kunjungan',
                'value' => function ($model){
                    $res = Kunjungan::find()->andWhere(['pendaftaran_id' => $model->id])->One();
                    if (isset($res))
                    return $res->bpjs_kunjungan_no;
                    else 
                    return 'No record';

                }
            ],
            
            //'tanggal_lahir',
            //'kelamin',
            //'ppk_umum',
            //'no_handphone',
            //'no_rekam_medis',
            //'created_at',
            //'modified_at',
            [
                'label' => 'Kunjungan',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Kunjungan', ['bpjs/kunjungan', 'id' => $model->id], ['class' => 'profile-link']);
            
                }
            ],

            [
                'label' => 'Delete kunjungan BPJS',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Delete Kunjungan', ['bpjs/delkunjungan', 'id' => $model->id], ['class' => 'profile-link']);
            
                }
            ],

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
