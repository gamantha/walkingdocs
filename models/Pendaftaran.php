<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pendaftaran".
 *
 * @property int $id
 * @property string $tanggal_daftar
 * @property string $kode_provider
 * @property string $kdPoli
 * @property string $no_bpjs
 * @property string $nama
 * @property string $status_peserta
 * @property string $jenis_peserta
 * @property string $tanggal_lahir
 * @property string $kelamin
 * @property string $ppk_umum
 * @property string $no_handphone
 * @property string $no_rekam_medis
 * @property string $bpjs_pendaftaran_response
 * @property string $bpjs_pendaftaran_status
 * @property string $bpjs_pendaftaran_nourut
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 *
 * @property Kunjungan[] $kunjungans
 */
class Pendaftaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_daftar', 'created_at', 'modified_at'], 'safe'],
            [['bpjs_pendaftaran_response'], 'string'],
            [['kode_provider', 'kdPoli', 'no_bpjs', 'nama', 'status_peserta', 'jenis_peserta', 'tanggal_lahir', 'kelamin', 'ppk_umum', 'no_handphone', 'no_rekam_medis', 'bpjs_pendaftaran_status', 'bpjs_pendaftaran_nourut', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tanggal_daftar' => Yii::t('app', 'Tanggal Daftar'),
            'kode_provider' => Yii::t('app', 'Kode Provider'),
            'kdPoli' => Yii::t('app', 'Kd Poli'),
            'no_bpjs' => Yii::t('app', 'No Bpjs'),
            'nama' => Yii::t('app', 'Nama'),
            'status_peserta' => Yii::t('app', 'Status Peserta'),
            'jenis_peserta' => Yii::t('app', 'Jenis Peserta'),
            'tanggal_lahir' => Yii::t('app', 'Tanggal Lahir'),
            'kelamin' => Yii::t('app', 'Kelamin'),
            'ppk_umum' => Yii::t('app', 'Ppk Umum'),
            'no_handphone' => Yii::t('app', 'No Handphone'),
            'no_rekam_medis' => Yii::t('app', 'No Rekam Medis'),
            'bpjs_pendaftaran_response' => Yii::t('app', 'Bpjs Pendaftaran Response'),
            'bpjs_pendaftaran_status' => Yii::t('app', 'Bpjs Pendaftaran Status'),
            'bpjs_pendaftaran_nourut' => Yii::t('app', 'Bpjs Pendaftaran Nourut'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKunjungans()
    {
        return $this->hasMany(Kunjungan::className(), ['pendaftaran_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PendaftaranQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PendaftaranQuery(get_called_class());
    }

    public function loadpost($data)
    {

        //belum jalan
        $this->nama = $data->nama;
        $this->jenis_peserta = $data->jenis_peserta;



    }
}
