<?php
namespace app\controllers\rest;

use app\models\Bpjs;
use RR\Shunt\Context;
use RR\Shunt\Parser;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\helpers\Url;
use app\models\Peserta;
use app\models\Pendaftaran;
use app\models\Kunjungan;
use app\models\learning\Tool;
use Yii;

class ToolController extends ActiveController
{
    public $modelClass = 'app\models\Tool';

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
    public function actionGettools()
    {
        $toolModels = Tool::find()->andWhere(['status' => 'enabled'])->orderBy(['name' => SORT_ASC])->All();
        //print_r($toolModel);
        $ret = [];
        $retprep = [];
        foreach ($toolModels as $toolModel) {
            $toadd = [];
            // $ret['response'][$toolModel->id]['id'] = $toolModel->id;
            // $ret['response'][$toolModel->id]['name'] = $toolModel->name;
            // $ret['response'][$toolModel->id]['background'] = $toolModel->background;
            // $ret['response'][$toolModel->id]['image'] = $toolModel->image;
            // $ret['response'][$toolModel->id]['inputs'] = $toolModel->toolInputs;
            // $ret['response'][$toolModel->id]['outputs'] = $toolModel->toolOutputs;
            // $ret['response'][$toolModel->id]['calculations'] = $toolModel->toolCalculations;
            $toadd['id'] = $toolModel->id;
            $toadd['name'] = $toolModel->name;
            $toadd['background'] = $toolModel->background;
            $toadd['image'] = $toolModel->image;
            $toadd['inputs'] = $toolModel->toolInputs;
            $toadd['outputs'] = $toolModel->toolOutputs;
            $toadd['calculations'] = $toolModel->toolCalculations;
            array_push($retprep, $toadd);
        }
        $ret['response'] = $retprep;
        //$ret = json_decode($toolModel);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $ret;
    }


    public function actionGettool($id)
    {
        $toolModel = Tool::findOne($id);
        //print_r($toolModel);
        $ret = [];
        $ret['response']['id'] = $toolModel->id;
        $ret['response']['background'] = $toolModel->background;
        $ret['response']['image'] = $toolModel->image;
        $ret['response']['inputs'] = $toolModel->toolInputs;
        $ret['response']['outputs'] = $toolModel->toolOutputs;
        $ret['response']['calculations'] = $toolModel->toolCalculations;
        //$ret = json_decode($toolModel);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $ret;
    }

    public function actionCalculate($id)
    {
        $toolModel = Tool::findOne($id);
        //print_r($toolModel);

        $inputs = $toolModel->toolInputs;
        $outputs = $toolModel->toolOutputs;

        $output_type = '';
        $output_name = '';
        $output_result = 0;

        $ctx = new Context();
        $ctx->def('abs'); // wrapper for PHP "abs" function
        $ctx->def('sqrt');
        $ctx->def('pow');
        $ctx->def('fmod');
        $ctx->def('max');
        $ctx->def('min');
        $ctx->def('round');
        $ctx->def('floor');
        $ctx->def('ceil');
        foreach ($outputs as $output)
        {
            $output_type = $output->output_type;
            $output_name = $output->output_name;

        }

        $request = Yii::$app->request;
        $params = $request->bodyParams;
        $param = $request->getBodyParam('payloadData');


        //check if payload contains all input vars
        $ret = [];
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            foreach ($inputs as $input) {
if(array_key_exists($input->input_name, $param)) {
                    $ctx->def($input->input_name, $param[$input->input_name]); // constant "foo" with value "5"
                    //$inputVals[$input->input_name] = $post[$input->input_name];
                } else {
    $ret['metaData']['message'] = "Key " . $input->input_name." does not exist";
    $ret['metaData']['code'] = '400';
    return $ret;
                }

            }


        $equation = $toolModel->toolCalculations[0]->formula;
        $result = Parser::parse($equation, $ctx);

        $resultrounded = 0;
        if ($result >= 10) {
            $resultrounded = round($result, 1);
        } else {
            $resultrounded = round($result, 1);
        }


        $ret['response']['result'] = $resultrounded;
        $ret['response']['unit'] = $toolModel->background;
        $ret['response']['output_name'] = $output_name;
        $ret['response']['output_type'] = $output_type;
        //$ret['response']['calculations'] = $toolModel->toolCalculations;
        //$ret = json_decode($toolModel);
        $ret['metaData']['message'] = "success";
        $ret['metaData']['code'] = '200';

        return $ret;
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
        $result = json_decode(Bpjs::getPeserta($nomorbpjs));

        $ret['response']['bpjsNo'] = $result->noKartu;
        $ret['response']['bpjsClass']['name'] = $result->jnsKelas->nama;
        $ret['response']['bpjsClass']['code'] = $result->jnsKelas->kode;
        $ret['response']['bpjsType']['name'] = $result->jnsPeserta->nama;
        $ret['response']['bpjsType']['code'] = $result->jnsPeserta->kode;
        $ret['response']['active'] = $result->aktif;
        $ret['response']['activeDescription'] = $result->ketAktif;
        $ret['metaData']['message'] = "success";
        $ret['metaData']['code'] = '200';

//        }

//
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
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