<?php

namespace app\controllers\pcare;

use app\models\pcare\PcareRegistration;
use app\models\pcare\Tindakan;
use Yii;
use yii\base\BaseObject;
use yii\data\ActiveDataProvider;

class TindakanController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function getReferensiTindakan($id)
    {
        $model = new Tindakan();
        $model->visitId = $id;
        $referensi_tindakan = $model->getReferensiTindakan($model->visit->pendaftaran->kdTkp);
        return $referensi_tindakan;
    }

    public function actionUpdate($id)
    {
        $model = Tindakan::findOne($id);

        $list=[];
        $referensi_tindakan = self::getReferensiTindakan($model->visitId);
//        echo $model->visit->pendaftaran->kdTkp;
        $ref_tindakan_array = json_decode($referensi_tindakan);
//       echo '<pre>';
        if (isset($ref_tindakan_array->metaData->code)) {
            if ($ref_tindakan_array->metaData->code == 200) {
                $list = $ref_tindakan_array->response->list;
            }
        }




        if ($model->load(Yii::$app->request->post())) {

            $result = $model->editTindakan($model->kdTindakanSK,$model->visit->noKunjungan, $model->kdTindakan, $model->biaya, $model->keterangan, $model->hasil);
            $result_array = json_decode($result);
            if (isset($result_array->metaData->code)) {
                if (isset($result_array->response->field)) {

                    if ($result_array->metaData->code == 200) {
                        Yii::$app->session->addFlash('success', json_encode($result_array));
                        $model->kdTindakanSK = $result_array->response->message;
                        $model->save();
                        return $this->redirect(['pcare/tindakan/view', 'id' => $model->visit->pendaftaranId]);
//                        return $this->redirect(Yii::$app->request->referrer);
                    } else {
                        Yii::$app->session->addFlash('warning', json_encode($result_array->metaData));
                    }



                } else {
                    Yii::$app->session->addFlash('warning', json_encode($result_array));
                }
            } else {
                Yii::$app->session->addFlash('warning', json_encode($result_array));
            }

        }


        return $this->render('create', [
            'model' => $model,
            'list' => $list
        ]);

    }


public function actionView($id)
{
    $dataProvider = new ActiveDataProvider([
        'query' => Tindakan::find(),
        'pagination' => [
            'pageSize' => 20,
        ],
    ]);

    return $this->render('view', [
        'dataProvider' => $dataProvider,
        'id' => $id
    ]);
}

public function actionDelete($id)
{
$model = Tindakan::findOne($id);
$resultjson = $model->deleteTindakan($id);
$result = json_decode($resultjson);
    if (isset($result->metaData->code)) {
        if ($result->metaData->code == 200) {
            Yii::$app->session->addFlash('success', "tindakan deleted");
            $model->delete();
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::$app->session->addFlash('warning', json_encode($result->metaData));
        }
    } else {
        Yii::$app->session->addFlash('warning', json_encode($result));
}
//print_r($result);

}
    public function actionCreate($id)
    {
$registration = PcareRegistration::findOne($id);
        $model = new Tindakan();
        $model->visitId = $registration->getPcareVisits()->one()->id;
        $model->biaya = 0;
        $model->hasil = 0;
        $list=[];
        $referensi_tindakan = self::getReferensiTindakan($model->visitId);
//        echo $model->visit->pendaftaran->kdTkp;
       $ref_tindakan_array = json_decode($referensi_tindakan);
//       echo '<pre>';
       if (isset($ref_tindakan_array->metaData->code)) {
           if ($ref_tindakan_array->metaData->code == 200) {
               $list = $ref_tindakan_array->response->list;
           }
       }


        if ($model->load(Yii::$app->request->post())) {

                $result = $model->addTindakan($model->visit->noKunjungan, $model->kdTindakan, $model->biaya, $model->keterangan, $model->hasil);
$result_array = json_decode($result);
                if (isset($result_array->metaData->code)) {
                    if (isset($result_array->response->field)) {
                        Yii::$app->session->addFlash('success', json_encode($result));
                        $model->kdTindakanSK = $result_array->response->message;
                        $model->save();
                        return $this->redirect(['pcare/tindakan/view', 'id' => $id]);
                    } else {
                        Yii::$app->session->addFlash('warning', json_encode($result));
                    }
                } else {
                    Yii::$app->session->addFlash('warning', json_encode($result));
                }

//                $model->delete();

//                return $this->redirect(Yii::$app->request->referrer);
                return $this->redirect(['pcare/tindakan/view', 'id' => $id]);


        }


        return $this->render('create', [
            'model' => $model,
            'list' => $list
        ]);

    }

}
