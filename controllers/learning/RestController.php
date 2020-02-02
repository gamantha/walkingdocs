<?php

namespace app\controllers\learning;
use Yii;

class RestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetchecklistversion()
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists', 1);

//        print_r($files);
        return $files[0];
        //return \Yii::$app->response->sendFile(  $appPath . '/assets/checklists/checklist.json');
    }

    public function actionGetchecklist()
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists', 1);
        //return $files[0];
        return \Yii::$app->response->sendFile(  $appPath . '/assets/checklists/' . $files[0]);
    }

}
