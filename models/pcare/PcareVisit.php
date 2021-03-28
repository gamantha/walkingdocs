<?php

namespace app\models\pcare;

use app\models\Consid;
use Yii;
use yii\httpclient\Client;
use kartik\select2\Select2;

/**
 * This is the model class for table "pcare_visit".
 *
 * @property int $id
 * @property int|null $pendaftaranId
 * @property string|null $noKunjungan
 * @property string|null $kdSadar
 * @property string|null $terapi
 * @property string|null $kdStatusPulang
 * @property string|null $tglPulang
 * @property string|null $kdDokter
 * @property string|null $kdDiag1
 * @property string|null $kdDiag2
 * @property string|null $kdDiag3
 * @property string|null $kdPoliRujukInternal
 * @property string|null $tglEstRujuk
 * @property string|null $kdppk
 * @property string|null $kdppk_subSpesialis
 * @property string|null $nmppk
 * @property string|null $nmppk_subSpesialis
 * @property string|null $spesialis_type
 * @property string|null $subSpesialis_kdSpesialis
 * @property string|null $subSpesialis_nmSpesialis
 * @property string|null $subSpesialis_nmSubSpesialis1
 * @property string|null $subSpesialis_kdSubSpesialis1
 * @property string|null $subSpesialis_kdSarana
 * @property string|null $subSpesialis_nmSarana
 * @property string|null $khusus_kdKhusus
 * @property string|null $khusus_nmKhusus
 * @property string|null $khusus_kdSubSpesialis
 * @property string|null $khusus_nmSubSpesialis
 * @property string|null $khusus_catatan
 * @property string|null $kdTacc
 * @property string|null $alasanTacc
 * @property string|null $json
 * @property string|null $status
 * @property string|null $nmDokter
 * @property string|null $nmDiag1
 * @property string|null $nmDiag2
 * @property string|null $nmDiag3
 * @property string|null $meta_rujukan
 * @property string|null $created_at
 * @property string|null $modified_at
 *
 * @property PcareRegistration $pendaftaran
 */
class PcareVisit extends \yii\db\ActiveRecord
{

    public $wdId;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pcare_visit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pendaftaranId'], 'integer'],
            [['terapi', 'khusus_catatan', 'alasanTacc', 'json', 'meta_rujukan'], 'string'],
            [['tglPulang', 'tglEstRujuk', 'created_at', 'modified_at'], 'safe'],
            [['noKunjungan', 'kdSadar', 'kdStatusPulang', 'kdDokter', 'kdDiag1', 'kdDiag2', 'kdDiag3', 'kdPoliRujukInternal', 'kdppk', 'kdppk_subSpesialis', 'nmppk', 'nmppk_subSpesialis', 'spesialis_type', 'subSpesialis_kdSpesialis', 'subSpesialis_nmSpesialis', 'subSpesialis_nmSubSpesialis1', 'subSpesialis_kdSubSpesialis1', 'subSpesialis_kdSarana', 'subSpesialis_nmSarana', 'khusus_kdKhusus', 'khusus_nmKhusus', 'khusus_kdSubSpesialis', 'khusus_nmSubSpesialis', 'kdTacc', 'status', 'nmDokter', 'nmDiag1', 'nmDiag2', 'nmDiag3'], 'string', 'max' => 255],
            [['pendaftaranId'], 'exist', 'skipOnError' => true, 'targetClass' => PcareRegistration::className(), 'targetAttribute' => ['pendaftaranId' => 'id']],
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pendaftaranId' => Yii::t('app', 'Pendaftaran ID'),
            'noKunjungan' => Yii::t('app', 'No Kunjungan'),
            'kdSadar' => Yii::t('app', 'Kd Sadar'),
            'terapi' => Yii::t('app', 'Terapi'),
            'kdStatusPulang' => Yii::t('app', 'Kd Status Pulang'),
            'tglPulang' => Yii::t('app', 'Tgl Pulang'),
            'kdDokter' => Yii::t('app', 'Kd Dokter'),
            'kdDiag1' => Yii::t('app', 'Kd Diag1'),
            'kdDiag2' => Yii::t('app', 'Kd Diag2'),
            'kdDiag3' => Yii::t('app', 'Kd Diag3'),
            'kdPoliRujukInternal' => Yii::t('app', 'Kd Poli Rujuk Internal'),
            'tglEstRujuk' => Yii::t('app', 'Tgl Est Rujuk'),
            'kdppk' => Yii::t('app', 'Kdppk'),
            'kdppk_subSpesialis' => Yii::t('app', 'Kdppk Sub Spesialis'),
            'nmppk' => Yii::t('app', 'Nmppk'),
            'nmppk_subSpesialis' => Yii::t('app', 'Nmppk Sub Spesialis'),
            'spesialis_type' => Yii::t('app', 'Spesialis Type'),
            'subSpesialis_kdSpesialis' => Yii::t('app', 'Sub Spesialis Kd Spesialis'),
            'subSpesialis_nmSpesialis' => Yii::t('app', 'Sub Spesialis Nm Spesialis'),
            'subSpesialis_nmSubSpesialis1' => Yii::t('app', 'Sub Spesialis Nm Sub Spesialis1'),
            'subSpesialis_kdSubSpesialis1' => Yii::t('app', 'Sub Spesialis Kd Sub Spesialis1'),
            'subSpesialis_kdSarana' => Yii::t('app', 'Sub Spesialis Kd Sarana'),
            'subSpesialis_nmSarana' => Yii::t('app', 'Sub Spesialis Nm Sarana'),
            'khusus_kdKhusus' => Yii::t('app', 'Khusus Kd Khusus'),
            'khusus_nmKhusus' => Yii::t('app', 'Khusus Nm Khusus'),
            'khusus_kdSubSpesialis' => Yii::t('app', 'Khusus Kd Sub Spesialis'),
            'khusus_nmSubSpesialis' => Yii::t('app', 'Khusus Nm Sub Spesialis'),
            'khusus_catatan' => Yii::t('app', 'Khusus Catatan'),
            'kdTacc' => Yii::t('app', 'Kd Tacc'),
            'alasanTacc' => Yii::t('app', 'Alasan Tacc'),
            'json' => Yii::t('app', 'Json'),
            'status' => Yii::t('app', 'Status'),
            'nmDokter' => Yii::t('app', 'Nm Dokter'),
            'nmDiag1' => Yii::t('app', 'Nm Diag1'),
            'nmDiag2' => Yii::t('app', 'Nm Diag2'),
            'nmDiag3' => Yii::t('app', 'Nm Diag3'),
            'meta_rujukan' => Yii::t('app', 'Meta Rujukan'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * Gets query for [[Pendaftaran]].
     *
     * @return \yii\db\ActiveQuery|PcareRegistrationQuery
     */
    public function getPendaftaran()
    {
        return $this->hasOne(PcareRegistration::className(), ['id' => 'pendaftaranId']);
    }

    /**
     * {@inheritdoc}
     * @return PcareVisitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PcareVisitQuery(get_called_class());
    }

    public function Submitvisitdata($id)
    {
        $bpjs_user = self::getUsercreds($this->pendaftaran->cons_id);
        $visitModel = PcareVisit::find()->andWhere(['pendaftaranId' => $id])->One();
        $registrationModel = PcareRegistration::findOne($visitModel->pendaftaranId);




        $subspesialis_payload = 'null';
        $khusus_payload = 'null';

        if ($visitModel->spesialis_type == 'spesialis')
        {
            $subspesialis_payload = '{
       "kdSubSpesialis1": "'.$visitModel->subSpesialis_kdSubSpesialis1.'",
      "kdSarana": "'.$visitModel->subSpesialis_kdSarana .'"
            }';

            $ppk_payload = $visitModel->kdppk_subSpesialis;
        } else {
            $ppk_payload = $visitModel->kdppk;
        }
        $terapi = str_replace(array("\n", "\r"), '', $visitModel->terapi);
//        $terapi = str_replace("\n",',',$visitModel->terapi);
        $payload = '{
         "noKunjungan": "'.$visitModel->noKunjungan.'",
        "tglDaftar": "'.date("d-m-Y" , strtotime($registrationModel->tglDaftar)).'", 
        "noKartu": "'.$registrationModel->noKartu.'",
        "kdPoli": "'.$registrationModel->kdPoli.'",
        "keluhan": "'.$registrationModel->keluhan.'",
  "kdSadar": "'.$visitModel->kdSadar.'",
  
          "sistole": "'.$registrationModel->sistole.'",
        "diastole": "'.$registrationModel->diastole.'",
        "beratBadan": "'.$registrationModel->beratBadan.'",
        "tinggiBadan": "'.$registrationModel->tinggiBadan.'",
        "respRate": "'.$registrationModel->respRate.'",
        "heartRate": "'.$registrationModel->heartRate.'",


          "terapi": "'.$terapi.'",
     "kdStatusPulang": "'.$visitModel->kdStatusPulang.'",

     "tglPulang": "'.date("d-m-Y" , strtotime($visitModel->tglPulang)).'", 
     "kdDokter": "'.$visitModel->kdDokter.'",
     "kdDiag1": "'.$visitModel->kdDiag1.'",
     "kdDiag2": "'.$visitModel->kdDiag2.'",
     "kdDiag3": "'.$visitModel->kdDiag3.'",
     "kdPoliRujukInternal": "'.$visitModel->kdPoliRujukInternal.'",
  "rujukLanjut": {	
  	"tglEstRujuk": "'.date("d-m-Y" , strtotime($visitModel->tglEstRujuk)).'", 
    "kdppk": "'.$ppk_payload.'",
    "subSpesialis": '.$subspesialis_payload.',
    "khusus":  '.$khusus_payload.'
  },
          "kdTacc": "'.$visitModel->kdTacc.'",
               "alasanTacc": "'.$visitModel->alasanTacc.'"

     
      }';

        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/kunjungan']);
            $request = $client->createRequest()
                ->setContent($payload)->setMethod('POST')
                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

            $response = $request->send();
//            return $payload;
            return $response->content;
        } catch (\yii\base\Exception $exception) {

            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
        }


    }


    public function getUsercreds($cons_id)
    {
        $usercreds = [];
        $bpjs_user = Consid::find()->andWhere(['cons_id' => $cons_id])->One();
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

    public function getReferensiSubspesialis($keyword)
    {
        $bpjs_user = self::getUsercreds($this->pendaftaran->cons_id);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/'.$keyword.'/subspesialis']);
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

    public function getDiagnosecodes($keyword)
    {
//        $bpjs_user = self::getUsercreds($this->pendaftaran->cons_id);
//        $clinic = Consid::find()->andWhere(['wd_id' => 'wdid2'])->One();
        $bpjs_user = self::getUsercreds($this->pendaftaran->cons_id);
//        $bpjs_user = self::getUsercreds($this->pendaftaran->cons_id);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/diagnosa/'.$keyword.'/0/1000']);
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


    public function getReferensiSpesialis()
    {
        $bpjs_user = self::getUsercreds($this->pendaftaran->cons_id);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis']);
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



    public function getReferensiKhusus()
    {
        $bpjs_user = self::getUsercreds($this->pendaftaran->cons_id);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/khusus']);
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

    public function getSarana()
    {
        $bpjs_user = self::getUsercreds($this->pendaftaran->cons_id);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/sarana']);
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

    public function getKhusussubspesialis($keyword)
    {
        $bpjs_user = self::getUsercreds($this->pendaftaran->cons_id);
        try {

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/'.$keyword.'/subspesialis']);
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


    public function getRujukanKhusus($kdkhusus, $kdsubspesialis, $tglrujuk, $noKartu)
    {
        $bpjs_user = self::getUsercreds($this->pendaftaran->cons_id);
        try {
            $converted_date = date("d-m-Y" , strtotime($tglrujuk));
            $list = ['THA', 'HEM'];
            if (in_array(strtoupper($kdkhusus), $list)) {
                $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/rujuk/khusus/'.$kdkhusus.'/subspesialis/'.$kdsubspesialis.'/noKartu/'.$noKartu.'/tglEstRujuk/' . $converted_date]);
            } else {
                $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/rujuk/khusus/'.$kdkhusus.'/noKartu/'.$noKartu.'/tglEstRujuk/' . $converted_date]);
            }

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

    public function getRujukanSpesialis($kdsubspesialis,$sarana,$tglrujuk)
    {


        $bpjs_user = self::getUsercreds($this->pendaftaran->cons_id);
        try {
            $converted_date = date("d-m-Y" , strtotime($tglrujuk));
            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/rujuk/subspesialis/'.$kdsubspesialis.'/sarana/'.$sarana.'/tglEstRujuk/' . $converted_date]);
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

    public function setWdId($wdId)
    {
        $this->wdId = $wdId;
    }
    public function setConsId($consId)
    {
        $this->consId = $consId;
    }


    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }



//        $this->tglPulang = date('Y-m-d', strtotime($this->tglPulang));
//        $this->tglEstRujuk = date('Y-m-d', strtotime($this->tglEstRujuk));

        if($this->isNewRecord)
        {

//            $this->createddate=new CDbExpression('NOW()');
        }else{
//            $this->modifieddate = new CDbExpression('NOW()');
        }
        return true;
    }



}
