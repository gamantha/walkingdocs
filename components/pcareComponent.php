<?php

namespace app\components;


use app\models\Consid;
use app\models\pcare\PcareRegistration;
use app\models\pcare\PcareVisit;
use app\models\pcare\WdPassedValues;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;

class pcareComponent extends Component
{

    const BASE_API_URL = "https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0/";

    public function welcome()
    {
        echo "Hello..Welcome to MyComponent";
    }


    public function pcareRegister($payload, $consid)
    {
        $bpjs_user = self::getUsercreds($consid);
        $client = new Client(['baseUrl' => self::BASE_API_URL . 'pendaftaran']);
        $request = $client->createRequest()
            ->setContent($payload)->setMethod('POST')
            ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
            ->addHeaders(['content-type' => 'application/json'])
            ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
            ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
            ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

        $regsiterresponse = $request->send();
        $registerresp =  $regsiterresponse->content;
        return $registerresp;
    }

    public function pcareCreatevisit($payload, $consid)
    {
        $bpjs_user = self::getUsercreds($consid);
        try {

            Yii::$app->session->setFlash('warning', $payload);
            $client = new Client(['baseUrl' => self::BASE_API_URL . 'kunjungan']);
            $request = $client->createRequest()
                ->setContent($payload)->setMethod('POST')
                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

            $vresponse = $request->send();
            $visitresp = $vresponse->content;
            return $visitresp;
        } catch (\yii\base\Exception $exception) {

            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
        }

    }

    public function getUsercreds($consId)
    {
        $usercreds = [];
        $bpjs_user = Consid::find()->andWhere(['cons_id' => $consId])->One();
        if ($bpjs_user == null) {
            $usercreds['isnull'] = true;
            return $usercreds;
        } else {
            $usercreds['isnull'] = false;
        }
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


    public function integrationCheck($consid)
    {
//        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $bpjs_user = self::getUsercreds($consid);
        if ($bpjs_user['isnull']) {
            Yii::warning("null response");
            $response['response'] = null;
            $response['metaData'] = null;
            return json_encode($response);
        }
        try {

            $client = new Client(['baseUrl' => 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0/kesadaran']);
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

    public function cekPesertaByNokartu($consId,$noKartu)
    {
        $bpjs_user = self::getUsercreds($consId);
        try {

            $client = new Client(['baseUrl' => self::BASE_API_URL . 'peserta/' . $noKartu]);
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
            return $exception;
        }
    }

    public function cekPesertaByNik($consId)
    {
        $bpjs_user = self::getUsercreds($consId);
        try {

            $client2 = new Client(['baseUrl' => self::BASE_API_URL .'peserta/nik/' . $this->nik]);
            $request2 = $client2->createRequest()
//                ->setContent($payload)->setMethod('POST')
                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

            $response2 = $request2->send();
            return $response2->content;
        } catch (\yii\base\Exception $exception) {

            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
        }
    }











    public function getPoli($consid)
    {
        $bpjs_user = self::getUsercreds($consid);
        try {

            $client = new Client(['baseUrl' => self::BASE_API_URL . 'poli/fktp/0/999']);
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

    public function getDoctor($consid)
    {
        $bpjs_user = self::getUsercreds($consid);
        try {

            $client = new Client(['baseUrl' => self::BASE_API_URL . 'dokter/0/999']);
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
        public function getListDoctor($consid)
        {

            $list = $this->getDoctor($consid);
            $json = json_decode($list);
            $options = [];
            if (isset($json->response)) {


                foreach ($json->response->list as $i)
                {
                    $options[$i->kdDokter] = $i->kdDokter . ' : ' . $i->nmDokter;
                }
            } else {
                Yii::$app->session->addFlash('danger', 'get dokter - no pcare web service response');
            }

            return $options;
        }

    public function getListPoli($consid, $issakit)
    {

        $response = $this->getPoli($consid);

        $options = [];

        $json = json_decode($response);

        if (isset($json->metaData->code)) {
            if ($json->metaData->code == 200) {
                foreach ($json->response->list as $i)
                {
                    if ($i->poliSakit == filter_var($issakit, FILTER_VALIDATE_BOOLEAN)) {
                        $options[$i->kdPoli] = $i->kdPoli . ' : ' . $i->nmPoli;
                    }

                }
            } else {
                Yii::$app->session->setFlash('danger', "BPJS Error : " . $json->metaData->message);
            }

        } else {
            Yii::$app->session->setFlash('danger', "BPJS no response - get poli    ");
        }

        return $options;

    }


    public function getKesadaran($consid)
    {
        $bpjs_user = self::getUsercreds($consid);
        try {

            $client = new Client(['baseUrl' => self::BASE_API_URL . 'kesadaran']);
            $request = $client->createRequest()
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

    public function getListKesadaran($consid)
    {

        $kesadaran = $this->getKesadaran($consid);
        $json = json_decode($kesadaran);

        $options = [];
        if (isset($json->response)) {
            if ($json->metaData->code == 200) {
                foreach ($json->response->list as $i) {
                    $options[$i->kdSadar] = $i->kdSadar . ' : ' . $i->nmSadar;
                }

                return $options;
            } else {
                Yii::$app->session->addFlash('danger', 'cek peserta failed');
                return $options;
            }
        } else {
            Yii::$app->session->addFlash('danger', 'no pcare web service response - getkesadaran');
            return $options;
        }

    }

    public function getDiagnosecodes($keyword, $consid)
    {

        $bpjs_user = self::getUsercreds($consid);

        try {

            $client = new Client(['baseUrl' => self::BASE_API_URL  . 'diagnosa/'.$keyword.'/0/1000']);
            $request = $client->createRequest()
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


    public function validateCreate($model)
    {

        if (empty(json_decode($model->params))) {
            Yii::$app->session->addFlash('warning', 'no params');
        } else {
            Yii::$app->session->addFlash('success', 'Params : ' . json_encode((json_decode($model->params))));
            return $paramsexistflag = true;

//                $model->params = json_encode($params);
        }

        $cookies = Yii::$app->request->cookies;
        if (empty($cookies)) {
            Yii::$app->session->addFlash('warning', 'no cookies');
        } else {
            Yii::$app->session->addFlash('success', 'Cookie : ' . json_encode($cookies));
            return $cookiesexistflag = true;
        }




        return false;
    }


    public function validateClinicsender($params)
    {

        /** check clinic ID */
        if (!isset($params->clinicId)) {
            Yii::$app->session->addFlash('danger', "invalid data clinicID");
            return false;
        } else {
//            Yii::$app->session->addFlash('success', "ClinicID is valid");
        }
        /** check consID in database */
        $considmodel = Consid::find()->andWhere(['wd_id' => $params->clinicId])->One();
        if (isset($considmodel->cons_id)) {
            Yii::$app->session->addFlash('success', "ConsID is valid");
            return $considmodel;

        } else {
            Yii::$app->session->addFlash('danger', "NO ConsID data!!!");
            return false;
        }

        return false;
    }



    public function checkVisitId($params, $cookies)
    {


        /** check visit ID in params  */
        if (!isset($params['visitId'])) {
            Yii::$app->session->addFlash('danger', "ConsID : not found in Params");
//            return false;
        }
        /** check visit ID in cookies */
        if (isset($cookies['visitId'])) {
            $cookie_visitid = $cookies['visitId']->value;
            Yii::$app->session->addFlash('success', "ConsID : FOUND in cookies");
            $wdmodel = WdPassedValues::find()->andWhere(['wdVisitId' => $cookie_visitid])->One();
        } else {
            Yii::$app->session->addFlash('danger', "ConsID : not found in Cookies");
        }




        $draftexist = 0;
        $cookiesresp = Yii::$app->response->cookies;
        $cookiesresp->add(new \yii\web\Cookie(
            [
                'name' => 'visitId',
                'value' => $params['visitId'],
            ]        ));

        $wdmodel_exist = WdPassedValues::find()->andWhere(['wdVisitId' =>  $params['visitId']])->andWhere(['clinicId' => $params['clinicId']])->One();
        if ($wdmodel_exist)
        {
            if (isset($wdmodel_exist->status)) {

                if ($wdmodel_exist->status == 'registered') {
//                        Yii::$app->session->addFlash('success', "draft registered");
                    $visit = PcareVisit::find()->andWhere(['pendaftaranId' => $wdmodel_exist->registrationId])->One();
                    if ($visit->status != "submitted") {
                        return $this->redirect(['pcare/visit/update', 'id' => $wdmodel_exist->registrationId]);
                    } else {
                        return $this->redirect(['view', 'id' => $wdmodel_exist->registrationId]);
                    }
                } else if ($wdmodel_exist->status == 'draft') {
                    $draftexist = 1;

//                        $this->refresh();
                    $wdmodel_exist->delete();

                }
            }

        }

        if ($draftexist) {
            $wdmodel_exist->delete();

        }
        return true;
    }


    public function fillPayload($model)
    {
        $payload = '{
        "kdProviderPeserta": "'.$model->kdProviderPeserta.'",
        "tglDaftar": "'.date("d-m-Y" , strtotime($model->tglDaftar)).'", 
        "noKartu": "'.$model->noKartu.'",
        "kdPoli": "'.trim($model->kdPoli).'",
        "keluhan": "'.$model->keluhan.'",
        "kunjSakit": '. $model->kunjSakit .',
        "sistole": "'.$model->sistole.'",
        "diastole": "'.$model->diastole.'",
        "beratBadan": "'.$model->beratBadan.'",
        "tinggiBadan": "'.$model->tinggiBadan.'",
        "respRate": "'.$model->respRate.'",
        "heartRate": "'.$model->heartRate.'",
        "rujukBalik":"'.$model->rujukBalik.'",
        "kdTkp": "'.$model->kdTkp.'"
      }';

        return $payload;
    }



    public function getPendaftaranprovider($date,$cons_id)
    {
        $bpjs_user = self::getUsercreds($cons_id);
        try {

            $client = new Client(['baseUrl' => self::BASE_API_URL  . '/pendaftaran/tglDaftar/'.$date.'/0/999']);
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



    public function getStatuspulang($cons_id,$kdTkp)
    {


        $kesadaran = $this->getStatuspulang2($cons_id,$kdTkp);
        $json = json_decode($kesadaran);
        $options = [];
        foreach ($json->response->list as $i)
        {
            $options[$i->kdStatusPulang] = $i->kdStatusPulang . ' : ' . $i->nmStatusPulang;
        }

        return $options;
    }

    public function getStatuspulang2($cons_id,$kdTkp)
    {

        $true = '';
        if ($kdTkp == 10) {
            $true = 'false';
        } else if  ($kdTkp == 20) {
            $true = 'true';
        }
        $bpjs_user = self::getUsercreds($cons_id);
        try {

            $client = new Client(['baseUrl' => self::BASE_API_URL  . '/statuspulang/rawatInap/' . $true]);
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
?>