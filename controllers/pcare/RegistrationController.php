<?php

namespace app\controllers\pcare;


use app\models\Consid;
use app\models\pcare\Antrean;
use app\models\pcare\ClinicInfo;
use app\models\pcare\ClinicUser;
use app\models\pcare\PcareVisit;
use app\models\pcare\WdPassedValues;
use phpDocumentor\Reflection\Types\Object_;
use Yii;
use app\models\pcare\PcareRegistration;
use app\models\pcare\PcareRegistrationSearch;
use yii\base\BaseObject;
use yii\base\Module;

use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegistrationController implements the CRUD actions for PcareRegistration model.
 *
 * registration status cycle :
 * new -> modified -> registered -> modified -> registered -> modified -> deleted
 */
class RegistrationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    const BASE_API_URL = "https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0/";

    /**
     * Lists all PcareRegistration models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PcareRegistrationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->setSort([
            'attributes' => [

            ],
            'defaultOrder' => [
                'id' => SORT_DESC
            ]
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PcareRegistration model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionError()
    {
        echo 'error';
    }


    public function fillWdModel(&$visitmodel,&$wdmodel, &$model, $params) {
        $wdmodel->wdVisitId = $params['visitId'];
        $wdmodel->clinicId = $params['clinicId'];
//
        if (empty($params['kdTkp'])) {
            $wdmodel->kdTkp = '10';
        } else {
            $wdmodel->kdTkp = $params['kdTkp'];
        }

        if (empty($params['kdPoli'])) {
            $wdmodel->kdPoli = '001';
        } else {
            $wdmodel->kdPoli = $params['kdPoli'];
        }


        $wdmodel->manualDiagnoses = substr($params['manualDiagnoses'],1,(strlen($params['manualDiagnoses']) - 2));
        $diagnoses = json_decode($wdmodel->manualDiagnoses);
        $wdmodel->manualDiagnose_description = isset($diagnoses->description)? $diagnoses->description : "";
        $wdmodel->manualDiagnose_treatment = isset($diagnoses->treatment)? $diagnoses->treatment : "";
        $wdmodel->doctor = $params['doctor'];
        $wdmodel->wdVisitId = $params['visitId'];
        $wdmodel->clinicId = $params['clinicId'];
        $wdmodel->noKartu = $params['noKartu'];
        $wdmodel->kunjSakit = $params['kunjSakit'];
        $wdmodel->kdProviderPeserta = $params['kdProviderPeserta'];
        $wdmodel->tglDaftar = $params['tglDaftar'];
        // optional
        $wdmodel->no_urut = $params['no_urut'];
        $wdmodel->keluhan = $params['keluhan'];
        $wdmodel->sistole = $params['sistole'];
        $wdmodel->diastole = $params['diastole'];
        $wdmodel->beratBadan = $params['beratBadan'];
        $wdmodel->tinggiBadan = $params['tinggiBadan'];
        $wdmodel->respRate = $params['respRate'];
        $wdmodel->heartRate = $params['heartRate'];

        $visitmodel->keluhan = $params['keluhan'];
        $visitmodel->sistole = $params['sistole'];
        $visitmodel->diastole = $params['diastole'];
        $visitmodel->beratBadan = $params['beratBadan'];
        $visitmodel->tinggiBadan = $params['tinggiBadan'];
        $visitmodel->respRate = $params['respRate'];
        $visitmodel->heartRate = $params['heartRate'];


        $wdmodel->administered = $params['administered'];
        $wdmodel->prescribed = $params['prescribed'];
        $wdmodel->kdPoli = $params['kdPoli'];
        $wdmodel->kdTkp = $params['kdTkp'];

        $model->noKartu = $wdmodel->noKartu;
        $model->kunjSakit = $wdmodel->kunjSakit;
        $model->kdTkp = $wdmodel->kdTkp;
        $model->kdProviderPeserta = $wdmodel->kdProviderPeserta;
        $model->tglDaftar = $wdmodel->tglDaftar;
        // optional
        $model->no_urut = $wdmodel->no_urut;
        $model->keluhan = $wdmodel->keluhan;
        $model->sistole = $wdmodel->sistole;
        $model->diastole = $wdmodel->diastole;
        $model->beratBadan = $wdmodel->beratBadan;
        $model->tinggiBadan = $wdmodel->tinggiBadan;
        $model->respRate = $wdmodel->respRate;
        $model->heartRate = $wdmodel->heartRate;
        $model->kdPoli = $wdmodel->kdPoli;
        $model->status = 'not ready';

        $checklist = json_encode($params['checklistNames']);
        $checklistnames = substr($params['checklistNames'],2,(strlen($params['checklistNames']) - 4));
        $wdmodel->checklistNames =str_replace('","', PHP_EOL,$checklistnames);
        $wdmodel->checklistNames = $checklistnames;

//            $pcarevisit->terapi = html_entity_decode($prescribed);

        $wdmodel->disposition = $params['disposition'];
        $wdmodel->statusAssessment = $params['statusAssesment'];
        $wdmodel->status = "draft";

        $wdmodel->save();
    }




    /**
     * Creates a new PcareRegistration model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /**
         * PRE POST check all values that is expected to be sent
         * PRE & POST validation EXACTLY the same
         * if all is good flag is true and ready to process
         *
         * 1. validate form
         * 2. submit create form
         */

        $this->layout = '@app/views/layouts/popuplayout';

        $model = new PcareRegistration();
        $pcarevisit = new PcareVisit();
        $pcarevisit->kdSadar = "01";
        $pcarevisit->kdStatusPulang = '0';
        $prescribed = '';
        $prescribedlist = [];
        $listData2 = [];
        $refKesadaran = [];
        $wdmodel = new WdPassedValues();
        $request = Yii::$app->request;
        $params = $request->bodyParams;
        $model->params = json_encode($params);
        $paramsexistflag = false;
        $cookiesexistflag = false;
        $refSpesialis = [];
        $refKhususdata = [];

        $nokartuok = 0;
        $nikok = 0;
        $initPoli = [];
        $confirmflag = false;
        $postflag = false;
        $clinicModel = new Consid();
        $refStatuspulang = [];


        if(isset($_POST['confirm']) || isset($_POST['register'])) {
            Yii::$app->session->addFlash('success', 'Confirm OR Register button pushed');
        $wdmodel->load(Yii::$app->request->post());
        $model->load(Yii::$app->request->post());
            $pcarevisit->load(Yii::$app->request->post());
            if (empty($model->params)) {
                Yii::$app->session->addFlash('warning', 'no model params');
            } else {
                Yii::$app->session->addFlash('success', 'yes model params');

            }



            $initPoli =Yii::$app->pcareComponent->getListPoli($model->cons_id, 'true');
            $listData2 = Yii::$app->pcareComponent->getListDoctor($model->cons_id);
            $refKesadaran = Yii::$app->pcareComponent->getListKesadaran($model->cons_id);
            $refSpesialis = Yii::$app->pcareComponent->getReferensiSpesialis($model->cons_id);
            $refKhususdata = Yii::$app->pcareComponent->getReferensiKhusus($model->cons_id);
//            $refStatuspulang = Yii::$app->pcareComponent->getStatuspulang('10', $model->cons_id);

                $response =  Yii::$app->pcareComponent->cekPesertaByNokartu($model->cons_id,$model->noKartu);
                $jsonval = json_decode($response);
//                Yii::$app->session->addFlash('warning', $response);

                if (isset($jsonval->metaData->code) && ($jsonval->metaData->code == 200)) {
                    if ($jsonval->response->aktif)
                    {
                        Yii::$app->session->addFlash('success', "no Kartu - Peserta aktif  ");
//                        $nokartuok = 1;
                        $model->kdProviderPeserta = $jsonval->response->kdProviderPst->kdProvider;
                        $model->status = 'ready';

                        $confirmflag = true;




                    } else {
                        Yii::$app->session->setFlash('danger', "nomor peserta tidak aktif");
                    }
                } else {
                    Yii::$app->session->addFlash('danger', 'no kartu error : ' . json_encode($jsonval));
                }





        } else {

            if ($postflag = Yii::$app->pcareComponent->validateCreate($model)) {

                if($clinicModel = Yii::$app->pcareComponent->validateClinicsender(json_decode($model->params)))
                {
                    $model->cons_id = $clinicModel->cons_id;
                    Yii::$app->session->addFlash('success', 'clinic ID is TRUE');
                    Yii::$app->session->addFlash('success', json_encode($params));
                    $this->fillWdModel($pcarevisit,$wdmodel,$model,$params);
//                    $prescribed = substr($params['prescribed'],2, (strlen($params['prescribed']) - 4));
//                    $pcarevisit->terapi = str_replace('","', "\n",$prescribed);

                    $initPoli =Yii::$app->pcareComponent->getListPoli($model->cons_id, 'true');
                    $listData2 = Yii::$app->pcareComponent->getListDoctor($model->cons_id);
                    $refKesadaran = Yii::$app->pcareComponent->getListKesadaran($model->cons_id);
                    $refSpesialis = Yii::$app->pcareComponent->getReferensiSpesialis($model->cons_id);
                    $refKhususdata = Yii::$app->pcareComponent->getReferensiKhusus($model->cons_id);
//                    $refStatuspulang = Yii::$app->pcareComponent->getStatuspulang($model->cons_id,10);
                    $prescribedlist = explode('","', $prescribed);


                    if(isset($model->kdTkp)) {
                        $model->kdTkp = '10';
                    }


                } else {
                    Yii::$app->session->addFlash('warning', 'clinic ID is not correct. make sure wd sends the correct clinic ID');

                }
            } else {
                Yii::$app->session->addFlash('danger', 'validation error');
            }




        }


        if(isset($_POST['confirm'])) {
            Yii::$app->session->addFlash('success', 'confirm!');
        } else if(isset($_POST['register'])) {
            Yii::$app->session->addFlash('success', 'REGISTER!');
            $payload = Yii::$app->pcareComponent->fillPayload($model);
            Yii::$app->session->addFlash('success', $payload);
            $registerresp = Yii::$app->pcareComponent->pcareRegister($payload, $model->cons_id);
            Yii::$app->session->addFlash('success', $registerresp);




            $jsonresp = json_decode($registerresp);

            if (isset($jsonresp->metaData->message))
            {
                if($jsonresp->metaData->message == 'CREATED') {
                    if(strpos($jsonresp->response->message, "null") ) {
                        Yii::$app->session->addFlash('danger', $registerresp);
                    } else {
                            $model->no_urut = $jsonresp->response->message;
//                            $model->status = 'registered';
//                            $model->save();
//                            $pcarevisit->pendaftaranId = $model->id;
//                            $wdmodel->registrationId = $model->id;
//                            $wdmodel->status = 'registered';
//                            $wdmodel->save();
//                            $pcarevisit->save();

                        Yii::$app->session->addFlash('success', 'no urut created ' . $jsonresp->response->message);


$khususpayload = "null";
$spesialispayload = "null";
                        $kdKhusus_subspesialis = "null";
if ($pcarevisit->spesialis_type == 'spesialis') {

    $spesialispayload = '{
            "kdSubSpesialis1": "'.$pcarevisit->subSpesialis_kdSubSpesialis1.'",
      "kdSarana": "'.$pcarevisit->subSpesialis_kdSarana.'"
    }';
} else if ($pcarevisit->spesialis_type == 'khusus') {

    if ($pcarevisit->khusus_kdKhusus == 'HEM')
    {
        $kdKhusus_subspesialis = $pcarevisit->khusus_kdSubSpesialis;
    }
    $khususpayload = '{
        "kdKhusus": "'.$pcarevisit->khusus_kdKhusus.'",
      "kdSubSpesialis": '.$kdKhusus_subspesialis.',
      "catatan": "peserta sudah biasa hemodialisa"
    }';
} else {

}
$rujukpayload = '{
        "tglEstRujuk": "'.date("d-m-Y" , strtotime($pcarevisit->tglEstRujuk)).'",
         "kdppk": "'.$pcarevisit->kdppk_subSpesialis.'",
                 "subSpesialis": '.$spesialispayload.',
                 "khusus" :' . $khususpayload .'}';

                        $visitpayload = '{
        "tglDaftar": "'.date("d-m-Y" , strtotime($model->tglDaftar)).'", 
        "noKartu": "'.$model->noKartu.'",
        "kdPoli": "'.$model->kdPoli.'",
        "keluhan": "'.$pcarevisit->keluhan.'",
          "kdSadar": "'.$pcarevisit->kdSadar.'",
                    "kdStatusPulang": "'.$pcarevisit->kdStatusPulang.'",
                            "tglPulang": "'.date("d-m-Y" , strtotime($pcarevisit->tglPulang)).'",
                              "kdDokter": "'.$pcarevisit->kdDokter.'",
                                        "kdDiag1": "'.$pcarevisit->kdDiag1.'",
                                          "kdDiag2": "'.$pcarevisit->kdDiag2.'",
                                            "kdDiag3": "'.$pcarevisit->kdDiag3.'",
                                              "terapi": "'.$pcarevisit->terapi.'",
          "sistole": "'.$pcarevisit->sistole.'",
        "diastole": "'.$pcarevisit->diastole.'",
        "beratBadan": "'.$pcarevisit->beratBadan.'",
        "tinggiBadan": "'.$pcarevisit->tinggiBadan.'",
        "respRate": "'.$pcarevisit->respRate.'",
        "heartRate": "'.$pcarevisit->heartRate.'",
        "rujukLanjut" : '. $rujukpayload . '}';


                        Yii::$app->session->addFlash('success', 'visit payload below');
                        Yii::$app->session->addFlash('success', $visitpayload);
                    $createvistresp = '';
                    /** INI YANG PENTING */
                        $createvistresp = Yii::$app->pcareComponent->pcareCreatevisit($visitpayload, $model->cons_id);

                        $jsonvisitresp = json_decode($createvistresp);

                        if (isset($jsonvisitresp->metaData->message)) {
                            if ($jsonvisitresp->metaData->message == 'CREATED') {
                                Yii::$app->session->addFlash('success', 'visit CREATED');
                            } else {
//                                Yii::$app->session->addFlash('danger', 'visit NOT CREATED');
                                Yii::$app->session->addFlash('danger', $createvistresp);
                                /** INI YANG PENTING - ini nanti auto deletenya dinyalain */
                                $deleteresp = Yii::$app->pcareComponent->pcareDeleteRegistration($model->cons_id, $model->noKartu, date("d-m-Y" , strtotime($model->tglDaftar)), $model->no_urut, $model->kdPoli);
//                                Yii::$app->session->addFlash('danger', 'Registration is AUTO-DELETED because visit data is invalid : ' . $deleteresp);
                            }
                        }

//                            return $this->redirect(['pcare/visit/update', 'id' => $model->id]);
                    }

                } else {
                    Yii::$app->session->addFlash('danger', $registerresp);

                }
            } else {
                Yii::$app->session->addFlash('danger', json_encode($jsonresp));
            }

        } else if(isset($_POST['update'])) {
            Yii::$app->session->addFlash('success', 'UPDATE');
        }






//        if (!$confirmflag) {
            return $this->render('testpost', [
                'model' => $model,
                'visitmodel' => $pcarevisit,
                'wdmodel' => $wdmodel,
                'initPoli' => $initPoli,
                'prescribed_list' => $prescribedlist,
                'listData2' => $listData2,
                'refKesadaran' => $refKesadaran,
                'refStatuspulang' => $refStatuspulang,
                'refSpesialis' => $refSpesialis,
'refKhususdata' => $refKhususdata
//                'params' => $params
            ]);
//        } else {
//            return $this->render('createconfirm', [
//                'model' => $model,
//                'visitmodel' => $pcarevisit,
//                'wdmodel' => $wdmodel,
//            ]);

//            return $this->redirect(['createconfirm', 'registration' => json_encode($model->kdProviderPeserta), 'visit' => json_encode($pcarevisit)]);
//        }
    }


    /**
     * Updates an existing PcareRegistration model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
//        if ($model->status != 'new') {
//            $model->status = 'modified';
//        } else {
//            $model->status = 'modified';
//        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->status = 'not ready';
            if (!empty($model->cons_id))
            {
                $response = $model->cekPesertaByNokartu();

                $jsonval = json_decode($response);

//            Yii::$app->session->setFlash('danger', json_encode($jsonval ));

                if (isset($jsonval->metaData->code) && ($jsonval->metaData->code == 200)) {
                    if ($jsonval->response->aktif)
                    {

                        $model->kdProviderPeserta = $jsonval->response->kdProviderPst->kdProvider;
                        $model->noKartu = $jsonval->response->noKartu;
                        $model->nik = $jsonval->response->noKTP;
                        $model->status = 'ready';

                        Yii::$app->session->addFlash('success', "Peserta aktif");
                        Yii::$app->session->addFlash('success', $model->tglDaftar);


                    } else {
                        $model->kdProviderPeserta = '';
                        Yii::$app->session->setFlash('danger', "nomor peserta tidak aktif");
//                return ' nomor peserta tidak valid';

                    }
                } else {
                    $model->kdProviderPeserta = '';
                    if (isset($jsonval->response)) {
                        Yii::$app->session->setFlash('danger', json_encode($jsonval->response)   );
                    } else {
                        Yii::$app->session->setFlash('danger', 'cek peserta failed 2'   );
                    }

//            return 'cek peserta failed';
                }

            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

//        $pcarevisit = PcareVisit::findOne(['pendaftaranId' => $model->id]);
        return $this->render('update', [
            'model' => $model,
            'visitmodel' => $model->pcareVisits[0]
        ]);
    }

    /**
     * Deletes an existing PcareRegistration model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PcareRegistration model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PcareRegistration the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PcareRegistration::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionCheckpeserta($id)
    {
        $registration = PcareRegistration::findOne($id);
        $response = $registration->Cekpeserta();

        $jsonval = json_decode($response);

        if ($jsonval->metaData->code == 200) {
            if ($jsonval->response->aktif)
            {

                $registration->kdProviderPeserta = $jsonval->response->kdProviderPst->kdProvider;
                $registration->status = 'ready';
                $registration->save();
                Yii::$app->session->addFlash('success', "Peserta aktif");


            } else {
                Yii::$app->session->setFlash('danger', "nomor peserta tidak aktif");

            }
        } else {
            Yii::$app->session->setFlash('danger', "cek peserta failed");
        }
        Yii::$app->user->returnUrl = Yii::$app->request->referrer;
        return $this->goBack();

    }

    public function actionRegister($id)
    {
        $registration = PcareRegistration::findOne($id);
//        $registration->setWdId('wdid2');
        $response = $registration->Cekpeserta();

        $jsonval = json_decode($response);

        if ($jsonval->metaData->code == 200) {
            if ($jsonval->response->aktif)
            {
                $registration->kdProviderPeserta = $jsonval->response->kdProviderPst->kdProvider;


                //check if status has been modified

                $registerresp = $registration->register($id); //actual register to pcare
                $jsonresp = json_decode($registerresp);

//                if (isset($jsonresp->metaData->message) && ($jsonresp->metaData->message == 'CREATED')) {
                if (isset($jsonresp->metaData->message))
                {
                    if($jsonresp->metaData->message == 'CREATED') {
                        if(strpos($jsonresp->response->message, "null") ) {
                            Yii::$app->session->setFlash('danger', $registerresp);
                        } else {
                            $registration->no_urut = $jsonresp->response->message;
                            $registration->status = 'registered';
                            Yii::$app->session->setFlash('success', 'no urut created ' . $jsonresp->response->message);
                        }
                        $registration->save();
                    } else {
                        Yii::$app->session->setFlash('danger', $registerresp);

                    }

                } else {
                    Yii::$app->session->setFlash('danger', json_encode($jsonresp));
                }






            } else {
                Yii::$app->session->setFlash('danger', 'peserta tidak valid');
            }
        } else {
            Yii::$app->session->setFlash('danger', 'cek peserta failed');
        }


        //echo ' validate';
        Yii::$app->user->returnUrl = Yii::$app->request->referrer;
        return $this->goBack();
    }


public function populateVisitdata($responsedata)
{
    $visitmodel = new PcareVisit();
//    $visitmodel->kdt
    $visitmodel->noKunjungan = $responsedata->noKunjungan;
    $visitmodel->sistole = $responsedata->sistole;
    $visitmodel->diastole = $responsedata->diastole;
    $visitmodel->beratBadan = $responsedata->beratBadan;
    $visitmodel->tinggiBadan = $responsedata->tinggiBadan;
    $visitmodel->respRate = $responsedata->respRate;
    $visitmodel->heartRate = $responsedata->heartRate;
    $visitmodel->kdStatusPulang = $responsedata->statusPulang->kdStatusPulang;
    $visitmodel->tglPulang = date("Y-m-d" , strtotime($responsedata->tglPulang));
    $visitmodel->keluhan = $responsedata->keluhan;
    $visitmodel->kdDokter = $responsedata->dokter->kdDokter;
    $visitmodel->kdSadar = $responsedata->kesadaran->kdSadar;
    $visitmodel->kdDiag1 = $responsedata->diagnosa1->kdDiag;
    $visitmodel->kdDiag2 = $responsedata->diagnosa2->kdDiag;
    $visitmodel->kdDiag3 = $responsedata->diagnosa3->kdDiag;
    $visitmodel->nmDiag1 = $responsedata->diagnosa1->nmDiag;
    $visitmodel->nmDiag2 = $responsedata->diagnosa2->nmDiag;
    $visitmodel->nmDiag3 = $responsedata->diagnosa3->nmDiag;
    $visitmodel->terapi = $responsedata->catatan;
    $visitmodel->tglEstRujuk = date("Y-m-d" , strtotime($responsedata->tglEstRujuk));
    $visitmodel->subSpesialis_kdSpesialis = $responsedata->poliRujukLanjut->kdPoli;
    $visitmodel->subSpesialis_nmSpesialis = $responsedata->poliRujukLanjut->nmPoli;
    $visitmodel->kdppk = $responsedata->providerRujukLanjut->kdProvider;
    $visitmodel->nmppk = $responsedata->providerRujukLanjut->nmProvider;
    $visitmodel->kdppk_subSpesialis = $responsedata->providerRujukLanjut->kdProvider;
    $visitmodel->kdppk_khusus = $responsedata->providerRujukLanjut->kdProvider;
    $visitmodel->nmppk_khusus = $responsedata->providerRujukLanjut->nmProvider;
    $visitmodel->nmppk_subSpesialis = $responsedata->providerRujukLanjut->nmProvider;

    return $visitmodel;
}

    public function populateRegistrationdata($responsedata)
    {
        $model = new PcareRegistration();
        $model->noKartu = $responsedata->peserta->noKartu;
        $model->tglDaftar =  date("Y-m-d" , strtotime($responsedata->tglKunjungan));
        $model->kdTkp = $responsedata->tkp->kdTkp;

        return $model;
    }

public function actionUpdaterujukan($consid,$noKartu,$date, $kdPoli) {

}
    public function actionPrintrujukan($consid,$noKartu,$date, $kdPoli) {
        $response =Yii::$app->pcareComponent->pcareRiwayatkunjungan($noKartu, $consid);
        $content = json_decode($response);


        $visitdata = null;
        $visitpayload = '';
        $model = new PcareRegistration();
        $wdmodel = new WdPassedValues();
        $pcarevisit = new PcareVisit();
        $refStatuspulang = [];
        $kunjungans = $content->response->list;
        foreach ($kunjungans as $kunjungan)
        {
            if (($kdPoli == $kunjungan->poli->kdPoli) && ($date == $kunjungan->tglKunjungan))
            {
                $visitdata = $kunjungan;
            }
        }
        $model = $this->populateRegistrationdata($visitdata);
        $model->cons_id = $consid;
        $pcarevisit = $this->populateVisitdata( $visitdata);

        $rujukan = Yii::$app->pcareComponent->getRujukan($consid,$pcarevisit->noKunjungan);
        $rujukanObj = json_decode($rujukan);
//echo '<pre>';
//        print_r($pcarevisit);
//        print_r($rujukanObj);
//        echo '</pre>';

        if (isset($rujukanObj->response->ppk)) {
            return $this->render('printrujukan', [
                'rujukanObj' => $rujukanObj,
                'visitModel' => $pcarevisit,
            ]);
        } else {
            return 'TIdak ada rujukan';
        }


    }
    public function actionUpdatekunjungan($consid,$noKartu,$date, $kdPoli) {
        $response =Yii::$app->pcareComponent->pcareRiwayatkunjungan($noKartu, $consid);
        $content = json_decode($response);
//        echo '<pre>';
//        print_r($content->response);
//        echo '</pre>';

        $visitdata = null;
        $visitpayload = '';
        $model = new PcareRegistration();
        $wdmodel = new WdPassedValues();
        $pcarevisit = new PcareVisit();
        $refStatuspulang = [];
        $kunjungans = $content->response->list;
        foreach ($kunjungans as $kunjungan)
        {
            if (($kdPoli == $kunjungan->poli->kdPoli) && ($date == $kunjungan->tglKunjungan))
            {
                $visitdata = $kunjungan;
            }
        }

        $kdPpk= $visitdata->providerRujukLanjut->kdProvider;
        $model = $this->populateRegistrationdata($visitdata);
        $model->cons_id = $consid;
        $pcarevisit = $this->populateVisitdata( $visitdata);
        $listData2 = Yii::$app->pcareComponent->getListDoctor($consid);
        $refKesadaran = Yii::$app->pcareComponent->getListKesadaran($consid);
        $refSpesialis = Yii::$app->pcareComponent->getReferensiSpesialis($model->cons_id);
        $refKhususdata = Yii::$app->pcareComponent->getReferensiKhusus($model->cons_id);
        if(isset($_POST['cek'])) {
            Yii::$app->session->addFlash('success', "CHECK NIK");
        }
        if(isset($_POST['update'])) {
//            Yii::$app->session->addFlash('success', "POST UPDATE");
            $khususpayload = "null";
            $spesialispayload = "null";
            $kdKhusus_subspesialis = "null";

            $model->load(Yii::$app->request->post());
            $pcarevisit->load(Yii::$app->request->post());

            if ($pcarevisit->spesialis_type == 'spesialis') {
                $kdPpk = $pcarevisit->kdppk_subSpesialis;

                $spesialispayload = '{
            "kdSubSpesialis1": "'.$pcarevisit->subSpesialis_kdSubSpesialis1.'",
      "kdSarana": "'.$pcarevisit->subSpesialis_kdSarana.'"
    }';
            } else if ($pcarevisit->spesialis_type == 'khusus') {
                Yii::$app->session->addFlash('success', "masuk khusus");

                Yii::$app->session->addFlash('success', "kd khusus : " . $pcarevisit->khusus_kdKhusus );
                if ($pcarevisit->khusus_kdKhusus == 'HEM') {
                    $kdKhusus_subspesialis = $pcarevisit->khusus_kdSubSpesialis;
                    $kdPpk = $pcarevisit->kdppk_khusus;
                } else if ($pcarevisit->khusus_kdKhusus == 'THA') {
                    $kdKhusus_subspesialis = $pcarevisit->khusus_kdSubSpesialis;
                    $kdPpk = $pcarevisit->kdppk_khusus;
                } else {
                    $kdPpk = $pcarevisit->kdppk;
                }
                $khususpayload = '{
        "kdKhusus": "'.$pcarevisit->khusus_kdKhusus.'",
      "kdSubSpesialis": '.$kdKhusus_subspesialis.',
      "catatan": "peserta sudah biasa hemodialisa"
    }';
            }
            $rujukpayload = '{
        "tglEstRujuk": "'.date("d-m-Y" , strtotime($pcarevisit->tglEstRujuk)).'",
         "kdppk": "'.$kdPpk.'",
                 "subSpesialis": '.$spesialispayload.',
                 "khusus" :' . $khususpayload .'}';

            $visitpayload = '{
            "noKunjungan": "'.$pcarevisit->noKunjungan.'",
        "tglDaftar": "'.date("Y-d-m" , strtotime($model->tglDaftar)).'", 
        "noKartu": "'.$model->noKartu.'",
        "kdPoli": "'.$model->kdPoli.'",
        "keluhan": "'.$pcarevisit->keluhan.'",
          "kdSadar": "'.$pcarevisit->kdSadar.'",
                    "kdStatusPulang": "'.$pcarevisit->kdStatusPulang.'",
                            "tglPulang": "'.date("d-m-Y" , strtotime($pcarevisit->tglPulang)).'",
                              "kdDokter": "'.$pcarevisit->kdDokter.'",
                                        "kdDiag1": "'.$pcarevisit->kdDiag1.'",
                                          "kdDiag2": "'.$pcarevisit->kdDiag2.'",
                                            "kdDiag3": "'.$pcarevisit->kdDiag3.'",
                                              "terapi": "'.$pcarevisit->terapi.'",
          "sistole": "'.$pcarevisit->sistole.'",
        "diastole": "'.$pcarevisit->diastole.'",
        "beratBadan": "'.$pcarevisit->beratBadan.'",
        "tinggiBadan": "'.$pcarevisit->tinggiBadan.'",
        "respRate": "'.$pcarevisit->respRate.'",
        "heartRate": "'.$pcarevisit->heartRate.'",
        "rujukLanjut" : '. $rujukpayload . '}';



            $updatekunjunganresponse = Yii::$app->pcareComponent->pcareUpdatekunjungan($visitpayload, $model->cons_id);
            Yii::$app->session->addFlash('success', "UPDATE : " . $updatekunjunganresponse);
        }




        return $this->render('updatekunjungan', [
            'model' => $model,
            'visitmodel' => $pcarevisit,
            'wdmodel' => $wdmodel,
//            'prescribed_list' => $prescribedlist,
            'listData2' => $listData2,
            'refKesadaran' => $refKesadaran,
            'refStatuspulang' => $refStatuspulang,
            'refSpesialis' => $refSpesialis,
            'refKhususdata' => $refKhususdata,
            'consid' => $consid,
            'payload' => $visitpayload

        ]);


    }




    public function actionRegistrationbydate($consid)
{
    $registration = new PcareRegistration();
$date = '';
$provider = new ArrayDataProvider();
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $response =Yii::$app->pcareComponent->getPendaftaranprovider($post['tanggal'], $consid);
            $date = $post['tanggal'];

//if( $response->getIsOk()) {
    if( $response->getStatusCode() == '200') {
    $content = json_decode($response->content);

    if ($content->response !== null) {
            $provider = new ArrayDataProvider([
        'allModels' => $content->response->list,
        'pagination' => [
            'pageSize' => 10,
        ],
        'sort' => [
//                'attributes' => ['id', 'name'],
        ],
    ]);
    }

} else {
    Yii::$app->session->setFlash('danger', $response->getStatusCode());
};
        }

            return $this->render('regbydate', [
                'dataProvider' => $provider,
                'date' => $date

            ]);

}


    public function __construct(string $id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function getPoli($consid, $issakit) /** MAU DIPINDAH ke component */
    {
//        $registration = PcareRegistration::findOne($id);
        $registration = new PcareRegistration();
        $registration->setConsId($consid);
        $response = $registration->getPoli();

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

    public function actionPoli($id)
    {
        $registration = PcareRegistration::findOne($id);
        $response = $registration->getPoli();

        $jsonval = json_decode($response);
        $options = [];
        foreach ($jsonval->response->list as $i)
        {
            $options[$i->kdPoli] = $i->kdPoli . ' : ' . $i->nmPoli;
        }

//        return $options;
        echo '<pre>';
        print_r($options);
    }

    public function actionPoli2($id)
    {
        $registration = new PcareRegistration();
        $response = $registration->getPolicodesarray($id);

        $jsonval = json_decode($response);
        $options = [];
        foreach ($jsonval->response->list as $i)
        {
            $options[$i->kdPoli] = $i->kdPoli . ' : ' . $i->nmPoli;
        }

//        return $options;
        echo '<pre>';
        print_r($options);
    }




    public function actionVerify($wdid, $noKartu, $nik)
    {
$success = 0;
$success2 = 0;
$nikflag = 0;
        $this->layout = '@app/views/layouts/verify';
//        $noKartu ='';
//        $nik='';
        $clinic = Consid::find()->andWHere(['wd_id' => $wdid])->One();
        $model = ['noKartu'=>'',
            'nik' =>'',
            'nama' => '',
            'sex'=>'',
            'noKTP' =>'',
            'jnsKelas_nama'=>'',
            'jnsKelas_kode' =>'',
            'jnsPeserta_nama' => '',
            'jnsPeserta_kode' => '',
            'providerPeserta_kode' => '',
            'providerPeserta_nama' => ''

            ];



 if ($_REQUEST) {

     $pcareregistrationmodel = new PcareRegistration();
     $bpjs_user = $pcareregistrationmodel->getUsercreds($clinic->cons_id);
     $noKartu =$_REQUEST['noKartu'];
     $nik=$_REQUEST['nik'];
     if (!empty($_REQUEST['noKartu'])) {
         $model['noKartu'] = $_REQUEST['noKartu'];
         try {

             $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/peserta/' . $_REQUEST['noKartu']]);
             $request = $client->createRequest()
                 ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                 ->addHeaders(['content-type' => 'application/json'])
                 ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                 ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                 ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

             $response = $request->send();
             $success = 1;
//             Yii::$app->session->addFlash('success',$response->getStatusCode());
//             return $response->content;
         } catch (\yii\base\Exception $exception) {

             Yii::$app->session->addFlash('danger',"No Kartu - ERROR GETTING RESPONSE FROM BPJS.");
         }
     }

     if (!empty($_REQUEST['nik'])){
         $model['nik'] = $_REQUEST['nik'];
         try {

             $client2 = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/peserta/nik/' . $_REQUEST['nik']]);
             $request2 = $client2->createRequest()
                 ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                 ->addHeaders(['content-type' => 'application/json'])
                 ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                 ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                 ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

             $response2 = $request2->send();
             $success2 = 1;
//                 Yii::$app->session->addFlash('success',"ADA NIK " . $response->getStatusCode());
//             return $response->content;
         } catch (\yii\base\Exception $exception) {

             Yii::$app->session->addFlash('danger',"NIK - ERROR GETTING RESPONSE FROM BPJS.");
         }

     }


     if (($success == 1) && ($nikflag ==0)) {
        $jsonresponse = json_decode($response->content);
        (isset($jsonresponse->response->nama))? $model['nama'] = $jsonresponse->response->nama :'';
        (isset($jsonresponse->response->hubunganKeluarga))? $model['hubunganKeluarga'] = $jsonresponse->response->hubunganKeluarga : $model['hubunganKeluarga']='';
        (isset($jsonresponse->response->noKTP))? $model['noKTP'] = $jsonresponse->response->noKTP : $model['noKTP']='';
         (isset($jsonresponse->response->noKartu))? $model['noKartu'] = $jsonresponse->response->noKartu : $model['noKartu']='';
        (isset($jsonresponse->response->sex))? $model['sex'] = $jsonresponse->response->sex : $model['sex'] = '';
        (isset($jsonresponse->response->tglLahir))? $model['tglLahir'] = $jsonresponse->response->tglLahir : $model['tglLahir'] = '';
        (isset($jsonresponse->response->tglMulaiAktif))? $model['tglMulaiAktif'] = $jsonresponse->response->tglMulaiAktif : $model['tglMulaiAktif'] = '';

        (isset($jsonresponse->response->tglAkhirBerlaku))? $model['tglAkhirBerlaku'] = $jsonresponse->response->tglAkhirBerlaku : $model['tglAkhirBerlaku'] = '';
        (isset($jsonresponse->response->golDarah))? $model['golDarah'] = $jsonresponse->response->golDarah : $model['golDarah'] = '';
        (isset($jsonresponse->response->noHP))? $model['noHP'] = $jsonresponse->response->noHP : $model['noHP'] = '';

        (isset($jsonresponse->response->jnsKelas->nama))? $model['jnsKelas_nama'] = $jsonresponse->response->jnsKelas->nama : $model['jnsKelas_nama'] = '';
        (isset($jsonresponse->response->jnsKelas->kode))? $model['jnsKelas_kode'] = $jsonresponse->response->jnsKelas->kode : $model['jnsKelas_kode'] = '';

        (isset($jsonresponse->response->jnsPeserta->nama))? $model['jnsPeserta_nama'] = $jsonresponse->response->jnsPeserta->nama : $model['jnsPeserta_nama'] = '';
        (isset($jsonresponse->response->jnsPeserta->kode))? $model['jnsPeserta_kode'] = $jsonresponse->response->jnsPeserta->kode : $model['jnsPeserta_kode'] = '';

        (isset($jsonresponse->response->kdProviderPst->kdProvider))? $model['providerPeserta_kode'] = $jsonresponse->response->kdProviderPst->kdProvider : $model['providerPeserta_kode'] = '';
        (isset($jsonresponse->response->kdProviderPst->nmProvider))? $model['providerPeserta_nama'] = $jsonresponse->response->kdProviderPst->nmProvider : $model['providerPeserta_nama'] = '';


        (isset($jsonresponse->response->aktif))? $model['aktif'] = $jsonresponse->response->aktif : $model['aktif'] = '';
        (isset($jsonresponse->response->ketAktif))? $model['ketAktif'] = $jsonresponse->response->ketAktif : $model['ketAktif'] = '';


        if(strtolower($model['aktif']) == '1') {
                    Yii::$app->session->addFlash('success', $model['ketAktif']);
        } else {
            if($nikflag == 0) {
//                Yii::$app->session->addFlash('danger', 'no kartu ' . $model['ketAktif'] . '. coba dengan NIK');
                $nikflag = 1;
            }

        }

    }

     if (($nikflag == 1) && (empty($_REQUEST['nik']) ))
     {

Yii::$app->session->addFlash('danger', 'no kartu ' . $model['ketAktif'] . '. coba dengan NIK');

     }

    if (($success2 == 1) && ($nikflag ==1)) {
        $jsonresponse = json_decode($response2->content);
        (isset($jsonresponse->response->nama))? $model['nama'] = $jsonresponse->response->nama :'';
        (isset($jsonresponse->response->hubunganKeluarga))? $model['hubunganKeluarga'] = $jsonresponse->response->hubunganKeluarga : $model['hubunganKeluarga']='';
        (isset($jsonresponse->response->noKTP))? $model['noKTP'] = $jsonresponse->response->noKTP : $model['noKTP']='';
        (isset($jsonresponse->response->noKartu))? $model['noKartu'] = $jsonresponse->response->noKartu : $model['noKartu']='';
        (isset($jsonresponse->response->sex))? $model['sex'] = $jsonresponse->response->sex : $model['sex'] = '';
        (isset($jsonresponse->response->tglLahir))? $model['tglLahir'] = $jsonresponse->response->tglLahir : $model['tglLahir'] = '';
        (isset($jsonresponse->response->tglMulaiAktif))? $model['tglMulaiAktif'] = $jsonresponse->response->tglMulaiAktif : $model['tglMulaiAktif'] = '';

        (isset($jsonresponse->response->tglAkhirBerlaku))? $model['tglAkhirBerlaku'] = $jsonresponse->response->tglAkhirBerlaku : $model['tglAkhirBerlaku'] = '';
        (isset($jsonresponse->response->golDarah))? $model['golDarah'] = $jsonresponse->response->golDarah : $model['golDarah'] = '';
        (isset($jsonresponse->response->noHP))? $model['noHP'] = $jsonresponse->response->noHP : $model['noHP'] = '';

        (isset($jsonresponse->response->jnsKelas->nama))? $model['jnsKelas_nama'] = $jsonresponse->response->jnsKelas->nama : $model['jnsKelas_nama'] = '';
        (isset($jsonresponse->response->jnsKelas->kode))? $model['jnsKelas_kode'] = $jsonresponse->response->jnsKelas->kode : $model['jnsKelas_kode'] = '';

        (isset($jsonresponse->response->jnsPeserta->nama))? $model['jnsPeserta_nama'] = $jsonresponse->response->jnsPeserta->nama : $model['jnsPeserta_nama'] = '';
        (isset($jsonresponse->response->jnsPeserta->kode))? $model['jnsPeserta_kode'] = $jsonresponse->response->jnsPeserta->kode : $model['jnsPeserta_kode'] = '';

        (isset($jsonresponse->response->kdProviderPst->kdProvider))? $model['providerPeserta_kode'] = $jsonresponse->response->kdProviderPst->kdProvider : $model['providerPeserta_kode'] = '';
        (isset($jsonresponse->response->kdProviderPst->nmProvider))? $model['providerPeserta_nama'] = $jsonresponse->response->kdProviderPst->nmProvider : $model['providerPeserta_nama'] = '';

        (isset($jsonresponse->response->aktif))? $model['aktif'] = $jsonresponse->response->aktif : $model['aktif'] = '';
        (isset($jsonresponse->response->ketAktif))? $model['ketAktif'] = $jsonresponse->response->ketAktif : $model['ketAktif'] = '';


        if(strtolower($model['aktif']) == '1') {
            Yii::$app->session->addFlash('success', $model['ketAktif']);
        } else {

                Yii::$app->session->addFlash('danger', 'NIK ' . $model['ketAktif'] . '. coba ulang');



        }
    }
 }

        return $this->render('verify', [
            'model' => $model,
            'noKartu' => $noKartu,
            'nik' => $nik,
            'nikflag' => $nikflag
        ]);


    }


    public function actionGetstatuspulang($consid)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $options = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];

                $registration = new PcareRegistration();
                $response =Yii::$app->pcareComponent->getStatuspulang2($consid, $parents[0]);
//
                $jsonval = json_decode($response);

                foreach ($jsonval->response->list as $i)
                {
                    array_push($options, ['id'=>$i->kdStatusPulang, 'name'=>$i->nmStatusPulang]);
                }
                return ['output'=>$options, 'selected'=>''];
            }
            return ['output'=>$options, 'selected'=>''];
        }
        return ['output'=>$options, 'selected'=>''];





    }


    public function actionGetpolicodes()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $options = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];

                $registration = new PcareRegistration();
                $response = $registration->getPolicodesarray($cat_id);
//
                $jsonval = json_decode($response);

                foreach ($jsonval->response->list as $i)
                {
                    array_push($options, ['id'=>$i->kdPoli, 'name'=>$i->kdPoli . ' ' . $i->nmPoli]);
                }
                return ['output'=>$options, 'selected'=>''];
            }
            return ['output'=>$options, 'selected'=>''];
        }
        return ['output'=>$options, 'selected'=>''];

    }

    public function actionGetfilteredpolicodes($consid)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $options = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $response =Yii::$app->pcareComponent->getListPoli($consid, $parents[0]);
                foreach ($response as $i)
                {
//                echo $i;
                    $explode = explode(':', $i);
                    array_push($options, ['id'=>$explode[0], 'name'=>$explode[1]]);
                }
                return ['output'=>$options, 'selected'=>''];
            }
//            return ['output'=>$options, 'selected'=>''];
        } else {

            $response =Yii::$app->pcareComponent->getListPoli($consid);
            foreach ($response as $i)
            {
//                echo $i;
                $explode = explode(':', $i);
                array_push($options, ['id'=>$explode[0], 'name'=>$explode[1]]);
            }
            return ['output'=>$options, 'selected'=>''];
//            return $response;
        }
//        return ['output'=>$options, 'selected'=>''];

    }

public function actionTest()
{
    $response = Yii::$app->pcareComponent->getStatuspulang2('10', '4566');
    print_r($response);
}







    public function actionDiagnosecode($q = null, $consid)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'text' => '']]];
        if (!is_null($q)) {

//            $registration = new PcareRegistration();
//            $registration->setConsId($id);

            $response = Yii::$app->pcareComponent->getDiagnosecodes($q, $consid);

            $jsonval = json_decode($response);
            if (isset($jsonval->response)) {

                foreach ($jsonval->response->list as $item) {
                    $temp = ['id' => $item->kdDiag, 'text' => $item->nmDiag, 'nonspesialis' => var_export($item->nonSpesialis, true)];
                    array_push($out['results'], $temp);
                }
                array_shift($out['results']);

            } else {
                Yii::$app->session->addFlash('danger', 'get diagnose code - no pcare web service response');
            }

        } else {

        }

        return $out;

    }


    public function actionPrintrujukbalik($id)
    {
        $registration = PcareRegistration::findOne($id);
        $visit = $registration->pcareVisits[0];

        $doctors = $registration->getDokter();
        $pesertaresp = $registration->Cekpeserta();
        $dokters = json_decode($doctors)->response->list;
        $dokter = [];
        foreach ($dokters as $dokter1) {
            if ($dokter1->kdDokter == $visit->kdDokter) {
                $dokter =  $dokter1;
            }
        }

        $peserta = json_decode($pesertaresp)->response;
        return $this->render('rujukbalik', [
//            'dataProvider' => $provider
            'visitModel' => $visit,
            'dokter' => $dokter,
            'peserta' => $peserta
        ]);
    }
    public function actionPrintpdf($id)
    {

$registration = PcareRegistration::findOne($id);
$visit = $registration->pcareVisits[0];

        $doctors = $registration->getDokter();
        $pesertaresp = $registration->cekPesertaByNokartu();
        $dokters = json_decode($doctors)->response->list;
        $dokter = [];
        $clinicmodel = Consid::find()->andWhere(['cons_id' => $registration->cons_id])->One();
        $clinicinfo = ClinicInfo::findOne($clinicmodel->wd_id);
        foreach ($dokters as $dokter1) {
            if ($dokter1->kdDokter == $visit->kdDokter) {
                $dokter =  $dokter1;
            }
        }

        $peserta = json_decode($pesertaresp)->response;

        $rujukan = $visit->getRujukan($visit->noKunjungan);
$rujukanObj = json_decode($rujukan);
if ($rujukanObj->metaData->code == 200){
            return $this->render('testhtml', [
            'rujukanObj' => $rujukanObj,
        'visitModel' => $visit,
        ]);

}



    }

    public function actionProviders()
    {
        $registration = new PcareRegistration();
//        $registration->setConsId('16744');
        $response = $registration->Getprovider();
        $response_obj = json_decode($response);


$array=[];
        foreach($response_obj->response->list as $provider) {
            array_push($array,['kdProvider' => $provider->kdProvider, 'nmProvider'=> $provider->nmProvider]);
        }

//
//        echo '<pre>';
//        print_r($array);


        $provider = new ArrayDataProvider([
            'allModels' => $array,
            'pagination' => [
                'pageSize' => 99,
            ],
            'sort' => [
                'attributes' => ['kdProvider', 'nmProvider'],
            ],
        ]);

        return $this->render('providers', [
            'dataProvider' => $provider
        ]);
    }
    public function actionTestpost()
{

        $payload = 'clinicId=59cedfba9ae80d05757f54e9.59cedfba9ae80d05757f54e7&kdPoli=&kdTkp=&tglDaftar=2021-10-07' .
            '&visitId=12345' .
            '&noKartu=0001113569638&kunjSakit=true' .
            '&kdProviderPeserta=' .
            '&no_urut=' .
        '&keluhan=keluhan dari kode' .
        '&sistole=77' .
        '&diastole=77' .
        '&beratBadan=77' .
        '&tinggiBadan=77' .
        '&respRate=77' .
        '&heartRate=77' .
            '&doctor=nama dokter' .
            '&disposition=' .
            '&statusAssesment=' .
            '&administered=' .
            '&prescribed=["Parasetamol 500 mg, #18 -  3 x 2 tablet - 3 Days","Azithromycin 250 mg, #9 - Tablet 3 x 1 tablet - 3 Days","Captopril 12.5 mg, #29 -  1 x 0.96 tablet - 30 Days"]' .
            '&manualDiagnoses=[{"treatment":"captoril","description":"hypertension"}]' .
            '&checklistNames=["Upper respiratory tract infection [URI] / Common Cold (J06.9)"]';

    try {

        $client = new Client(['baseUrl' => 'http://localhost/walkingdocs/web/index.php/pcare/registration/create']);
        $request = $client->createRequest()
            ->setContent($payload)
            ->setMethod('POST')
            ->addHeaders(['content-type' => 'application/x-www-form-urlencoded'])
        ;
        $response = $request->send();
        ob_start();
        ob_clean();

        echo $response->content;

    } catch (\yii\base\Exception $exception) {
print_r($exception);
        Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");

    }

}

public function actionAntrean()
{


    $userId = Yii::$app->user->identity->getId();
    $clinics = ClinicUser::find()->andWhere(['userId' => $userId])->All();
    $clinics_array = ArrayHelper::getColumn($clinics, 'clinicId');

    $query = Antrean::find()->andWhere(['in', 'clinicId', $clinics_array]);

    $provider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 100,
        ],
        'sort' => [
            'defaultOrder' => [
//                'created_at' => SORT_DESC,
//                'title' => SORT_ASC,
            ]
        ],
    ]);

    return $this->render('antrean', [
        'dataProvider' => $provider
    ]);
}

    public function actionSubspesialis($consid)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'name' => '']]];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $keyword = $parents[0];


                $out = Yii::$app->pcareComponent->getReferensiSubspesialis($consid,$keyword);


                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    public function actionRujukankhusus2($consid,$nokartu)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'name' => '']]];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $kdkhusus = $parents[0];
                $kdsubspesialis = empty($parents[1]) ? null : $parents[1];
                $tglrujuk = empty($parents[2]) ? null : $parents[2];

//                $out = ['results' => [['id' => $kdkhusus, 'name' => $tglrujuk, 'sarana' => $kdsubspesialis]]];



                $response = Yii::$app->pcareComponent->getRujukanKhusus2($consid,$kdkhusus, $kdsubspesialis, $tglrujuk, $nokartu);

                $jsonval = json_decode($response);
                if (isset($jsonval->response)) {

                    if (isset($jsonval->response->count)) {
                        foreach ($jsonval->response->list as $item) {
                            $temp = ['id' => $item->kdppk, 'name' => $item->nmppk, 'alamatPpk' => $item->alamatPpk, 'jadwal' => $item->jadwal, 'nmkc' => $item->nmkc];
                            array_push($out['results'], $temp);
                        }
                    } else {
                        $temp = ['id' => '0', 'name' => $jsonval->response];
                        array_push($out['results'], $temp);
//                        return ['output'=>$out, 'selected'=>''];
                    }

                    array_shift($out['results']);
                }

                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>$out, 'selected'=>''];
    }

    public function actionRujukankhusus1($consid,$nokartu)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'name' => '']]];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $kdkhusus = $parents[0];
//                $kdsubspesialis = empty($parents[1]) ? null : $parents[1];
                $tglrujuk = empty($parents[1]) ? null : $parents[1];



                $response = Yii::$app->pcareComponent->getRujukanKhusus1($consid,$kdkhusus, $tglrujuk, $nokartu);

                $jsonval = json_decode($response);
                if (isset($jsonval->response)) {

                    if (isset($jsonval->response->count)) {
                        foreach ($jsonval->response->list as $item) {
                            $temp = ['id' => $item->kdppk, 'name' => $item->nmppk, 'alamatPpk' => $item->alamatPpk, 'jadwal' => $item->jadwal, 'nmkc' => $item->nmkc];
                            array_push($out['results'], $temp);
                        }
                    } else {
//                        $temp = ['id'=>'0','name'=>$jsonval->response];
//                        array_push($out['results'], $temp);
//                        return ['output'=>$out, 'selected'=>''];
                        $temp = ['id' => '0', 'name' => $jsonval->response];
                        array_push($out['results'], $temp);
//                        return ['output'=>$out, 'selected'=>''];
                    }

                    array_shift($out['results']);
                }

                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>$out, 'selected'=>''];
    }

    public function actionSubspesialiskdsarana($consid)
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'name' => '']]];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $keyword = $parents[0];



                $response = Yii::$app->pcareComponent->getSarana($consid);

                $jsonval = json_decode($response);
                if (isset($jsonval->response)) {

                    foreach ($jsonval->response->list as $item) {
                        $temp = ['id' => $item->kdSarana, 'name' => $item->nmSarana];
                        array_push($out['results'], $temp);
                    }
                    array_shift($out['results']);
                } else {
                    Yii::$app->session->addFlash('danger', 'get subspesialis kd sarana - no pcare web service response');
                }


//                // the getSubCatList function will query the database based on the
//                // cat_id and return an array like below:
//                // [
//                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
//                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
//                // ]
                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];


    }


    public function beforeAction($action)
    {

        $bpjs_user = Yii::$app->pcareComponent->getUsercreds('4566');
        try {

            $client = new Client(['baseUrl' => self::BASE_API_URL  . '/spesialis']);
            $request = $client->createRequest()
                ->setOptions([
                    CURLOPT_CONNECTTIMEOUT => 3, // connection timeout
                    CURLOPT_TIMEOUT => 6, // data receiving timeout
                ])

                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

            $response = $request->send();
            return true;
//            return $response->content;
        } catch (\yii\base\Exception $exception) {

            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
//            echo "error getting response from BPJS";
            echo $this->render('error', [
            ]);
            return false;
        }


//        if ($action->id == 'index' && Yii::$app->request->referrer !== null) {
//            Yii::$app->session->set('returnUrl', Yii::$app->request->referrer);
//        }

        return true;
//        return parent::beforeAction($action);
    }



    public function actionRujukanspesialis($consid)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'name' => '']]];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $keyword = $parents[0];
                $sarana = empty($parents[1]) ? null : $parents[1];
                $tglrujuk = empty($parents[2]) ? null : $parents[2];

//                $out = ['results' => [['id' => $keyword, 'name' => $tglrujuk, 'sarana' => $sarana]]];


                $response = Yii::$app->pcareComponent->getRujukanSpesialis($consid, $keyword, $sarana, $tglrujuk);

                $jsonval = json_decode($response);
                if (isset($jsonval->response)) {

                    foreach ($jsonval->response->list as $item) {
                        $temp = ['id' => $item->kdppk, 'name' => $item->nmppk . ' alamat : ' . $item->alamatPpk . ', ' . $item->nmkc, 'alamatPpk' => $item->alamatPpk, 'telpPpk' => $item->telpPpk,
                            'kelas' => $item->kelas,'nmkc' => $item->nmkc, 'distance' => $item->distance, 'jadwal' => $item->jadwal,
                            'jmlRujuk' => $item->jmlRujuk, 'kapasitas' => $item->kapasitas, 'persentase' => $item->persentase

                        ];
                        array_push($out['results'], $temp);
                    }
                    array_shift($out['results']);
                } else {
                    $temp = ['id' => '0', 'name' => 'ga ada'];
                    array_push($out['results'], $temp);
                    array_shift($out['results']);
                }

                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>$out, 'selected'=>''];
    }



}
