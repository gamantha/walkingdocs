<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "peserta".
 *
 * @property string $bpjs_no
 * @property string $json_data
 * @property string $created_at
 * @property string $modified_at
 */
class Peserta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'peserta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bpjs_no'], 'required'],
            [['json_data'], 'string'],
            [['created_at', 'modified_at'], 'safe'],
            [['bpjs_no'], 'string', 'max' => 255],
            [['bpjs_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bpjs_no' => Yii::t('app', 'Bpjs No'),
            'json_data' => Yii::t('app', 'Json Data'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PesertaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PesertaQuery(get_called_class());
    }
}
