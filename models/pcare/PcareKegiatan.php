<?php

namespace app\models\pcare;

use Yii;

/**
 * This is the model class for table "pcare_kegiatan".
 *
 * @property int $id
 * @property int|null $consId
 * @property string|null $eduId
 * @property string|null $clubId
 * @property string|null $tglPelayanan
 * @property string|null $kdKegiatan
 * @property string|null $kdKelompok
 * @property string|null $materi
 * @property string|null $pembicara
 * @property string|null $lokasi
 * @property string|null $keterangan
 * @property int|null $biaya
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $modified_at
 */
class PcareKegiatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pcare_kegiatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['consId', 'biaya'], 'integer'],
            [['tglPelayanan', 'created_at', 'modified_at'], 'safe'],
            [['materi', 'keterangan'], 'string'],
            [['eduId', 'clubId', 'kdKegiatan', 'kdKelompok', 'pembicara', 'lokasi', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'consId' => Yii::t('app', 'Cons ID'),
            'eduId' => Yii::t('app', 'Edu ID'),
            'clubId' => Yii::t('app', 'Club ID'),
            'tglPelayanan' => Yii::t('app', 'Tgl Pelayanan'),
            'kdKegiatan' => Yii::t('app', 'Kd Kegiatan'),
            'kdKelompok' => Yii::t('app', 'Kd Kelompok'),
            'materi' => Yii::t('app', 'Materi'),
            'pembicara' => Yii::t('app', 'Pembicara'),
            'lokasi' => Yii::t('app', 'Lokasi'),
            'keterangan' => Yii::t('app', 'Keterangan'),
            'biaya' => Yii::t('app', 'Biaya'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PcareKegiatanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PcareKegiatanQuery(get_called_class());
    }
}
