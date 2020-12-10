<?php

namespace app\controllers\pcare;


use app\models\Consid;
use app\models\pcare\PcareVisit;
use Yii;
use app\models\pcare\PcareRegistration;
use app\models\pcare\PcareRegistrationSearch;
use yii\base\Module;

use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegistrationController implements the CRUD actions for PcareRegistration model.
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
        $model = new PcareRegistration();
        $request = Yii::$app->request;
        $params = $request->bodyParams;
//return json_encode($params);
        if (isset($params['clinicId'])) {
            $considmodel = Consid::find()->andWhere(['wd_id' => $params['clinicId']])->One();
            if (isset($considmodel->cons_id)) {
                $model->cons_id = $considmodel->cons_id;
            } else {
                Yii::$app->session->addFlash('danger', "NO ConsID data!!!");
            }

                $model->kdPoli = $params['kdPoli'];
                $model->noKartu = $params['noKartu'];
                $model->kunjSakit = $params['kunjSakit'];
                $model->kdTkp = $params['kdTkp'];
                $model->kdProviderPeserta = $params['kdProviderPeserta'];
                $model->tglDaftar = $params['tglDaftar'];
                // optional
                $model->no_urut = $params['no_urut'];
                $model->keluhan = $params['keluhan'];
                $model->sistole = $params['sistole'];
                $model->diastole = $params['diastole'];
                $model->beratBadan = $params['beratBadan'];
                $model->tinggiBadan = $params['tinggiBadan'];
                $model->respRate = $params['respRate'];
                $model->heartRate = $params['heartRate'];


        } else {
            Yii::$app->session->addFlash('warning', "NO POST data");
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $pcarevisit = new PcareVisit();
            $pcarevisit->pendaftaranId = $model->id;
            $pcarevisit->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
        $registration->setWdId('wdid2');
        $response = $registration->Cekpeserta();

        $jsonval = json_decode($response);

        if ($jsonval->metaData->code == 200) {
            if ($jsonval->response->aktif)
            {

//                echo $response;
                $registration->kdProviderPeserta = $jsonval->response->kdProviderPst->kdProvider;
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
        $registration->setWdId('wdid2');
        $response = $registration->Cekpeserta();

        $jsonval = json_decode($response);

        if ($jsonval->metaData->code == 200) {
            if ($jsonval->response->aktif)
            {
                $registration->kdProviderPeserta = $jsonval->response->kdProviderPst->kdProvider;

//                $post = file_get_contents('php://input');
                $registerresp = $registration->register($id); //actual register to pcare
                $jsonresp = json_decode($registerresp);
                if($jsonresp->metaData->message == 'CREATED') {
                    if(strpos($jsonresp->response->message, "null") ) {
                        Yii::$app->session->setFlash('danger', $registerresp);
                    } else {
//                        echo 'no urut created ' . $jsonresp->response->message;
                        $registration->no_urut = $jsonresp->response->message;
                        $registration->status = 'pcare_created';
                        Yii::$app->session->setFlash('success', 'no urut created ' . $jsonresp->response->message);
                    }
                                    $registration->save();
                } else {
                    Yii::$app->session->setFlash('danger', $registerresp);
//echo $registerresp;
                }

//print_r($jsonval->response->kdProviderPst->kdProvider);
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
    $registration->setWdId('wdid2');


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


}
