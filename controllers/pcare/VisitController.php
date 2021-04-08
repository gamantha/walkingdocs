<?php

namespace app\controllers\pcare;

use app\models\Consid;
use app\models\pcare\PcareRegistration;
use Yii;
use app\models\pcare\PcareVisit;
use app\models\pcare\PcareVisitSearch;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VisitController implements the CRUD actions for PcareVisit model.
 */
class VisitController extends Controller
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
     * Lists all PcareVisit models.
     * @return mixed
     */
    public function actionIndex()
    {

        echo 'not allowed';
//        $searchModel = new PcareVisitSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
    }

    /**
     * Displays a single PcareVisit model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = '@app/views/layouts/popuplayout';
$visit = PcareVisit::find()->andWhere(['pendaftaranId' => $id])->One();
//if ($visit == null) {
//    $visit = new PcareVisit();
//    $visit->pendaftaranId = $id;
//
//
//
//}

    if (is_null($visit)) {
        $visit = new PcareVisit();
        $visit->pendaftaranId = $id;
        $visit->save();
    }

        return $this->render('view', [
            'model' => $visit,
        ]);
    }

    /**
     * Creates a new PcareVisit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new PcareVisit();
        $regModel = PcareRegistration::findOne($id);
        $model->pendaftaranId = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'id' => $id,
            'model' => $model,
            'regModel' => $regModel
        ]);
    }

    /**
     * Updates an existing PcareVisit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = '@app/views/layouts/popuplayout';
        $model = PcareVisit::find()->andWhere(['pendaftaranId' => $id])->One();
        $registrationModel = PcareRegistration::findOne($id);
        if ($model == null) {
            $model = new PcareVisit();
            $model->pendaftaranId = $id;
        }

        if ($model->load(Yii::$app->request->post())
//            && $model->save()
        ) {

            if ($registrationModel->load(Yii::$app->request->post())
//                && $registrationModel->save()
            ) {


##############################

                $subspesialis_payload = 'null';
                $khusus_payload = 'null';

                if ($model->spesialis_type == 'spesialis')
                {
                    $subspesialis_payload = '{
       "kdSubSpesialis1": "'.$model->subSpesialis_kdSubSpesialis1.'",
      "kdSarana": "'.$model->subSpesialis_kdSarana .'"
            }';

                    $ppk_payload = $model->kdppk_subSpesialis;
                } else {
                    $ppk_payload = $model->kdppk;
                }
                $terapi = str_replace(array("\n", "\r"), '', $model->terapi);
//        $terapi = str_replace("\n",',',$visitModel->terapi);
                $payload = '{
         "noKunjungan": "'.$model->noKunjungan.'",
        "tglDaftar": "'.date("d-m-Y" , strtotime($registrationModel->tglDaftar)).'", 
        "noKartu": "'.$registrationModel->noKartu.'",
        "kdPoli": "'.$registrationModel->kdPoli.'",
        "keluhan": "'.$registrationModel->keluhan.'",
  "kdSadar": "'.$model->kdSadar.'",
  
          "sistole": "'.$registrationModel->sistole.'",
        "diastole": "'.$registrationModel->diastole.'",
        "beratBadan": "'.$registrationModel->beratBadan.'",
        "tinggiBadan": "'.$registrationModel->tinggiBadan.'",
        "respRate": "'.$registrationModel->respRate.'",
        "heartRate": "'.$registrationModel->heartRate.'",


          "terapi": "'.$terapi.'",
     "kdStatusPulang": "'.$model->kdStatusPulang.'",

     "tglPulang": "'.date("d-m-Y" , strtotime($model->tglPulang)).'", 
     "kdDokter": "'.$model->kdDokter.'",
     "kdDiag1": "'.$model->kdDiag1.'",
     "kdDiag2": "'.$model->kdDiag2.'",
     "kdDiag3": "'.$model->kdDiag3.'",
     "kdPoliRujukInternal": "'.$model->kdPoliRujukInternal.'",
  "rujukLanjut": {	
  	"tglEstRujuk": "'.date("d-m-Y" , strtotime($model->tglEstRujuk)).'", 
    "kdppk": "'.$ppk_payload.'",
    "subSpesialis": '.$subspesialis_payload.',
    "khusus":  '.$khusus_payload.'
  },
          "kdTacc": "'.$model->kdTacc.'",
               "alasanTacc": "'.$model->alasanTacc.'"

     
      }';

                $bpjs_user = $registrationModel->getUsercreds($registrationModel->cons_id);

                try {

                    $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/kunjungan']);
                    $request = $client->createRequest()
                        ->setContent($payload)->setMethod('POST')
                        ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                        ->addHeaders(['content-type' => 'application/json'])
                        ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                        ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                        ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

                    $vresponse = $request->send();
//            return $payload;
                    $visitresp = $vresponse->content;
                } catch (\yii\base\Exception $exception) {

                    Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
                }




                $jsonresp = json_decode($visitresp);
                if((isset($jsonresp->metaData)) && ($jsonresp->metaData->message == 'CREATED')) {
                    if(strpos($jsonresp->response->message, "null") ) {
                        Yii::$app->session->setFlash('danger', $visitresp);
                    } else {
//                        echo 'no urut created ' . $jsonresp->response->message;
                        $model->noKunjungan = $jsonresp->response->message;
                        $model->status = 'submitted';
                        $registrationModel->status = 'submitted';
                        Yii::$app->session->setFlash('success', 'no kunjungan received ' . $jsonresp->response->message);

                        $model->save();
                        $registrationModel->save();

                        return $this->redirect(['view', 'id' => $model->pendaftaranId]);

                    }

                } else {
                    Yii::$app->session->setFlash('danger', $visitresp);

                }







                ######################










            }
        } else {
//            Yii::$app->session->setFlash('danger', "save gagal " . json_encode($model->getErrors()));
        }


        if ($model->kdSadar == null)
        {
$model->kdSadar = "01";
//            Yii::$app->session->addFlash('danger', "NULL");
        }


if ($model->kdStatusPulang == null)
{
    if ($registrationModel->kdTkp == 10) {
$model->kdStatusPulang=3;
    } else if ($registrationModel->kdTkp == 20) {
        $model->kdStatusPulang=0;
    }
}

        if ($model->tglPulang == null) {
            $today =  date("Y-m-d");
            $model->tglPulang = $today;
//                    Yii::$app->session->addFlash('danger', $today);
        }

        if ($model->tglEstRujuk == null) {
            $today =  date("Y-m-d");
            $model->tglEstRujuk = $today;
//                    Yii::$app->session->addFlash('danger', $today);
        }


        if ($model->spesialis_type == null) {

            $model->spesialis_type = "spesialis";
//                    Yii::$app->session->addFlash('danger', $today);
        }


        return $this->render('update', [
            'model' => $model,
            'registrationModel' => $registrationModel
        ]);
    }

    /**
     * Deletes an existing PcareVisit model.
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
     * Finds the PcareVisit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PcareVisit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PcareVisit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionTest()
    {

        $registration = PcareRegistration::findOne('95');
//        $registration->setWdId('wdid2');
        $kesadaran = $registration->getStatuspulang('95');
        $json = json_decode($kesadaran);
        $options = [];
//        foreach ($json->response->list as $i)
//        {
//            $options[$i->kdStatusPulang] = $i->kdStatusPulang . ' : ' . $i->nmStatusPulang;
//        }

        return $json;
    }

    public function actionSubmit($id)
    {

        $registration = PcareRegistration::findOne($id);
        $visit = PcareVisit::find()->andWhere(['pendaftaranId' => $id])->One();

        $response = $registration->Cekpeserta();

        $jsonval = json_decode($response);

        if ($jsonval->metaData->code == 200) {
            if ($jsonval->response->aktif)
            {
                $registerresp = $visit->submitvisitdata($id); //actual register to pcare

























                $jsonresp = json_decode($registerresp);
                if((isset($jsonresp->metaData)) && ($jsonresp->metaData->message == 'CREATED')) {
                    if(strpos($jsonresp->response->message, "null") ) {
                        Yii::$app->session->setFlash('danger', $registerresp);
                    } else {
//                        echo 'no urut created ' . $jsonresp->response->message;
                        $visit->noKunjungan = $jsonresp->response->message;
                        $visit->status = 'submitted';
                        $registration->status = 'submitted';
                        Yii::$app->session->setFlash('success', 'no kunjungan received ' . $jsonresp->response->message);
                    }
                    $visit->save();
                    $registration->save();
                } else {
                    Yii::$app->session->setFlash('danger', $registerresp);

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

    public function actionApitest() {
        $registration = new PcareRegistration();
//        $registration->setWdId('wdid2');
        $kesadaran = $registration->getKesadaran();

        echo '<pre>';
        print_r($kesadaran);
    }
    public function getKesadaran($pendaftaranId)
    {
        $registration = PcareRegistration::findOne($pendaftaranId);
//        $registration->setWdId('wdid2');
        $kesadaran = $registration->getKesadaran();
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

    public function getStatuspulang($pendaftaranId)
    {

//        $registration = PcareVisit::find()->andWhere(['pendaftaranId' => $pendaftaranId])->One();
        $registration = PcareRegistration::findOne($pendaftaranId);
//        $registration->setWdId('wdid2');
        $kesadaran = $registration->getStatuspulang($pendaftaranId);
        $json = json_decode($kesadaran);
        $options = [];
        foreach ($json->response->list as $i)
        {
            $options[$i->kdStatusPulang] = $i->kdStatusPulang . ' : ' . $i->nmStatusPulang;
        }

        return $options;
    }

    public function getDokter($pendaftaranId)
    {
        $registration = PcareRegistration::findOne($pendaftaranId);
//        $registration->setWdId('wdid2');
        $kesadaran = $registration->getDokter();


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

    public function getReferensiKhusus($pendaftaranId)
    {
        $registration = PcareVisit::find()->andWhere(['pendaftaranId' => $pendaftaranId])->One();

//        $registration->setWdId('wdid2');
        $kesadaran = $registration->getReferensiKhusus();
        $json = json_decode($kesadaran);
        $options = [];
        if (isset($json->response)) {


        foreach ($json->response->list as $i)
        {
            $options[$i->kdKhusus] = $i->kdKhusus . ' : ' . $i->nmKhusus;
        }
        } else {
            Yii::$app->session->addFlash('danger', 'get referensi khusus - no pcare web service response');
        }

        return $options;
    }
    public function getReferensiSpesialis($pendaftaranId)
    {
        $registration = PcareVisit::find()->andWhere(['pendaftaranId' => $pendaftaranId])->One();
//        $registration = new PcareVisit();
//        $registration->setWdId('wdid2');
        $kesadaran = $registration->getReferensiSpesialis();
        $json = json_decode($kesadaran);
        $options = [];
        if (isset($json->response)) {


            foreach ($json->response->list as $i) {
                $options[$i->kdSpesialis] = $i->kdSpesialis . ' : ' . $i->nmSpesialis;
            }
        } else {
            Yii::$app->session->addFlash('danger', 'get referensi spesialis - no pcare web service response');
        }
        return $options;
    }
        public function getSarana($pendaftaranId)
    {
        $registration = PcareVisit::find()->andWhere(['pendaftaranId' => $pendaftaranId])->One();
        $kesadaran = $registration->getSarana();
        $json = json_decode($kesadaran);
        $options = [];
        if (isset($json->response)) {


            foreach ($json->response->list as $i) {
                $options[$i->kdSarana] = $i->kdSarana . ' : ' . $i->nmSarana;
            }
        } else {
            Yii::$app->session->addFlash('danger', 'get sarana - no pcare web service response');
            return $options;
        }

        return $options;
    }

    public function getSubspesialisksdjakljdlajdlajldajldjalsdjaldjal($keyword)
    {

        $clinic = Consid::find()->andWhere(['wd_id' => 'wdid2'])->One();
        $bpjs_user = self::getUsercreds($clinic->cons_id);

        try {
            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/'.$keyword.'/subspesialis']);
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


//        return [['id' => 'contoh', 'text' => $keyword, 'kdPoliRujuk' => 'contoh']];
    }

    public function actionTest2()
    {
        $visit = PcareVisit::findOne('33');
        $noKartu = '0001113569638';
        $response = $visit->getRujukanKhusus($kdkhusus, $kdsubspesialis, $tglrujuk, $noKartu);

        echo '<pre>';
        print_r($response);
    }
public function actionRujukankhusus($id)
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = ['results' => [['id' => '', 'name' => '']]];

//    $noKartu = '0001113569638';
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $kdkhusus = $parents[0];
            $kdsubspesialis = empty($parents[1]) ? null : $parents[1];
            $tglrujuk = empty($parents[2]) ? null : $parents[2];

            $out = ['results' => [['id' => $kdkhusus, 'name' => $tglrujuk, 'sarana' => $kdsubspesialis]]];

            $visit = PcareVisit::findOne($id);

            $response = $visit->getRujukanKhusus($kdkhusus, $kdsubspesialis, $tglrujuk, $noKartu);

            $jsonval = json_decode($response);
            if (isset($jsonval->response)) {

                foreach ($jsonval->response->list as $item) {
                    $temp = ['id' => $item->kdppk, 'name' => $item->nmppk, 'alamatPpk' => $item->alamatPpk, 'jadwal' => $item->jadwal, 'nmkc' => $item->nmkc];
                    array_push($out['results'], $temp);
                }
                array_shift($out['results']);
            } else {
//                Yii::$app->session->addFlash('danger', 'get rujukan khusus - no pcare web service response');
            }

            return ['output'=>$out, 'selected'=>''];
        }
    }
    return ['output'=>$out, 'selected'=>''];
}

    public function actionRujukanspesialis($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'name' => '']]];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $keyword = $parents[0];
                $sarana = empty($parents[1]) ? null : $parents[1];
                $tglrujuk = empty($parents[2]) ? null : $parents[2];

                $out = ['results' => [['id' => $keyword, 'name' => $tglrujuk, 'sarana' => $sarana]]];

                $visit = PcareVisit::findOne($id);

                $response = $visit->getRujukanSpesialis($keyword, $sarana, $tglrujuk);

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
                    Yii::$app->session->addFlash('danger', 'get rujukan spesialis - no pcare web service response');
                }

                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>$out, 'selected'=>''];
    }

public function actionSubspesialiskdsarana($id)
{

    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = ['results' => [['id' => '', 'name' => '']]];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $keyword = $parents[0];

            $visit = PcareVisit::findOne($id);

            $response = $visit->getSarana();

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
    public function actionSubspesialis($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'name' => '']]];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $keyword = $parents[0];

                $visit = PcareVisit::findOne($id);

                $response = $visit->getReferensiSubspesialis($keyword);

                $jsonval = json_decode($response);
                if (isset($jsonval->response)) {

                    foreach ($jsonval->response->list as $item) {
                        $temp = ['id' => $item->kdSubSpesialis, 'name' => $item->nmSubSpesialis, 'kdPoliRujuk' => $item->kdPoliRujuk];
                        array_push($out['results'], $temp);
                    }
                    array_shift($out['results']);
                } else {
                    Yii::$app->session->addFlash('danger', 'get subspesialis kd - no pcare web service response');
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

    public function actionDiagnosecode($q = null, $id)
    {
//        Yii::$app->session->addFlash('sucess', 'get diagnose code - MSUK');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'text' => '']]];
        if (!is_null($q)) {

            $visit = PcareVisit::findOne($id);

            $response = $visit->getDiagnosecodes($q);

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
//                Yii::$app->session->addFlash('danger', 'get diagnose code - no pcare web service response');
            }

        } else {
//            $temp = ['id' => '99999', 'text' => 'reno', 'nonspesialis' => true];
//            array_push($out['results'], $temp);
//            array_shift($out['results']);
        }


        return $out;

    }



    public function actionKhusussubspesialis($q = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'text' => '']]];
        if (!is_null($q)) {

            $visit = new PcareVisit();

//            $visit->setWdId('wdid2');
            $response = $visit->getKhusussubspesialis($q);

            $jsonval = json_decode($response);
//            print_r($jsonval->response->list);

//            $out['results'] = $jsonval->response->list;
            foreach ($jsonval->response->list as $item) {
                $temp = ['id' => $item->kdSubSpesialis, 'text' => $item->nmSubSpesialis];
                array_push($out['results'], $temp);
            }
            array_shift($out['results']);
//            $out['results'] = ArrayHelper::map($jsonval->response->list, 'kdDiag', 'nmDiag');
//            $out['results'] = ['id' => '1', 'text' => 'jakarta'];

        } else {
//            $out = ['results' => [['id' => '', 'text' => '']]];
//            $out['results'] = ['id' => '1', 'text' => 'jakarta'];
        }


        return $out;
    }

}
