<?php

namespace app\models\learning;

use Yii;

/**
 * This is the model class for table "tool".
 *
 * @property int $id
 * @property string $name
 * @property string $background
 * @property string $image
 * @property string $status
 *
 * @property ToolCalculation[] $toolCalculations
 * @property ToolInput[] $toolInputs
 * @property ToolOutput[] $toolOutputs
 */
class Tool extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tool';
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
            [['background'], 'string'],
            [['name', 'image', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'background' => Yii::t('app', 'Background'),
            'image' => Yii::t('app', 'Image'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToolCalculations()
    {
        return $this->hasMany(ToolCalculation::className(), ['tool_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToolInputs()
    {
        return $this->hasMany(ToolInput::className(), ['tool_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToolOutputs()
    {
        return $this->hasMany(ToolOutput::className(), ['tool_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ToolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ToolQuery(get_called_class());
    }
}
