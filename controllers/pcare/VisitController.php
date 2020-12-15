<?php

namespace app\controllers\pcare;

use app\models\pcare\PcareRegistration;
use Yii;
use app\models\pcare\PcareVisit;
use app\models\pcare\PcareVisitSearch;
use yii\helpers\ArrayHelper;
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
$visit = PcareVisit::find()->andWhere(['pendaftaranId' => $id])->One();
//if ($visit == null) {
//    $visit = new PcareVisit();
//    $visit->pendaftaranId = $id;
//
//
//
//}

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
        $model = PcareVisit::find()->andWhere(['pendaftaranId' => $id])->One();
        $registrationModel = PcareRegistration::findOne($id);
        if ($model == null) {
            $model = new PcareVisit();
            $model->pendaftaranId = $id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($registrationModel->load(Yii::$app->request->post()) && $registrationModel->save()) {
                return $this->redirect(['view', 'id' => $model->pendaftaranId]);
            }
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
        echo 'test';
    }

    public function actionSubmit($id)
    {

        $registration = PcareRegistration::findOne($id);
        $visit = PcareVisit::findOne($id);
//        $registration->setWdId('wdid2');
//        $visit->setWdId('wdid2');
        $response = $registration->Cekpeserta();

        $jsonval = json_decode($response);

        if ($jsonval->metaData->code == 200) {
            if ($jsonval->response->aktif)
            {
//                $visit->kdProviderPeserta = $jsonval->response->kdProviderPst->kdProvider;

//                $post = file_get_contents('php://input');
                $registerresp = $visit->submitvisitdata($id); //actual register to pcare
                $jsonresp = json_decode($registerresp);

//                print_r($registerresp);
                if($jsonresp->metaData->message == 'CREATED') {
                    if(strpos($jsonresp->response->message, "null") ) {
                        Yii::$app->session->setFlash('danger', $registerresp);
                    } else {
//                        echo 'no urut created ' . $jsonresp->response->message;
                        $visit->noKunjungan = $jsonresp->response->message;
                        $visit->status = 'submitted';
                        Yii::$app->session->setFlash('success', 'no kunjungan received ' . $jsonresp->response->message);
                    }
                    $visit->save();
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



    public function actionDiagnosecode($q = null, $id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'text' => '']]];
        if (!is_null($q)) {

            $visit = PcareVisit::findOne($id);

//            $visit->setWdId('wdid2');
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
                Yii::$app->session->addFlash('danger', 'get diagnose code - no pcare web service response');
            }

        } else {

        }


        return $out;

    }



    public function actionKhusussubspesialis($q = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => [['id' => '', 'text' => '']]];
        if (!is_null($q)) {

            $visit = new PcareVisit();

            $visit->setWdId('wdid2');
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
