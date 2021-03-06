<?php

namespace app\controllers\pcare;

use app\models\pcare\AntreanPanggil;
use app\models\pcare\ClinicUser;
use Yii;
use app\models\pcare\Antrean;
use app\models\pcare\AntreanSearch;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AntreanController implements the CRUD actions for Antrean model.
 */
class AntreanController extends Controller
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

    public function actionPoli($id)
    {


        $date = date("Y-m-d") ;


        if (!Yii::$app->user->isGuest)
        {
            $userId = Yii::$app->user->identity->getId();
            $clinics = ClinicUser::find()->andWhere(['userId' => $userId])->All();
            $clinics_array = ArrayHelper::getColumn($clinics, 'clinicId');


            if ($_POST) {
                $date = $_POST['tanggalDaftar'] ;
                if(isset($_POST['next'])) {

                    $this->next($clinics[0]->clinicId,$id , $date);
                } else if(isset($_POST['skip'])) {
                    $this->skip($clinics[0]->clinicId,$id , $date);

                } else {
                    Yii::$app->session->setFlash('success', $_POST['tanggalDaftar']);
                }





            }


            $antreanTerakhir = AntreanPanggil::find()->andWhere(['clinicId' => $clinics[0]->clinicId])
                ->andWhere(['tanggalPeriksa' => $date])
            ->andWhere(['kdPoli' => $id])->One();
            if (!isset($antreanTerakhir)) {
                $antreanTerakhir = new AntreanPanggil();
                $antreanTerakhir->nomorpanggilterakhir = '-';
            }


            $searchModel = new AntreanSearch();
            $query = Yii::$app->request->queryParams;
            $query['AntreanSearch']['clinicId'] = $clinics[0]->clinicId;
            $query['AntreanSearch']['kdPoli'] = $id;
            $query['AntreanSearch']['tanggalPeriksa'] = $date;
            $query['sort'] = 'angkaAntrean';

            $dataProvider = $searchModel->search($query);

            $searchModel2 = new AntreanSearch();
            $query2 = Yii::$app->request->queryParams;
            $query2['AntreanSearch']['clinicId'] = $clinics[0]->clinicId;
            $query2['AntreanSearch']['kdPoli'] = $id;
            $query2['AntreanSearch']['tanggalPeriksa'] = $date;
            $query2['AntreanSearch']['status'] = 'skip';
            $dataProvider2 = $searchModel2->search($query2);

            return $this->render('indexpoli', [
                'kdPoli' => $id,
                'date' => $date,
                'searchModel' => $searchModel,
                'searchModel2' => $searchModel2,
                'dataProvider' => $dataProvider,
                'dataProvider2' => $dataProvider2,
                'antreanTerakhir' => $antreanTerakhir
            ]);








        } else {
            echo 'not Authorized';
        }





    }


    /**
     * Lists all Antrean models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest)
        {
            $userId = Yii::$app->user->identity->getId();
            $clinics = ClinicUser::find()->andWhere(['userId' => $userId])->All();
            $clinics_array = ArrayHelper::getColumn($clinics, 'clinicId');
        }


//
//        $query = Antrean::find()->andWhere(['in', 'clinicId', $clinics_array]);


        $searchModel = new AntreanSearch();
        $query = Yii::$app->request->queryParams;
        $query['AntreanSearch']['clinicId'] = $clinics[0]->clinicId;
        $dataProvider = $searchModel->search($query);


//        print_r($query);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Antrean model.
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
     * Creates a new Antrean model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Antrean();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Antrean model.
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
     * Deletes an existing Antrean model.
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
     * Finds the Antrean model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Antrean the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Antrean::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function next($clinicId, $kdPoli,$tanggalPeriksa)
    {
        $antreanTerakhir = AntreanPanggil::find()->andWhere(['clinicId' => $clinicId])
            ->andWhere(['tanggalPeriksa' => $tanggalPeriksa])
            ->andWhere(['kdPoli' => $kdPoli])->One();

        if (null == $antreanTerakhir) {
            $antreanTerakhir = new AntreanPanggil();
            $antreanTerakhir->clinicId = $clinicId;
            $antreanTerakhir->kdPoli = $kdPoli;
            $antreanTerakhir->tanggalPeriksa = $tanggalPeriksa;
            $antreanTerakhir->nomorpanggilterakhir = 0;
        }

        $nomorterakhir = $antreanTerakhir->nomorpanggilterakhir;
        $nomorterakhir++;
        $antreanTerakhir->nomorpanggilterakhir = $nomorterakhir;
        $antreanTerakhir->save();
        Yii::$app->session->setFlash('success', "NEXT ");
        return;
    }

    public function skip($clinicId, $kdPoli,$tanggalPeriksa)
    {
        $antreanTerakhir = AntreanPanggil::find()->andWhere(['clinicId' => $clinicId])
            ->andWhere(['tanggalPeriksa' => $tanggalPeriksa])
            ->andWhere(['kdPoli' => $kdPoli])->One();

        if (null == $antreanTerakhir) {
            $antreanTerakhir = new AntreanPanggil();
            $antreanTerakhir->clinicId = $clinicId;
            $antreanTerakhir->kdPoli = $kdPoli;
            $antreanTerakhir->tanggalPeriksa = $tanggalPeriksa;
            $antreanTerakhir->nomorpanggilterakhir = 0;
        }

        $nomorterakhir = $antreanTerakhir->nomorpanggilterakhir;

        $antrean = Antrean::find()->andWhere(['clinicId' => $clinicId])
            ->andWhere(['tanggalPeriksa' => $tanggalPeriksa])
            ->andWhere(['angkaAntrean' => $nomorterakhir])
            ->andWhere(['kdPoli' => $kdPoli])->One();

        if (null !== $antrean) {
            $antrean->status = 'skip';
            $antrean->save();
        }

        $nomorterakhir = $antreanTerakhir->nomorpanggilterakhir;
        $nomorterakhir++;
        $antreanTerakhir->nomorpanggilterakhir = $nomorterakhir;
        $antreanTerakhir->save();
        Yii::$app->session->setFlash('warning', "SKIP");

        return;
    }
}
