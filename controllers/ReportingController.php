<?php

namespace app\controllers;

use app\models\reporting\IndicatorDictionary;

use app\models\reporting\Lb1Data;
use app\models\reporting\Lb1Indicator;
use app\models\reporting\Lb3Data;
use app\models\reporting\Lb3Indicator;
use kartik\grid\EditableColumnAction;
use Yii;
use app\models\reporting\Report;
use app\models\reporting\ReportSearch;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\reporting\Bpjstemplate;
use yii\grid\GridView;

use Aws\CognitoIdentity\CognitoIdentityClient;

use Aws\Exception\AwsException;

/**
 * ReportingController implements the CRUD actions for Report model.
 */
class ReportingController extends Controller
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

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editdata' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => Lb1Data::className(),                // the update model class
            ],
            'editlb3data' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => Lb3Data::className(),                // the update model class
            ],
        ]);
    }


    /**
     * Lists all Report models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Report model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewlb1($id)
    {

        $this->initReport($id, 'lb1');
        $query = Lb1Data::find()->where(['report_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1000,
            ],
            'sort' => [
                'defaultOrder' => [
                ]
            ],
        ]);

        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewlb2($id) {

    }
    public function actionViewlb3($id) {

        $this->initLb3($id);
        $query = Lb3Data::find()->where(['report_id' => $id]);



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1000,
            ],
        ]);

        $model = $this->findModel($id);

        return $this->render('_lb3', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single Report model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPreview($id)
    {
        $diseases = ['diare', 'kolera','disentri', 'infeksi_usus_lain', 'tb_paru', 'tb_non_paru', 'kusta_mb', 'kusta_pb', 'difteria', 'batuk_rejan', 'tetanus', 'pes',
            'poliomyelitis_akut','campak','rabies','dhf','cacar_air','malaria_lab','malaria_tropika','malaria_clinical','anthrax'];
        $ageranges =  ['0d7d','8d28d','1m1y','1y4y','5y9y','10y14y','15y19y','20y44y','45y54y','55y59y','60y69y','70y'];
        $lb1_template = [];
        foreach ($diseases as $disease) {
            $lb1_template[$disease]['indicatorName'] = $disease;
            foreach ($ageranges as $agerange) {
                $lb1_template[$disease]['m_' . $agerange] = 0;
                $lb1_template[$disease]['f_' . $agerange] = 0;
            }
        }




        $data = $this->fillArray($id);
        $merge = array_merge($lb1_template, $data);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $merge,
            'pagination' => [
                'pageSize' => 200,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        return $this->render('preview', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Report model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Report();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Report model.
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
     * Deletes an existing Report model.
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
     * Finds the Report model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Report the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Report::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Fill an existing Report model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionFill($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('fill', [
            'model' => $model,
        ]);
    }




    public function actionExtrainfo($id) {
        $model = $this->findModel($id);

        if ($post = Yii::$app->request->post()) {
            $array = [];
            $array['kepala_puskesmas'] = $post['kepala_puskesmas'];
            $model->meta = json_encode($array);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $json = json_decode($model->meta);
        if (null == $json) {
            $json = [];
        }
        $prefill = [];
        if(array_key_exists('kepala_puskesmas', $json)) {
            $prefill['kepala_puskesmas'] = $json->kepala_puskesmas;
        } else {
            $prefill['kepala_puskesmas'] = '';
        }



        return $this->render('extrainfo', [
            'model' => $model,
            'prefill' => $prefill,
        ]);
    }

    public function actionTabletest() {

        if ($_POST) {
            //echo 'sasa';
            print_r($_POST);
        }
        return $this->render('tabletest', [
//            'report' => $report,
//            'model' => $model,
        ]);
    }

    public function actionCallback() {
        echo 'callback';
    }



//    public function actionInputlb3($id) {
//        $model = new Lb3Values();
//        $report = Report::findOne($id);
//        return $this->render('input', [
//            'report' => $report,
//            'model' => $model,
//        ]);
//    }
//    public function actionInput($id,$name)
//    {
//        //$model = $this->findModel($name);
//        $indicatorvalues = IndicatorValues::find()
//            ->andWhere(['indicator_name' => $name])
//            ->andWhere(['report_id' => $id])->All();
//        $model = new Bpjstemplate();
//        if (empty($indicatorvalues)) {
//
//        } else {
//            $model->reportId = $id;
//            $model->indicatorName = $name;
//            foreach($indicatorvalues as $indicatorvalue) {
//                //echo $indicatorvalue->age_range;
//
//                $model->{$indicatorvalue->gender . "_" . $indicatorvalue->age_range} = $indicatorvalue->value;
//            }
//
//        }
//
//        $dictModel = IndicatorDictionary::find()->andWhere(['indicator_name' => $name])->One();
//        if (null == $dictModel) {
//            Yii::$app->session->setFlash('danger', 'no indicator of that name');
//            return $this->redirect(Yii::$app->request->referrer);
//        } else {
//            $model->reportId = $id;
//            $model->indicatorName = $name;
//        }
//
//        if ($model->load(Yii::$app->request->post())) {
//            //print_r(Yii::$app->request->post());
//            Yii::$app->session->setFlash('success', 'POST');
//            $model->save();
//            return $this->redirect(['view', 'id' => $model->reportId]);
//            //return print_r($model);
//            //return 'yaea';
//        } else {
//           // Yii::$app->session->setFlash('danger', 'no POST');
//        }
//        $report = Report::findOne($id);
//        return $this->render('input', [
//            'report' => $report,
//            'model' => $model,
//        ]);
//    }

    public function actionAws() {

        $credentials = new \Aws\Credentials\Credentials('AKIAJ54NSGERQG23C3MQ', 'RD/ulnPOwfgvySnPSrjCbjzbqcBQlCxzJcgli9on');
        $client = new CognitoIdentityClient([
            'profile' => 'default',
            'version' => 'latest',
            'region' => 'ap-southeast-1',
            'credentials' => $credentials,
        ]);
//$commands = $client->getCommand();
//        $result = $client->listIdentityPools([
//                    'MaxResults' => 5, // REQUIRED
//    //'NextToken' => '<string>',
//]);


    }

    public function initLb3($reportId) {
        $indicators = Lb3Indicator::find()->asArray()->All();
        $diseases = ArrayHelper::getColumn($indicators, 'id');

        //$diseases = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15',16,17,18,19,20,21,22,23,24,25];
        foreach ($diseases as $disease) {
            $indicatorData = Lb3Data::find()->andWhere(['report_id' => $reportId])->andWhere(['indicator_id' => $disease])->One();
            if (null == $indicatorData) {
                $smalltable = new Lb3Data();
                $smalltable['report_id'] = $reportId;
                $smalltable['indicator_id'] = $disease;
                $smalltable->save();

            } else {

            }

        }

    }

    public function initReport($reportId,$reportTemplateId) {
        $indicators = Lb1Indicator::find()->asArray()->All();
        $diseases = ArrayHelper::getColumn($indicators, 'id');
       // $diseases = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15',16,17,18,19,20,21,22,23,24,25];
        foreach ($diseases as $disease) {
            $indicatorData = Lb1Data::find()->andWhere(['report_id' => $reportId])->andWhere(['indicator_id' => $disease])->One();
            if (null == $indicatorData) {
                $smalltable = new Lb1Data();
                $smalltable['report_id'] = $reportId;
                $smalltable['indicator_id'] = $disease;
                $smalltable->save();
//                echo 'save ' . $smalltable['report_id'];
//                echo '<br>';
            } else {
//                echo 'NO';
//                echo '<br>';
            }

        }

//        $merge = array_merge($dataProvider->getModels(), $bigtable);
//
//        $dataProvider2 = new ArrayDataProvider([
//            'allModels' => $merge
//        ]);
    }

}
