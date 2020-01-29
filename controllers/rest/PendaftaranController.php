<?php
namespace app\controllers\rest;

use app\models\Bpjs;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\helpers\Url;
use app\models\Peserta;
use app\models\Pendaftaran;
use app\models\Kunjungan;
use Yii;

class PendaftaranController extends ActiveController
{
    public $modelClass = 'app\models\Pendaftaran';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'registration' => ['POST','PUT', 'GET'],
                    'checkeligibility' => ['POST'],
                ],
            ],
        ];
    }

    public function actionTest()
    {
        echo 'test';
    }

    /**
     * @return array
     * find in cache first. if not there then get data from BPJS API
     */
    public function actionCheckeligibility()
    {
        $request = Yii::$app->request;
        $ret = [];
        $params = $request->bodyParams;
        $param = $request->getBodyParam('payloadData');
        $nomorbpjs = $param['bpjsNo'];
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //return $nomorbpjs;
        $result = json_decode(Bpjs::getPeserta($nomorbpjs));

//        $ret['response']['bpjsNo'] = $result->noKartu;
//        $ret['response']['bpjsClass']['name'] = $result->jnsKelas->nama;
//        $ret['response']['bpjsClass']['code'] = $result->jnsKelas->kode;
//        $ret['response']['bpjsType']['name'] = $result->jnsPeserta->nama;
//        $ret['response']['bpjsType']['code'] = $result->jnsPeserta->kode;
//        $ret['response']['active'] = $result->aktif;
//        $ret['response']['activeDescription'] = $result->ketAktif;
//        $ret['metaData']['message'] = "success";
//        $ret['metaData']['code'] = '200';
        $ret['response'] = $result;
        return $ret;
    }


    public function actionRegistration()
    {
//TODO : send out status type if the data has been sent to BPJS or not
        $request = Yii::$app->request;
        $params = $request->bodyParams;
        $param = $request->getBodyParam('payloadData');
        $daftardate = date("Y-m-d" , strtotime($param['registrationDate']));
        $ret = [];
        $statusmessage = '';
        $pendaftaranModel = Pendaftaran::find()
            ->andWhere(['no_bpjs' => $param['bpjsNo']])
            ->andWhere(['kdPoli' => $param['departmentCode']])
            ->andWhere(['tanggal_daftar' => $daftardate])
            ->andWhere(['kode_provider' => $param['providerCode']])
            ->One();

        if (is_null($pendaftaranModel)) {
            if ($request->isPost) {
                $pendaftaranModel = new Pendaftaran();
                $pendaftaranModel->no_bpjs = $param['bpjsNo'];
                $pendaftaranModel->kdPoli = $param['departmentCode'];
                $pendaftaranModel->tanggal_daftar = $daftardate;
                $pendaftaranModel->kode_provider = $param['providerCode'];


                $pendaftaranModel->save();
                $updatedModel = new Kunjungan();
                $updatedModel->pendaftaran_id = $pendaftaranModel->id;
                $statusmessage = 'CREATED';

            }else if ($request->isGet) {

                $updatedModel = Kunjungan::find()->andWhere(['pendaftaran_id' => $_GET['id']])->One();
                if (!is_null($updatedModel)) {
                    $daftardate2 = date("Y-m-d" , strtotime($updatedModel->pendaftaran->tanggal_daftar));
                    $responseModel = [];


                    $responseModel['id'] = $updatedModel->id;
                    $responseModel['name'] = $updatedModel->pendaftaran->nama;
                    $responseModel['bpjsStatus'] = $updatedModel->pendaftaran->status_peserta;
                    $responseModel['bpjsType'] = $updatedModel->pendaftaran->jenis_peserta;
                    $responseModel['registrationDate'] = $daftardate2;
                    $responseModel['pendaftaran_id'] = $updatedModel->pendaftaran_id;
                    $responseModel['systole'] = $updatedModel->sistole;
                    $responseModel['diastole'] = $updatedModel->diastole;
                    $responseModel['tkpCode'] = $updatedModel->kdTkp;
                    $responseModel['heart_rate'] = $updatedModel->heart_rate;
                    $responseModel['respiratory_rate'] = $updatedModel->respiratory_rate;
                    $responseModel['sickVisit'] = $updatedModel->kunjSakit;
                    $responseModel['referBack'] = $updatedModel->rujukBalik;
                    $responseModel['therapy'] = $updatedModel->terapi;


                    $responseModel['bpjsRegistrationStatus'] = $updatedModel->bpjs_kunjungan_status;
                    $responseModel['bpjsVisitStatus'] = $updatedModel->pendaftaran->bpjs_pendaftaran_status;

                    $ret['response']['modelType'] = 'Kunjungan';
                    $ret['response']['updatedModel'] = $responseModel;
                    $statusmessage = 'FOUND';
                    $ret['metaData']['code'] = 200;
                } else {
                    $statusmessage = 'NOT FOUND';
                    $ret['metaData']['code'] = 404;
                }

                $ret['metaData']['message'] = $statusmessage;

                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $ret;

            } else {
                $statusmessage = 'BAD REQUEST : No existing model - create has to be POST';
                $ret['metaData']['message'] = $statusmessage;
                $ret['metaData']['code'] = 400;
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $ret;
            }
        } else {
            if ($request->isPut) {

                $pendaftaranModel = Pendaftaran::find()
                    ->andWhere(['no_bpjs' => $param['bpjsNo']])
                    ->andWhere(['kdPoli' => $param['departmentCode']])
                    ->andWhere(['tanggal_daftar' => $daftardate])
                    ->andWhere(['kode_provider' => $param['providerCode']])
                    ->One();

                $updatedModel = Kunjungan::find()->andWhere(['pendaftaran_id' => $pendaftaranModel->id])->One();
                $statusmessage = 'UPDATED';

            } else {
                $statusmessage = 'BAD REQUEST : model existed - update has to be PUT';
                $ret['metaData']['message'] = $statusmessage;
                $ret['metaData']['code'] = 400;
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $ret;
            }
        }



            $updatedModel->sistole = $param['systole'];
            $updatedModel->diastole = $param['diastole'];
            $updatedModel->berat_badan = $param['bodyWeight'];
            $updatedModel->tinggi_badan = $param['bodyHeight'];
            $updatedModel->respiratory_rate = $param['respRate'];
            $updatedModel->heart_rate = $param['heartRate'];
            $updatedModel->rujukBalik = $param['referBack'];
            $updatedModel->kdTkp = $param['tkpCode'];
            $updatedModel->keluhan = $param['complaints'];
            $updatedModel->kunjSakit = $param['sickVisit'];
        //$responseModel['therapy'] = $updatedModel->terapi; //TODO : make sure the key name is the same with from WD

            $updatedModel->save();
            $responseModel = [];
        $responseModel['id'] = $updatedModel->id;
        $responseModel['name'] = $pendaftaranModel['nama'];
        $responseModel['bpjsStatus'] = $pendaftaranModel['status_peserta'];
        $responseModel['bpjsType'] = $pendaftaranModel['jenis_peserta'];
        $responseModel['registrationDate'] = $daftardate;
        $responseModel['pendaftaran_id'] = $updatedModel->pendaftaran_id;
        $responseModel['systole'] = $updatedModel->sistole;
        $responseModel['diastole'] = $updatedModel->diastole;
        $responseModel['tkpCode'] = $updatedModel->kdTkp;
        $responseModel['heart_rate'] = $updatedModel->heart_rate;
        $responseModel['respiratory_rate'] = $updatedModel->respiratory_rate;
        $responseModel['sickVisit'] = $updatedModel->kunjSakit;
        $responseModel['referBack'] = $updatedModel->rujukBalik;
        $responseModel['therapy'] = $updatedModel->terapi;

        $responseModel['bpjsRegistrationStatus'] = $updatedModel->bpjs_kunjungan_status;
        $responseModel['bpjsVisitStatus'] = $pendaftaranModel->bpjs_pendaftaran_status;


        $ret['response']['modelType'] = 'Kunjungan';
        $ret['response']['updatedModel'] = $responseModel;
        $ret['metaData']['message'] = $statusmessage;
        $ret['metaData']['code'] = 200;



        //return $param;
        //return $param['bpjsNo'];
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $ret;

    }
}

?>