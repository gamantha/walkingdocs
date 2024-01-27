<?php

namespace app\models\learning;

use Yii;

/**
 * This is the model class for table "tool_output".
 *
 * @property int $id
 * @property int $tool_id
 * @property string $output_name
 * @property string $output_type
 *
 * @property Tool $tool
 */
class ToolOutput extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tool_output';
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
            [['output_name', 'output_type'], 'string', 'max' => 255],
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
            'output_name' => Yii::t('app', 'Output Name'),
            'output_type' => Yii::t('app', 'Output Type'),
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
     * @return ToolOutputQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ToolOutputQuery(get_called_class());
    }
}
