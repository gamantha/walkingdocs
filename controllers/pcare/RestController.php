<?php

namespace app\controllers\pcare;

use app\models\Consid;
use yii\rest\ActiveController;
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


class RestController extends ActiveController
{

    public $modelClass = 'app\models\Pendaftaran';

    public function actionTest()
    {
        return 'test';
    }

    public function actionIntegrationcheck($wdid)
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;



        $clinicObject = Consid::findOne($wdid);

        if(empty($clinicObject)) {


            $response = ['integrated' => false];
            $response['status'] = 'no integration data is found';
            $response['consid'] = null;

    } else {

            $response = Yii::$app->pcareComponent->integrationCheck($clinicObject->cons_id);
            $resObj = json_decode($response);

            if ($resObj->response == null) {
                $response = ['integrated' => false];
                $response['status'] = 'null response from bpjs';
                $response['consid'] = $clinicObject['cons_id'];
            } else {
                $response = ['integrated' => true];
                $response['status'] = 'fully integrated';
                $response['consid'] = $clinicObject['cons_id'];
            }


//            $response['consid'] = $clinicObject['cons_id'];
    }

        return $response;

    }

//    public func

}