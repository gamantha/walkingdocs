<?php


namespace app\models\reporting;
use Yii;
use yii\base\Model;


class Bpjstemplate extends Model
{
    public $reportId;
    public $indicatorName;
    public $indicatorId;
    public $m_0d7d;
    public $f_0d7d;
    public $m_8d28d;
    public $f_8d28d;
    public $m_1m1y;
    public $f_1m1y;
    public $m_1y4y;
    public $f_1y4y;
    public $m_5y9y;
    public $f_5y9y;

    public $m_10y14y;
    public $f_10y14y;
    public $m_15y19y;
    public $f_15y19y;
    public $m_20y44y;
    public $f_20y44y;
    public $m_45y54y;
    public $f_45y54y;
    public $m_55y59y;
    public $f_55y59y;
    public $m_60y69y;
    public $f_60y69y;
    public $m_70y;
    public $f_70y;


    public function init() {
        $this->m_0d7d = 0;
        $this->f_0d7d = 0;
        $this->m_8d28d = 0;
        $this->f_8d28d = 0;
        $this->m_1m1y = 0;
        $this->f_1m1y = 0;
        $this->m_1y4y = 0;
        $this->f_1y4y = 0;
        $this->m_5y9y = 0;
        $this->f_5y9y = 0;
        $this->m_10y14y = 0;
        $this->f_10y14y = 0;
        $this->m_15y19y = 0;
        $this->f_15y19y = 0;
        $this->m_20y44y = 0;
        $this->f_20y44y = 0;
        $this->m_45y54y = 0;
        $this->f_45y54y = 0;
        $this->m_55y59y= 0;
        $this->f_55y59y = 0;
        $this->m_60y69y = 0;
        $this->f_60y69y = 0;
        $this->m_70y = 0;
        $this->f_70y = 0;
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['m_0d7d', 'f_0d7d', 'm_8d28d', 'f_8d28d', 'm_1m1y', 'f_1m1y', 'm_1y4y', 'f_1y4y', 'm_5y9y', 'f_5y9y'], 'integer'],
            [['m_10y14y', 'f_10y14y', 'm_15y19y', 'f_15y19y', 'm_20y44y', 'f_20y44y', 'm_45y54y', 'f_45y54y', 'm_55y59y', 'f_55y59y', 'm_60y69y', 'f_60y69', 'm_70y', 'f_70y'], 'integer'],

            [['m_0d7d', 'f_0d7d', 'm_8d28d', 'f_8d28d', 'm_1m1y', 'f_1m1y', 'm_1y4y', 'f_1y4y', 'm_5y9y', 'f_5y9y'], 'default', 'value' => 0],
            [['m_10y14y', 'f_10y14y', 'm_15y19y', 'f_15y19y', 'm_20y44y', 'f_20y44y', 'm_45y54y', 'f_45y54y', 'm_55y59y', 'f_55y59y', 'm_60y69y', 'f_60y69', 'm_70y', 'f_70y'], 'default', 'value' => 0],

        ];
    }

    public function load($data, $formName = NULL){
//        print_r($formName);
        if (isset($data['Bpjstemplate'])) {
            $this->reportId = $data['Bpjstemplate']['reportId'];
            $this->indicatorName = $data['Bpjstemplate']['indicatorName'];
            $this->indicatorId = $data['Bpjstemplate']['indicatorId'];
            $this->m_0d7d = $data['Bpjstemplate']['m_0d7d'];
            $this->f_0d7d = $data['Bpjstemplate']['f_0d7d'];
            $this->m_8d28d = $data['Bpjstemplate']['m_8d28d'];
            $this->f_8d28d = $data['Bpjstemplate']['f_8d28d'];
            $this->m_1m1y = $data['Bpjstemplate']['m_1m1y'];
            $this->f_1m1y = $data['Bpjstemplate']['f_1m1y'];
            $this->m_1y4y = $data['Bpjstemplate']['m_1y4y'];
            $this->f_1y4y = $data['Bpjstemplate']['f_1y4y'];
            $this->m_5y9y = $data['Bpjstemplate']['m_5y9y'];
            $this->f_5y9y = $data['Bpjstemplate']['f_5y9y'];

            $this->m_10y14y = $data['Bpjstemplate']['m_10y14y'];
            $this->f_10y14y = $data['Bpjstemplate']['f_10y14y'];
            $this->m_15y19y = $data['Bpjstemplate']['m_15y19y'];
            $this->f_15y19y = $data['Bpjstemplate']['f_15y19y'];
            $this->m_20y44y = $data['Bpjstemplate']['m_20y44y'];
            $this->f_20y44y = $data['Bpjstemplate']['f_20y44y'];
            $this->m_45y54y = $data['Bpjstemplate']['m_45y54y'];
            $this->f_45y54y = $data['Bpjstemplate']['f_45y54y'];
            $this->m_55y59y = $data['Bpjstemplate']['m_55y59y'];
            $this->f_55y59y = $data['Bpjstemplate']['f_55y59y'];
            $this->m_60y69y = $data['Bpjstemplate']['m_60y69y'];
            $this->f_60y69y = $data['Bpjstemplate']['f_60y69y'];
            $this->m_70y = $data['Bpjstemplate']['m_70y'];
            $this->f_70y = $data['Bpjstemplate']['f_70y'];


//           $this->attributes = $data['Bpjstemplate'];
            //$this->setAttributes($data);
//            if ($this->save()) {
//                // handle success
//            }
            return true;
        }
        return false;
    }

    public function indicatorSave($genderage) {
        echo $this->reportId;
        $ind_name = explode("_",$genderage);
        $indicatorValue = IndicatorValues::find()
            ->andWhere(['report_id' => $this->reportId])
            ->andWhere(['indicator_name' => $this->indicatorName])
            ->andWhere(['gender' => $ind_name[0]])
            ->andWhere(['age_range' => $ind_name[1]])
            ->One();
        if (null == $indicatorValue) {
//create new
            $indicatorValue = new IndicatorValues();
            $indicatorValue->report_id = $this->reportId;
            $indicatorValue->indicator_name = $this->indicatorName;
            $indicatorValue->gender = $ind_name[0];
            $indicatorValue->age_range = $ind_name[1];
            $indicatorValue->value = $this->{$genderage};
            $indicatorValue->save();

        } else {
            $indicatorValue->value = $this->{$genderage};
            $indicatorValue->save();
//            save existing value
        }
    }
    public function save() {
        $this->indicatorSave("m_0d7d");
        $this->indicatorSave("f_0d7d");
        $this->indicatorSave("m_8d28d");
        $this->indicatorSave("f_8d28d");
        $this->indicatorSave("m_1m1y");
        $this->indicatorSave("f_1m1y");
        $this->indicatorSave("m_1y4y");
        $this->indicatorSave("f_1y4y");
        $this->indicatorSave("m_5y9y");
        $this->indicatorSave("f_5y9y");

        $this->indicatorSave("m_10y14y");
        $this->indicatorSave("f_10y14y");
        $this->indicatorSave("m_15y19y");
        $this->indicatorSave("f_15y19y");
        $this->indicatorSave("m_20y44y");
        $this->indicatorSave("f_20y44y");
        $this->indicatorSave("m_45y54y");
        $this->indicatorSave("f_45y54y");
        $this->indicatorSave("m_55y59y");
        $this->indicatorSave("f_55y59y");
        $this->indicatorSave("m_60y69y");
        $this->indicatorSave("f_60y69y");
        $this->indicatorSave("m_70y");
        $this->indicatorSave("f_70y");

        //return $this->m_0d7d;
        //return print_r($this);
        return true;
    }


}