<?php

namespace app\controllers\pcare;

use app\models\pcare\ClinicSchedule;
use app\models\pcare\PcareRegistration;
use Yii;
use app\models\Consid;
use app\models\ConsidSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClinicController implements the CRUD actions for Consid model.
 */
class ClinicController extends Controller
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
     * Lists all Consid models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConsidSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Consid model.
     * @param string $id
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
     * Creates a new Consid model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Consid();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->wd_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateschedule($id)
    {
        $model = new ClinicSchedule();
        $model->clinicId = $id;

        if ($model->load(Yii::$app->request->post())) {
            $start=date_create($model->starttime);
            $start2= date_format($start,"H:i:s");

            $end=date_create($model->endtime);
            $end2= date_format($end,"H:i:s");


//            $schedules = ClinicSchedule::find()->andWhere(['clinicId' => $id])
//                ->andWhere(['dayofweek' => $model->dayofweek])
//                ->andWhere(['starttime' => $start2])
//                ->andWhere(['endtime' => $end2])->All();

if($model->validate())
{
//    Yii::$app->session->addFlash('success', json_encode($model->errors));
    $model->save();
    return $this->redirect(['schedule', 'id' => $id]);
//    return $this->redirect(Yii::$app->request->referrer);
} else {
    Yii::$app->session->addFlash('warning', json_encode($model->errors));
}
//
        }

        return $this->render('createschedule', [
            'model' => $model,
        ]);
    }



    /**
     * Updates an existing Consid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->wd_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Consid model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSchedule($id)
    {


        $dataProvider = new ActiveDataProvider([
            'query' => ClinicSchedule::find()->andWhere(['clinicId' => $id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        return $this->render('schedule', [
            'dataProvider' => $dataProvider,
            'id' => $id,
        ]);
    }

    public function actionDeleteschedule($clinicId,$dayofweek, $starttime, $endtime)
    {
            $schedule = ClinicSchedule::find()->andWhere(['clinicId' => $clinicId])
                ->andWhere(['dayofweek' => $dayofweek])
                ->andWhere(['starttime' => $starttime])
                ->andWhere(['endtime' => $endtime])->One();

        Yii::$app->session->addFlash('success', 'Deleted');
$schedule->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionIntegrationcheck($wdid)
    {
        $model = Consid::findOne($wdid);
            if (empty($model)) {
                $model = new Consid();
            }


        $response = Yii::$app->pcareComponent->integrationCheck($model->cons_id);
//            print_r($response);
if ($response == null) {
//    echo 'null';
} else {

//    print_r($response);

    return $this->render('integrationcheck', [
        'model' => $model,
        'restdata' => $response
    ]);
}
    }


    /**
     * Finds the Consid model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Consid the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Consid::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
