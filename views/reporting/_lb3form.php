<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\reporting\Report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'report_id')->hiddenInput()->label(false) ?>

<hr/>
<h3>KESEHATAN IBU DAN ANAK :   Gizi</h3>
    <?= $form->field($model, 'kia_gizi_1')->textInput()->label('Jumlah anak balita (1-5 th) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini') ?>
    <?= $form->field($model, 'kia_gizi_2')->textInput()->label('Jumlah Ibu nifas (s/d 40 hr) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini') ?>
    <?= $form->field($model, 'kia_gizi_3')->textInput()->label('Jumlah bayi (6-11 th) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini') ?>

    <hr/>
    <h3>KESEHATAN IBU DAN ANAK :   Upaya Penanggulangan Anemia Gizi Besi (Fe)</h3>
    <?= $form->field($model, 'kia_besi_1')->textInput()->label('Jumlah Ibu hamil dapat tablet tambah darah (Fe) 30 tablet (Fe1) bulan ini') ?>
    <?= $form->field($model, 'kia_besi_2')->textInput()->label('Jumlah Ibu hamil dapat tablet tambah darah (Fe) 90 tablet (Fe2) bulan ini') ?>
    <?= $form->field($model, 'kia_besi_3')->textInput()->label('Jumlah Balita diperiksa status anemia bulan ini') ?>
    <?= $form->field($model, 'kia_besi_4')->textInput()->label('Jumlah Balita yang diperiksa dengan status anemia < 11 gr % bulan ini') ?>
    <?= $form->field($model, 'kia_besi_5')->textInput()->label('Jumlah WUS (15 - 45 th) diperiksa status anemia bulan ini') ?>
    <?= $form->field($model, 'kia_besi_6')->textInput()->label('Jumlah WUS (15 - 45 th) yang diperiksa dengan status anemia < 11 gr % bulan ini') ?>
    <?= $form->field($model, 'kia_besi_7')->textInput()->label('Jumlah Remaja Putri (14 - 18 th) diperiksa status anemia bulan ini') ?>
    <?= $form->field($model, 'kia_besi_8')->textInput()->label('Jumlah Remaja Putri (14 - 18 th) yang diperiksa dengan status anemia < 11 gr % bulan ini') ?>
    <?= $form->field($model, 'kia_besi_9')->textInput()->label('Jumlah Tenaga Kerja Wanita (nakerwan) diperiksa status anemia bulan ini') ?>
    <?= $form->field($model, 'kia_besi_10')->textInput()->label('Jumlah Tenaga Kerja Wanita (nakerwan) yang diperiksa dengan status anemia < 11 gr % bulan ini') ?>
    <?= $form->field($model, 'kia_besi_11')->textInput()->label('Jumlah Ibu hamil diperiksa status anemia bulan ini') ?>
    <?= $form->field($model, 'kia_besi_12')->textInput()->label('Jumlah Ibu hamil yang diperiksa dengan status anemia < 11 gr % bulan ini') ?>
<hr/>
    <h3>KESEHATAN IBU DAN ANAK :   Upaya Pemantauan Pertumbuhan Balita</h3>
    <?= $form->field($model, 'kia_balita_1')->textInput()->label('Jumlah Balita yang ada bulan ini') ?>
    <?= $form->field($model, 'kia_balita_2')->textInput()->label('Jumlah Balita yang mempunyai KMS bulan ini') ?>
    <?= $form->field($model, 'kia_balita_3')->textInput()->label('Jumlah Balita yang Naik berat badannya bulan ini') ?>
    <?= $form->field($model, 'kia_balita_4')->textInput()->label('Jumlah Balita yang Tidak naik/tetap berat badannya bulan ini') ?>
    <?= $form->field($model, 'kia_balita_5')->textInput()->label('Jumlah Balita yang ditimbang bulan ini tetapi tidak ditimbang bulan lalu') ?>
    <?= $form->field($model, 'kia_balita_6')->textInput()->label('Jumlah Balita yang Baru ditimbang bulan ini') ?>
    <?= $form->field($model, 'kia_balita_7')->textInput()->label('Jumlah Balita yang dapat ditimbang bulan ini') ?>
    <?= $form->field($model, 'kia_balita_8')->textInput()->label('Jumlah Balita yang tidak dapat ditimbang bulan ini') ?>
    <?= $form->field($model, 'kia_balita_9')->textInput()->label('jumlah Balita dengan Berat badan di Bawah Garis Merah (BGM) bulan ini') ?>
    <?= $form->field($model, 'kia_balita_10')->textInput()->label('Jumlah Balita gizi buruk bulan ini') ?>
<hr/>
    <h3>KESEHATAN IBU DAN ANAK :   Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)</h3>
    <?= $form->field($model, 'kia_gaky_1')->textInput()->label('Jumlah penderita GAKY laki-laki bulan ini') ?>
    <?= $form->field($model, 'kia_gaky_2')->textInput()->label('Jumlah penderita GAKY perempuan bulan ini') ?>
    <?= $form->field($model, 'kia_gaky_3')->textInput()->label('Jumlah ibu hamil mendapat kapsul yodium') ?>
    <?= $form->field($model, 'kia_gaky_4')->textInput()->label('Jumlah penduduk lainnya mendapat kapsul yodium') ?>
<hr/>
    <h3>KESEHATAN IBU DAN ANAK :   Upaya Penanggulangan Kekurangan Energi Kronis (KEK)</h3>
    <?= $form->field($model, 'kia_kek_1')->textInput()->label('Jumlah Ibu hamil baru, diukur LILA (Lingkar Lengan Atas) bulan ini') ?>
    <?= $form->field($model, 'kia_kek_2')->textInput()->label('Jumlah Ibu hamil baru, dengan LILA < 23,5 cm bulan ini') ?>
    <?= $form->field($model, 'kia_kek_3')->textInput()->label('Jumlah WUS baru, yang diukur LILA (Lingkar Lengan Atas) bulan in') ?>
    <?= $form->field($model, 'kia_kek_4')->textInput()->label('Jumlah WUS baru, dengan LILA < 23,5 cm bulan ini') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
