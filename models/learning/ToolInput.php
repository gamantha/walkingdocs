<?php

namespace app\models\learning;

use Yii;

/**
 * This is the model class for table "tool_input".
 *
 * @property int $id
 * @property int $tool_id
 * @property string $input_name
 * @property string $input_type
 *
 * @property Tool $tool
 */
class ToolInput extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tool_input';
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
            [['input_name', 'input_type'], 'string', 'max' => 255],
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
            'input_name' => Yii::t('app', 'Input Name'),
            'input_type' => Yii::t('app', 'Input Type'),
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
     * @return ToolInputQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ToolInputQuery(get_called_class());
    }
}
