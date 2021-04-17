<?php

namespace app\controllers\pcare;


use app\models\Consid;
use app\models\pcare\PcareVisit;
use app\models\pcare\WdPassedValues;
use Yii;
use app\models\pcare\PcareRegistration;
use app\models\pcare\PcareRegistrationSearch;
use yii\base\Module;

use yii\data\ArrayDataProvider;
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



    /**
     * Creates a new PcareRegistration model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = '@app/views/layouts/popuplayout';
        $model = new PcareRegistration();

        $pcarevisit = new PcareVisit();
        $pcarevisit->kdSadar = "01";
        $prescribed = '';
        $wdmodel = new WdPassedValues();
        $request = Yii::$app->request;
        $params = $request->bodyParams;
        $draftexist = 0;
        $cookies = Yii::$app->request->cookies;
        if (isset($params['visitId'])) {
            $cookiesresp = Yii::$app->response->cookies;
            $cookiesresp->add(new \yii\web\Cookie(
                [
                    'name' => 'visitId',
                    'value' => $params['visitId'],
                ]        ));

            $wdmodel->wdVisitId = $params['visitId'];
            $wdmodel->clinicId = $params['clinicId'];

            $wdmodel_exist = WdPassedValues::find()->andWhere(['wdVisitId' => $wdmodel->wdVisitId])->andWhere(['clinicId' => $wdmodel->clinicId])
//                ->andWhere(['status'=>'registered'])
                ->One();
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
//                        Yii::$app->session->addFlash('success', "draft EXSITED");
                        $wdmodel_exist->delete();

                    }
                }
//                Yii::$app->session->addFlash('warning', "EXISTED");
            } else {
                Yii::$app->session->addFlash('success', "NO model EXSITED 2");
            }


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
            $prescribed = substr($params['prescribed'],2, (strlen($params['prescribed']) - 4));
            $pcarevisit->terapi = str_replace('","', "\n",$prescribed);
//            $pcarevisit->terapi = html_entity_decode($prescribed);

            $wdmodel->disposition = $params['disposition'];
            $wdmodel->statusAssessment = $params['statusAssesment'];
            $wdmodel->status = "draft";
            if ($draftexist) {
                $wdmodel_exist->delete();
                                Yii::$app->session->addFlash('warning', "deleted");
            }
            $wdmodel->save();
        } else {
            if (isset($cookies['visitId'])) {
                $cookie_visitid = $cookies['visitId']->value;
                $wdmodel = WdPassedValues::find()->andWhere(['wdVisitId' => $cookie_visitid])->One();
//                Yii::$app->session->addFlash('warning', $wdmodel_exist->sistole);

            } else {
                Yii::$app->session->addFlash('warning', 'no cookie - no visit id');
            }


        }


        $considmodel = Consid::find()->andWhere(['wd_id' => $wdmodel->clinicId])->One();
        if (isset($considmodel->cons_id)) {
            $model->cons_id = $considmodel->cons_id;
        } else {
            Yii::$app->session->addFlash('danger', "NO ConsID data!!!");
        }


        if ($model->load(Yii::$app->request->post())
//            && $model->save()
        ) {

            if (!empty($model->cons_id))
            {
                $response = $model->cekPesertaByNokartu();
                $jsonval = json_decode($response);

                if (isset($jsonval->metaData->code) && ($jsonval->metaData->code == 200)) {
                    if ($jsonval->response->aktif)
                    {

                        $model->kdProviderPeserta = $jsonval->response->kdProviderPst->kdProvider;
                        $model->status = 'ready';
                        Yii::$app->session->addFlash('success', "no Kartu - Peserta aktif  ");


                        $pcarevisit->status = 'new';
                        $pcarevisit->load(Yii::$app->request->post());


                        $wdmodel->load(Yii::$app->request->post());
                        $bpjs_user = $model->getUsercreds($model->cons_id);
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


                        try {

                            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/pendaftaran']);
                            $request = $client->createRequest()
                                ->setContent($payload)->setMethod('POST')
                                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                                ->addHeaders(['content-type' => 'application/json'])
                                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

                            $regsiterresponse = $request->send();
                            $registerresp =  $regsiterresponse->content;
                        } catch (\yii\base\Exception $exception) {

                            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
                        }

//                        Yii::$app->session->addFlash('warning', json_encode($payload));
                        $jsonresp = json_decode($registerresp);

                        if (isset($jsonresp->metaData->message))
                        {
                            if($jsonresp->metaData->message == 'CREATED') {
                                if(strpos($jsonresp->response->message, "null") ) {
                                    Yii::$app->session->setFlash('danger', $registerresp);
                                } else {
                                    $model->no_urut = $jsonresp->response->message;
                                    $model->status = 'registered';
                                    $model->save();
                                    $pcarevisit->pendaftaranId = $model->id;
                                    $wdmodel->registrationId = $model->id;
                                    $wdmodel->status = 'registered';
                                    $wdmodel->save();
                                    $pcarevisit->save();

                                    Yii::$app->session->setFlash('success', 'no urut created ' . $jsonresp->response->message);
                                    return $this->redirect(['pcare/visit/update', 'id' => $model->id]);
                                }

                            } else {
                                Yii::$app->session->setFlash('danger', $registerresp);

                            }

                        } else {
                            Yii::$app->session->setFlash('danger', json_encode($jsonresp));
                        }




                    } else {
                        Yii::$app->session->setFlash('danger', "nomor peserta tidak aktif");
//                return ' nomor peserta tidak valid';

                    }
                } else {

                    Yii::$app->session->addFlash('danger', 'no kartu error : ' . json_encode($jsonval));
//            return 'cek peserta failed';
                }
            } else {
                Yii::$app->session->setFlash('danger', "data klinik / consID empty");
            }



        }

        if(isset($model->kdTkp)) {
            $model->kdTkp = '10';
        }

//        $prescribedlist = json_deco
        $prescribedlist = explode('","', $prescribed);
//echo str_replace('\n', '<br/>',$prescribed);

//        print_r($prescribedlist);
        return $this->render('testpost', [
            'model' => $model,
            'visitmodel' => $pcarevisit,
            'wdmodel' => $wdmodel,
            'prescribed_list' => $prescribedlist
        ]);
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
//        $registration->setConsId('16744');
        $response = $registration->Cekpeserta();

        $jsonval = json_decode($response);

        if ($jsonval->metaData->code == 200) {
            if ($jsonval->response->aktif)
            {

//                echo $response;
                $registration->kdProviderPeserta = $jsonval->response->kdProviderPst->kdProvider;
                $registration->status = 'ready';
                $registration->save();
                Yii::$app->session->addFlash('success', "Peserta aktif");


            } else {
                Yii::$app->session->setFlash('danger', "nomor peserta tidak aktif");
//                return ' nomor peserta tidak valid';

            }
        } else {
            Yii::$app->session->setFlash('danger', "cek peserta failed");
//            return 'cek peserta failed';
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

    public function actionRegistrationbydate()
{

    $registration = new PcareRegistration();
    $registration->setConsId('16744');


//    print_r($response);
$provider = new ArrayDataProvider();
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $response = $registration->getPendaftaranprovider($post['tanggal']);

//if( $response->getIsOk()) {
    if( $response->getStatusCode() == '200') {
    $content = json_decode($response->content);
//    foreach ($content->response->list as $item) {
//        echo json_encode($item);
//        echo '<br/><br/>';
//    }
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
//    echo 'false';
//    echo $response->getStatusCode();
    Yii::$app->session->setFlash('danger', $response->getStatusCode());
//    echo $response->toString();

};
        } else {
        }



            return $this->render('regbydate', [
                'dataProvider' => $provider
//                'searchModel' => $searchModel,
//                'dataProvider' => $dataProvider,
            ]);

}


    public function __construct(string $id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function getPoli($consid, $issakit)
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
            Yii::$app->session->setFlash('danger', "BPJS no response    ");
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

    public function actionGetfilteredpolicodes()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $options = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];

//                $registration = new PcareRegistration();
//                $registration->setConsId('16744');
                $response = $this->getPoli('16744', $cat_id);
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
            $response = $this->getPoli('16744');
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
    echo 'test';
}



    public function getKesadaran($model)
    {

        $kesadaran = $model->getKesadaran();
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
            Yii::$app->session->addFlash('danger', 'no pcare web service response');
            return $options;
        }

    }


    public function getDokter($consid)
    {
//        $registration = PcareRegistration::findOne($pendaftaranId);
//        $registration = new PcareRegistration();
//        $registration->cons_id = $consid;
        $kesadaran = $consid->getDokter();


        $json = json_decode($kesadaran);
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


    public function actionDiagnosecode($q = null, $id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'text' => '']]];
        if (!is_null($q)) {

//            $visit = PcareVisit::findOne($id);
            $registration = new PcareRegistration();
            $registration->setConsId($id);

//            $visit->setWdId('59cedfba9ae80d05757f54e9.5e87a22effe0dc06b2f87964');
            $response = $registration->getDiagnosecodes($q);

            $jsonval = json_decode($response);
            if (isset($jsonval->response)) {

                foreach ($jsonval->response->list as $item) {
                    $temp = ['id' => $item->kdDiag, 'text' => $item->nmDiag, 'nonspesialis' => var_export($item->nonSpesialis, true)];
                    array_push($out['results'], $temp);
                }
                array_shift($out['results']);
//            $out['results'] = ArrayHelper::map($jsonval->response->list, 'kdDiag', 'nmDiag');
//            $out['results'] = ['id' => '1', 'text' => 'jakarta'];
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

//echo '<pre>';
//print_r($visit);

///no kunjungan
/// kdppk / kdppk_subspesialis
///

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
        return $this->render('testhtml', [
//            'dataProvider' => $provider
        'visitModel' => $visit,
        'dokter' => $dokter,
        'peserta' => $peserta
        ]);
    }

    public function actionProviders()
    {
        $registration = new PcareRegistration();
        $registration->setConsId('16744');
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

    $payload = 'clinicId=59cedfba9ae80d05757f54e9.5e87a22effe0dc06b2f87964&kdPoli=&kdTkp=&tglDaftar=2021-3-13' .
        '&visitId=12345' .
        '&noKartu=&kunjSakit=true' .
        '&kdProviderPeserta=' .
        '&no_urut=' .
    '&keluhan=' .
    '&sistole=' .
    '&diastole=' .
    '&beratBadan=' .
    '&tinggiBadan=' .
    '&respRate=' .
    '&heartRate=' .
        '&doctor=' .
        '&disposition=' .
        '&statusAssesment=' .
        '&administered=' .
        '&prescribed=["Parasetamol 500 mg, #18 -  3 x 2 tablet - 3 Days","Azithromycin 250 mg, #9 - Tablet 3 x 1 tablet - 3 Days","Captopril 12.5 mg, #29 -  1 x 0.96 tablet - 30 Days"]' .
//        '&prescribed=["Paracetamol 500 mg, #9 - Tablet 3 x 1 tablet - 3 Days","Ibuprofen 400 mg, #12 - Tablet 4 x 1 tablet - 3 Days","Ambroxol 30 mg, #12 - Tablet 2 x 2 tablet - 3 Days"]' .
        '&manualDiagnoses=[{"treatment":"captoril","description":"hypertension"}]' .
        '&checklistNames=["Upper respiratory tract infection [URI] / Common Cold (J06.9)"]';

//echo '<pre>';
    try {

        $client = new Client(['baseUrl' => 'http://localhost/walkingdocs/web/index.php/pcare/registration/create']);
        $request = $client->createRequest()
//            ->setData($payload)
//            ->setData(['name' => 'John Doe', 'email' => 'johndoe@domain.com'])
            ->setContent($payload)
            ->setMethod('POST')
            ->addHeaders(['content-type' => 'application/x-www-form-urlencoded'])
        ;
        $response = $request->send();
        ob_start();
        ob_clean();

        echo $response->content;
//        echo 'done';
    } catch (\yii\base\Exception $exception) {
print_r($exception);
        Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
       // return $exception;
    }

}
}
