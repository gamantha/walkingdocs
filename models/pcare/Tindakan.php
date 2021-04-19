<?php

namespace app\models\pcare;

use app\models\Consid;
use Yii;
use yii\base\BaseObject;
use yii\httpclient\Client;

/**
 * This is the model class for table "tindakan".
 *
 * @property int $id
 * @property int|null $visitId
 * @property string|null $kdTindakanSK
 * @property string|null $kdTindakan
 * @property int|null $biaya
 * @property string|null $keterangan
 * @property string|null $hasil
 *
 * @property PcareVisit $visit
 */
class Tindakan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tindakan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visitId', 'biaya'], 'integer'],
            [['keterangan'], 'string'],
            [['kdTindakanSK', 'kdTindakan', 'hasil'], 'string', 'max' => 255],
            [['visitId'], 'exist', 'skipOnError' => true, 'targetClass' => PcareVisit::className(), 'targetAttribute' => ['visitId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'visitId' => Yii::t('app', 'Visit ID'),
            'kdTindakanSK' => Yii::t('app', 'Kd Tindakan Sk'),
            'kdTindakan' => Yii::t('app', 'Kd Tindakan'),
            'biaya' => Yii::t('app', 'Biaya'),
            'keterangan' => Yii::t('app', 'Keterangan'),
            'hasil' => Yii::t('app', 'Hasil'),
        ];
    }

    /**
     * Gets query for [[Visit]].
     *
     * @return \yii\db\ActiveQuery|PcareVisitQuery
     */
    public function getVisit()
    {
        return $this->hasOne(PcareVisit::className(), ['id' => 'visitId']);
    }

    /**
     * {@inheritdoc}
     * @return TindakanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TindakanQuery(get_called_class());
    }

    public function setConsId($consId)
    {
        $this->cons_id = $consId;
    }

    public function getUsercreds($consId)
    {
        $usercreds = [];
        $bpjs_user = Consid::find()->andWhere(['cons_id' => $consId])->One();
        $usercreds['username'] = $bpjs_user->username;
        $usercreds['password'] = $bpjs_user->password;
        $usercreds['kdaplikasi'] = $bpjs_user->kdaplikasi;
        $usercreds['secretkey'] = $bpjs_user->secretkey;
        $usercreds['cons_id'] = $bpjs_user->cons_id;
        $auth_string = $bpjs_user->username . ':' . $bpjs_user->password . ':' . $bpjs_user->kdaplikasi;
        $usercreds['encoded_auth_string'] = 'Basic ' . base64_encode($auth_string);
        date_default_timezone_set('UTC');
        $usercreds['time'] = time();
        $message =  $bpjs_user->cons_id . '&' . $usercreds['time'];
        $sig = hash_hmac('sha256', $message, $bpjs_user->secretkey);

        $return = '';
        foreach(str_split($sig, 2) as $pair){
            $return .= chr(hexdec($pair));
        }

        $usercreds['encoded_sig'] = base64_encode($return);

        return $usercreds;
    }

    public function getReferensiTindakan($kdTkp)
    {
        $bpjs_user = self::getUsercreds($this->visit->pendaftaran->cons_id);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/tindakan/kdTkp/'.$kdTkp.'/0/999']);
            $request = $client->createRequest()
//                ->setContent($payload)->setMethod('POST')
                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

            $response = $request->send();
            return $response->content;
        } catch (\yii\base\Exception $exception) {

            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
        }
    }


    public function addTindakan($tindakanId)
    {
        $bpjs_user = self::getUsercreds($this->visit->pendaftaran->cons_id);
        $model = Tindakan::findOne($tindakanId);
        $payload = '{
        "kdTindakanSK": "0",
        "noKunjungan": "'.$model->visit->noKunjungan . '",
        "kdTindakan": "'.$model->kdTindakan.'",
        "biaya": "'.$model->biaya.'",
        "keterangan":"'.$model->keterangan.'",
        "hasil": "'.$model->hasil.'"
      }';

        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/tindakan']);
            $request = $client->createRequest()
                ->setContent($payload)->setMethod('POST')
                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

            $regsiterresponse = $request->send();
            return $registerresp =  $regsiterresponse->content;
        } catch (\yii\base\Exception $exception) {
            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
        }

//        $jsonresp = json_decode($registerresp);
    }
}
