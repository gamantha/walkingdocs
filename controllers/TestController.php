<?php

namespace app\controllers;
use app\models\Cachebyconsid;
use Yii;
use app\models\Consid;
use app\models\ConsidSearch;
use yii\httpclient\Client;
use app\models\Bpjs;
use app\models\Pendaftaran;
use app\models\PendaftaranSearch;
use app\models\Kunjungan;
use yii\helpers\ArrayHelper;



class TestController extends \yii\web\Controller
{


    public function actionAddpendaftaran($id)
    {
        $res = Bpjs::addPendaftaran($id);
        echo '<pre>';
        print_r($res);
    }

    public function actionGetspesialis()
    {
        $res = Bpjs::getSpesialis();
        echo '<pre>';
        print_r($res);
    }

    public function actionGetkhusus()
    {
        $res = Bpjs::getKhusus();
        echo '<pre>';
        print_r($res);
    }

    public function actionGetsubspesialis($id)
    {
        $res = Bpjs::getSubspesialis($id);
        echo '<pre>';
        print_r($res);
    }

    public function actionGetsarana()
    {
        $res = Bpjs::getSarana();
        echo '<pre>';
        print_r($res);
    }

    public function actionTime()
    {
        $model = Cachebyconsid::findOne('2');
        $datetime1 = new \Datetime($model->modified_at);
        echo '<br/>';
        date_default_timezone_set('UTC');
        $datetime2 = new \Datetime(date('Y-m-d H:i:s'));

        $interval = $datetime2->diff($datetime1);

        if ($interval->days >= 1) {
            echo 'More than 24 hours ago.';
        } else {
            echo 'less than 24 hours.';
        }

    }


    public function actionGetfaskesrujukansubspesialis()
    {
        $res = Bpjs::getFaskesrujukansubspesialis('26', '1','28-11-2019');
        echo '<pre>';
        $json = json_decode($res);
        print_r($res);
    }

    public function actionGetfaskesrujukankhusus()
    {
        $res = Bpjs::getFaskesrujukankhusus('HEM', '3','0000039043765','27-11-2019');
        echo '<pre>';
        $json = json_decode($res);
        print_r($res);
    }



    public function actionStatuspulang()
    {
        $res = Bpjs::getStatuspulang('true');
        echo '<pre>';
        $json = json_decode($res);
        //$attribute = 'response';
       // $command = 'print_r($json->'.$attribute.')';
     //eval($command . ';');
     //echo eval('echo "sada";');
    }

    public function actionGetdokter()
    {
        $res = Bpjs::getDokter();
        $response = json_decode($res);

        $kdDokters = ArrayHelper::map($response->response->list, 'kdDokter', 'nmDokter');
        /*foreach ($response->response->list as $dokter) {
            echo $dokter->kdDokter;
            echo $dokter->nmDokter;
        }
        */
        echo '<pre>';
        print_r($kdDokters);
    }

    public function actionGetpoli()
    {
        $poliList = Bpjs::getPoli();
        $response = json_decode($poliList);

        print_r($response);
    }


    public function actionGetobat()
    {
        $poliList = Bpjs::getObat('1301');
        $response = json_decode($poliList);

        print_r($response);
     //   echo 'emd';
    }

    public function actionAddkunjungan()
    {
        $res = Bpjs::addKunjungan('16');
        echo '<pre>';
        print_r($res);

    }

    public function actionGetprovider() {
        $res = Bpjs::getProvider();
        echo '<pre>';
        print_r($res);
    }

    public function actionTest()
    {
        $kunjunganModel = Kunjungan::findOne('2');
        echo '<pre>';
        //print_r($kunjunganModel);
        echo date("d-m-Y" , strtotime($kunjunganModel->tanggal_kunjungan));
    }
   

}
