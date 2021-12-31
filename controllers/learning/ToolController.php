<?php

namespace app\controllers\learning;

use app\models\learning\ToolCalculation;
use app\models\learning\ToolInputSearch;
use app\models\learning\ToolOutputSearch;
use Yii;
use app\models\learning\Tool;
use app\models\learning\ToolSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use FormulaParser\FormulaParser;

use RR\Shunt\Parser;
use RR\Shunt\Context;

use app\models\learning\ToolInput;

/**
 * ToolController implements the CRUD actions for Tool model.
 */
class ToolController extends Controller
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
     * Lists all Tool models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ToolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tool model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $inputSearchModel = new ToolInputSearch();
        $inputParams['ToolInputSearch']['tool_id'] = $id;
        $inputDataProvider = $inputSearchModel->search($inputParams);

        $outputSearchModel = new ToolOutputSearch();
        $outputParams = Yii::$app->request->queryParams;
        $outputParams['ToolOutputSearch']['tool_id'] = $id;
        $outputDataProvider = $outputSearchModel->search($outputParams);

        $toolCalculation = ToolCalculation::find()->andWhere(['tool_id' => $id])->One();
        if (!isset($toolCalculation)) {
            $toolCalculation = new ToolCalculation();
            //$toolCalculation->tool_id = $id;
        }


        Url::remember(Url::current(), 'returnTool');
        return $this->render('view', [
            'model' => $model,
            'inputDataProvider' => $inputDataProvider,
            'inputSearchModel' => $inputSearchModel,
            'outputSearchModel' => $outputSearchModel,
            'outputDataProvider' => $outputDataProvider,
            'toolCalculation' => $toolCalculation,
        ]);
    }

    /**
     * Creates a new Tool model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tool();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tool model.
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
     * Deletes an existing Tool model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->status = 'disabled';
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tool model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tool the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tool::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionRun($id)
    {
        $model = Tool::findOne($id);

    $result = 0;
        $inputs = $model->toolInputs;
        $inputVals = [];
        $outputs = $model->toolOutputs;
        $resultrounded = 0;
        //$output = $model->toolOutputs[0];
        if ($post = \Yii::$app->request->post()) {

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
            $ctx->def('log');
            //$inputs = ToolInput::find()->andWhere(['tool_id' => $id])->All();
            foreach($inputs as $input) {
                $ctx->def($input->input_name, $post[$input->input_name]); // constant "foo" with value "5"
                $inputVals[$input->input_name] = $post[$input->input_name];

            }

            $equation = $model->toolCalculations[0]->formula;
            $result = Parser::parse($equation, $ctx);
            if ($result >= 10) {
                $resultrounded = round($result, 1);
            } else {
                $resultrounded = round($result, 1);
            }

            //return $result; //3.0001220703125
/*

            $ctx->def('bar', function($a, $b) { return $a * $b; }); // define function
            $equation = '3 + bar(4, 2) / (abs(-1) - foo) ^ 2 ^ 3';
*/
        } else {
            foreach($inputs as $input) {
                //$ctx->def($input->input_name, $post[$input->input_name]); // constant "foo" with value "5"
                $inputVals[$input->input_name] = 0;
            }
        }
        return $this->render('run', [
            'model' => $model,
            'inputs' => $inputs,
            'inputVals' => $inputVals,
            'outputs' => $outputs,
            'result' => $resultrounded
        ]);


    }

    public function actionEnable($id)
    {
        $model = $this->findModel($id);
        $model->status = 'enabled';
        $model->save();
        Yii::$app->session->setFlash('success', "Tool enabled");
        return $this->redirect(['index']);
    }

    public function actionDisable($id)
    {
        $model = $this->findModel($id);
        $model->status = 'disabled';
        $model->save();
        Yii::$app->session->setFlash('success', "Tool disabled");
        return $this->redirect(['index']);
    }
}
