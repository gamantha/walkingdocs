<?php

namespace app\controllers\learning;
use Yii;

class RestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetchecklist()
    {
        $appPath = Yii::getAlias('@app');
        return \Yii::$app->response->sendFile(  $appPath . '/assets/checklists.json');
    }

}
