<?php

namespace app\controllers\bpjsintegration;
use Yii;
use app\models\Consid;
use app\models\ConsidSearch;
use yii\httpclient\Client;
use app\models\Bpjs;
use app\models\Pendaftaran;
use app\models\PendaftaranSearch;
use app\models\Kunjungan;
use app\models\Peserta;
use app\models\Rujukan;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

use yii\db\Query;



class PesertaController extends \yii\web\Controller
{



    public function actionTest()
    {
        return 'rete';
    }



}
