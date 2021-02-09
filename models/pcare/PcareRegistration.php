<?php

namespace app\models\pcare;

use app\models\Consid;
use Yii;
use yii\httpclient\Client;

/**
 * This is the model class for table "pcare_registration".
 *
 * @property int $id
 * @property int|null $cons_id
 * @property string|null $kdProviderPeserta
 * @property string|null $tglDaftar
 * @property string|null $no_urut
 * @property string|null $noKartu
 * @property string|null $nik
 * @property string|null $noka
 * @property string|null $kdPoli
 * @property string|null $kunjSakit
 * @property string|null $keluhan
 * @property int|null $sistole
 * @property int|null $diastole
 * @property int|null $beratBadan
 * @property int|null $tinggiBadan
 * @property int|null $respRate
 * @property int|null $heartRate
 * @property int|null $rujukBalik
 * @property string|null $kdTkp
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $modified_at
 *
 * @property PcareVisit[] $pcareVisits
 */
class PcareRegistration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pcare_registration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cons_id', 'sistole', 'diastole', 'beratBadan', 'tinggiBadan', 'respRate', 'heartRate', 'rujukBalik'], 'integer'],
            [['tglDaftar', 'created_at', 'modified_at'], 'safe'],
            [['kdTkp'], 'required'],
            [['keluhan'], 'string'],
            [['kdProviderPeserta', 'no_urut', 'noKartu', 'nik', 'noka', 'kdPoli', 'kunjSakit', 'kdTkp', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cons_id' => Yii::t('app', 'Cons ID'),
            'kdProviderPeserta' => Yii::t('app', 'Kd Provider Peserta'),
            'tglDaftar' => Yii::t('app', 'Tgl Daftar'),
            'no_urut' => Yii::t('app', 'No Urut'),
            'noKartu' => Yii::t('app', 'No Kartu'),
            'nik' => Yii::t('app', 'Nik'),
            'noka' => Yii::t('app', 'Noka'),
            'kdPoli' => Yii::t('app', 'Kd Poli'),
            'kunjSakit' => Yii::t('app', 'Kunj Sakit'),
            'keluhan' => Yii::t('app', 'Keluhan'),
            'sistole' => Yii::t('app', 'Sistole'),
            'diastole' => Yii::t('app', 'Diastole'),
            'beratBadan' => Yii::t('app', 'Berat Badan'),
            'tinggiBadan' => Yii::t('app', 'Tinggi Badan'),
            'respRate' => Yii::t('app', 'Resp Rate'),
            'heartRate' => Yii::t('app', 'Heart Rate'),
            'rujukBalik' => Yii::t('app', 'Rujuk Balik'),
            'kdTkp' => Yii::t('app', 'Kd Tkp'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * Gets query for [[PcareVisits]].
     *
     * @return \yii\db\ActiveQuery|PcareVisitQuery
     */
    public function getPcareVisits()
    {
        return $this->hasMany(PcareVisit::className(), ['pendaftaranId' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PcareRegistrationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PcareRegistrationQuery(get_called_class());
    }

    public function getKdProviderPeserta($nokartu)
    {
        try {
            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/peserta/' . $nokartu]);
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

    public function Cekpeserta()
    {
        $bpjs_user = self::getUsercreds($this->cons_id);

        if (!empty($this->noKartu)) {
            try {

                $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/peserta/' . $this->noKartu]);
                $request = $client->createRequest()
//                ->setContent($payload)->setMethod('POST')
                    ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                    ->addHeaders(['content-type' => 'application/json'])
                    ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                    ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                    ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

                $response = $request->send();
//                return '1';
                return $response->content;
            } catch (\yii\base\Exception $exception) {

                Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
            }
        } else if (!empty($this->nik)){
            try {

                $client2 = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/peserta/nik/' . $this->nik]);
                $request2 = $client2->createRequest()
//                ->setContent($payload)->setMethod('POST')
                    ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                    ->addHeaders(['content-type' => 'application/json'])
                    ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                    ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                    ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

                $response2 = $request2->send();
//                return '2';
                return $response2->content;
            } catch (\yii\base\Exception $exception) {

                Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
            }

        } else {

            try {

                $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/peserta/' . $this->noKartu]);
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






    }



    public function Register($id)
    {
        $bpjs_user = self::getUsercreds($this->cons_id);

        $registrationModel = PcareRegistration::findOne($id);
        echo '<pre>';



        $payload = '{
        "kdProviderPeserta": "'.$registrationModel->kdProviderPeserta.'",
        "tglDaftar": "'.date("d-m-Y" , strtotime($registrationModel->tglDaftar)).'", 
        "noKartu": "'.$registrationModel->noKartu.'",
        "kdPoli": "'.$registrationModel->kdPoli.'",
        "keluhan": "'.$registrationModel->keluhan.'",
        "kunjSakit": '. $registrationModel->kunjSakit .',
        "sistole": "'.$registrationModel->sistole.'",
        "diastole": "'.$registrationModel->diastole.'",
        "beratBadan": "'.$registrationModel->beratBadan.'",
        "tinggiBadan": "'.$registrationModel->tinggiBadan.'",
        "respRate": "'.$registrationModel->respRate.'",
        "heartRate": "'.$registrationModel->heartRate.'",
        "rujukBalik":"'.$registrationModel->rujukBalik.'",
        "kdTkp": "'.$registrationModel->kdTkp.'"
      }';

//        print_r($payload);
//BARU SAMPAI DISINI
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/pendaftaran']);
            $request = $client->createRequest()
                ->setContent($payload)->setMethod('POST')
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

    public function setConsId($consId)
    {
        $this->cons_id = $consId;
    }
//    public function setWdId($consId)
//    {
//        $this->consId = $consId;
//    }

    public function getKesadaran()
    {
        $bpjs_user = self::getUsercreds($this->cons_id);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/kesadaran']);
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

    public function getStatuspulang($kdTkp)
    {

        $true = '';
        if ($this->kdTkp == 10) {
            $true = 'false';
        } else if  ($this->kdTkp == 20) {
            $true = 'true';
        }
        $bpjs_user = self::getUsercreds($this->cons_id);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/statuspulang/rawatInap/' . $true]);
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

    public function getDokter()
    {

        $bpjs_user = self::getUsercreds($this->cons_id);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/dokter/0/999']);
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

    public function getPoli()
    {
        $bpjs_user = self::getUsercreds($this->cons_id);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/poli/fktp/0/999']);
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
            return $exception;
        }
    }


    public function getPolicodesarray($consid)
    {
        $bpjs_user = self::getUsercreds($consid);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/poli/fktp/0/999']);
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
            return $exception;
        }
    }


    public function getPendaftaranprovider($date)
    {
        $bpjs_user = self::getUsercreds($this->cons_id);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/pendaftaran/tglDaftar/'.$date.'/0/999']);
            $request = $client->createRequest()
//                ->setContent($payload)->setMethod('POST')
                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

            $response = $request->send();
            return $response;
        } catch (\yii\base\Exception $exception) {

            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
            return $exception;
        }
    }




    public function deletePcare() {
        $bpjs_user = self::getUsercreds($this->cons_id);
        try {
//            peserta/0001113569638/tglDaftar/31-10-2020/noUrut/A1/kdPoli/001
            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/pendaftaran/peserta/'.$this->noKartu.'/tglDaftar/'
                .date("d-m-Y" , strtotime($this->tglDaftar)).'/noUrut/'.$this->no_urut.'/kdPoli/' . $this->kdPoli]);
            $request = $client->createRequest()
//                ->setContent($payload)
                ->setMethod('DELETE')
                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

            $response = $request->send();
            return $response;
        } catch (\yii\base\Exception $exception) {

            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
            return $exception;
        }

    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

//        $this->tglDaftar = date('Y-m-d', strtotime($this->tglDaftar));

        if($this->isNewRecord)
        {

//            $this->createddate=new CDbExpression('NOW()');
        }else{

//            $this->modifieddate = new CDbExpression('NOW()');
        }
        return true;
    }

    public function afterFind()
    {
        if (!parent::afterFind()) {
            return false;
        }

//        $this->tglDaftar = date('d-m-Y', strtotime($this->tglDaftar));

        return true;
    }


}

