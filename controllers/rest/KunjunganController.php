<?php
namespace app\controllers\rest;

use yii\rest\ActiveController;
use yii\helpers\Url;
use app\models\Peserta;
use app\models\Pendaftaran;
use app\models\Kunjungan;
use Yii;

class KunjunganController extends ActiveController
{
    public $modelClass = 'app\models\Kunjungan';


}

?>