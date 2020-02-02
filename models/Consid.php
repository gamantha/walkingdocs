<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consid".
 *
 * @property string $wd_id
 * @property string $cons_id
 * @property string $username
 * @property string $password
 * @property string $secretkey
 * @property string $kdaplikasi
 */
class Consid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wd_id'], 'required'],
            [['wd_id', 'cons_id', 'username', 'password', 'secretkey', 'kdaplikasi'], 'string', 'max' => 255],
            [['wd_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'wd_id' => Yii::t('app', 'Wd ID'),
            'cons_id' => Yii::t('app', 'Cons ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'secretkey' => Yii::t('app', 'Secretkey'),
            'kdaplikasi' => Yii::t('app', 'Kdaplikasi'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ConsidQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConsidQuery(get_called_class());
    }
}
