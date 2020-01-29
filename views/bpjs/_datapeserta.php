<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>



<?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
<?= $form->field($model, 'sex')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
<?= $form->field($model, 'tanggal_lahir')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
<?= $form->field($model, 'tanggal_mulai_aktif')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
<?= $form->field($model, 'tanggal_akhir_berlaku')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
<?= $form->field($model, 'aktif')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
<?= $form->field($model, 'nohp')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
<?= $form->field($model, 'noktp')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
<?= $form->field($model, 'gol_darah')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
<?= $form->field($model, 'tunggakan')->textInput(['maxlength' => true, 'readonly'=>true]) ?>

<?= $form->field($model, 'jenisKelasNama')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
<?= $form->field($model, 'jenisPesertaNama')->textInput(['maxlength' => true, 'readonly'=>true]) ?>

<?php
echo '<div class="well"><pre>';
print_r($response);

echo '</pre></div>';
?>
