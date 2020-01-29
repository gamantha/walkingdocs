<?php

namespace app\models\learning;

use Yii;

/**
 * This is the model class for table "tool_calculation".
 *
 * @property int $id
 * @property int $tool_id
 * @property string $formula
 *
 * @property Tool $tool
 */
class ToolCalculation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tool_calculation';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('wdlearningdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tool_id'], 'integer'],
            [['formula'], 'string'],
            [['tool_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tool::className(), 'targetAttribute' => ['tool_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tool_id' => Yii::t('app', 'Tool ID'),
            'formula' => Yii::t('app', 'Formula'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTool()
    {
        return $this->hasOne(Tool::className(), ['id' => 'tool_id']);
    }

    /**
     * {@inheritdoc}
     * @return ToolCalculationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ToolCalculationQuery(get_called_class());
    }
}
