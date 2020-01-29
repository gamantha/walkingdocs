<?php

namespace app\controllers;
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



class BpjsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new PendaftaranSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/pendaftaran/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRegistration()
    {


    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    //'popup'  => ['POST','PUT'],
                    //'view'   => ['GET'],
                    //'create' => ['GET', 'POST'],
                    //'update' => ['GET', 'PUT', 'POST'],
                    //'delete' => ['POST', 'DELETE'],
                ],
            ],
        ];
    }


    public function actionRujukan($id)
    {
        $kunjunganModel = Kunjungan::findOne($id);
        $rujukanModel = Rujukan::find()->andWhere(['kunjungan_id' => $id])->One();
        if (is_null($rujukanModel)) {
            $rujukanModel = new Rujukan();
            $rujukanModel->kunjungan_id = $id;
        }

        if ($post = \Yii::$app->request->post()){
            $rujukanModel->tipe_rujukan = $post['Rujukan']['tipe_rujukan'];
            $rujukanModel->kdSpesialis = $post['Rujukan']['kdSpesialis'];
            $rujukanModel->tanggal_estimasi = $post['Rujukan']['tanggal_estimasi'];
            $rujukanModel->kdSubSpesialis1 = $post['Rujukan']['kdSubSpesialis1'];
            $rujukanModel->kdSarana = $post['Rujukan']['kdSarana'];
            $rujukanModel->kdppk = $post['Rujukan']['kdppk'];

            $rujukanModel->kdKhusus = $post['Rujukan']['kdKhusus'];
            $rujukanModel->kdSubSpesialisKhusus = $post['Rujukan']['kdSubSpesialisKhusus'];
            $rujukanModel->kdPpkKhusus = $post['Rujukan']['kdPpkKhusus'];


            if ($rujukanModel->validate()) {
                $rujukanModel->save();
                Yii::$app->session->setFlash('success', 'SAVED');
                // all inputs are valid
                return $this->redirect(Url::previous());
            } else {
                // validation failed: $errors is an array containing error messages
                $errors = $rujukanModel->errors;
             //   Yii::$app->session->setFlash('success', json_encode($errors));
            }

            //print_r(Yii::$app->request->post());


        }
        return $this->render('rujukan', [
            'kunjungan_model' => $kunjunganModel,
            'rujukanModel' => $rujukanModel,
        ]);
    }

    public function actionRujukansimple($id)
    {
        $kunjunganModel = Kunjungan::findOne($id);
        $rujukanModel = Rujukan::find()->andWhere(['kunjungan_id' => $id])->One();
        if (is_null($rujukanModel)) {
            $rujukanModel = new Rujukan();
            $rujukanModel->kunjungan_id = $id;
        }

        if ($post = \Yii::$app->request->post()){
            $rujukanModel->tipe_rujukan = $post['Rujukan']['tipe_rujukan'];
            $rujukanModel->kdSpesialis = $post['Rujukan']['kdSpesialis'];
            $rujukanModel->tanggal_estimasi = $post['Rujukan']['tanggal_estimasi'];
            $rujukanModel->kdSubSpesialis1 = $post['Rujukan']['kdSubSpesialis1'];
            $rujukanModel->kdSarana = $post['Rujukan']['kdSarana'];
            $rujukanModel->kdppk = $post['Rujukan']['kdppk'];

            //$rujukanModel->kdKhusus = $post['Rujukan']['kdKhusus'];
            //$rujukanModel->kdSubSpesialisKhusus = $post['Rujukan']['kdSubSpesialisKhusus'];
            //$rujukanModel->kdPpkKhusus = $post['Rujukan']['kdPpkKhusus'];


            if ($rujukanModel->validate()) {
                $rujukanModel->save();
                Yii::$app->session->setFlash('success', 'SAVED');
                // all inputs are valid
                return $this->redirect(['popup','id'=>$id]);
            } else {
                // validation failed: $errors is an array containing error messages
                $errors = $rujukanModel->errors;
                //   Yii::$app->session->setFlash('success', json_encode($errors));
            }

            //print_r(Yii::$app->request->post());


        }
        $this->layout = 'popuplayout';
        return $this->render('rujukansimple', [
            'kunjunganModel' => $kunjunganModel,
            'rujukanModel' => $rujukanModel,
        ]);
    }

    public function actionClosethispage($id)
    {
        echo 'you can close this page';
    }

    public function actionObat($id)
    {
        $kunjunganModel = Kunjungan::findOne($id);
        $rujukanModel = Rujukan::find()->andWhere(['kunjungan_id' => $id])->One();
        if (is_null($rujukanModel)) {
            $rujukanModel = new Rujukan();
            $rujukanModel->kunjungan_id = $id;
        }

        if ($post = \Yii::$app->request->post()){


        }
        return $this->render('rujukan', [
            'kunjungan_model' => $kunjunganModel,
            'rujukanModel' => $rujukanModel,
        ]);
    }

    public function actionCekpeserta()
    {

        $model = new Bpjs;
        $isexist = false;
        $response = '';

        if (Yii::$app->request->post()) {

            $post = Yii::$app->request->post();
            $model->no_bpjs = $post['Bpjs']['no_bpjs'];
            $response = $this->actionCek($model->no_bpjs);

            if (is_null($response)) {

            } else {
                if ($response->metaData->code == '200') {
                $model->loadData($response->response);

                $isexist = true;
                } else {
                    Yii::$app->session->setFlash('warning', json_encode($response));
                }

            }

            switch (\Yii::$app->request->post('submit1')) {
                case 'cek':
                    //Yii::$app->session->addFlash('success', "CEK");
                    break;
                case 'register':
                    $registrasi = new Pendaftaran();
                    $registrasi->no_bpjs = $model->no_bpjs;
                    $registrasi->nama = $model->nama;
                    $registrasi->status_peserta = $model->ket_aktif;
                    $registrasi->jenis_peserta = $model->jenisPesertaNama;
                    $registrasi->save();
                    Yii::$app->session->addFlash('success', "REGISTER");
                    return $this->redirect(['index']);
                    break;
             }


        }

        return $this->render('cekpeserta', [
            'model' => $model,
            'isexist' => $isexist,
            'response' => $response
        ]);


    }

    public function actionAddpendaftaran($id)
    {
        $res = Bpjs::addPendaftaran($id);
        echo '<pre>';
        print_r($res);
/*
        if ($res != null) {
            $json_response = json_decode($res);
            if ($json_response->metaData->code == '200') {
            } else {
                Yii::$app->session->setFlash('warning', $json_response->response[0]->message);
            }
    echo '<pre>';
    print_r($json_response);
            //return $json_response;
        } else {
            return null;
        }
*/
    }
    public function actionKunjungantobpjs($id)
    {

        $arrayvalue = [];
        $json_tosend = '';
        $kunjungan = Kunjungan::findOne($id);
        $arrayvalue['id'] = $id;
        $arrayvalue['noKartu'] = null;
        $arrayvalue['tglDaftar'] = null;
        $arrayvalue['kdPoli'] = null;
        $arrayvalue['keluhan'] = $kunjungan->keluhan;
        $arrayvalue['kdSadar'] = $kunjungan->kode_sadar;
        $arrayvalue['diastole'] = $kunjungan->diastole;
        $arrayvalue['sistole'] = $kunjungan->sistole;
        $arrayvalue['tinggiBadan'] = $kunjungan->tinggi_badan;
        $arrayvalue['beratBadan'] = $kunjungan->berat_badan;
        $arrayvalue['respRate'] = $kunjungan->respiratory_rate;
        $arrayvalue['heartRate'] = $kunjungan->heart_rate;





        $json_tosend = json_encode($arrayvalue);
        echo '<pre/>';
        print_r($arrayvalue);
        
    }
    public function actionFaskes() #for dependent dropdown
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $sarana_id = $parents[0];
                $subspesialis_id = $parents[1];
                $date = $parents[2];

                $out = self::depdropFaskes($sarana_id, $subspesialis_id, $date);


                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    public function actionFaskeskhusus() #for dependent dropdown
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $spesialis_id = $parents[0];
                $subspesialis_id = $parents[1];
                $kunjunganid = $parents[2];
                $date = $parents[3];
                $kunjunganmodel = Kunjungan::findOne($kunjunganid);
                $kartuNo = $kunjunganmodel->pendaftaran->no_bpjs;

                $out = self::depdropFaskeskhusus($spesialis_id, $subspesialis_id, $kartuNo, $date);


                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }


    //only for THA & HEM
    public function actionSubspesialiskhusus() #for dependent dropdown
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $param1 = null;
                $param2 = null;
                if (!empty($_POST['depdrop_params'])) {
                    $params = $_POST['depdrop_params'];
                    $param1 = $params[0]; // get the value of input-type-1
                    $param2 = $params[1]; // get the value of input-type-2
                }

                $out = self::depdropSubspesialiskhusus($cat_id);


                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }
    public function actionSubspesialis() #for dependent dropdown
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $param1 = null;
                $param2 = null;
                if (!empty($_POST['depdrop_params'])) {
                    $params = $_POST['depdrop_params'];
                    $param1 = $params[0]; // get the value of input-type-1
                    $param2 = $params[1]; // get the value of input-type-2
                }

                $out = self::depdropSubspesialis($cat_id);


                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }
    public function actionSubcatpoli()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];

                $out = self::getPolibytipe($cat_id);


                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }
    
    public function actionCheckpeserta($no_bpjs)
    {
        $res = Bpjs::getPeserta($no_bpjs);
        if ($res != null) {
        $json_response = json_decode($res);

        //print_r($json_response->response->noKartu);

        if ($json_response->metaData->code == '200') {
     
            
        } else {
            Yii::$app->session->setFlash('warning', $json_response->response[0]->message);
        
            
        }
        echo "<pre>";
        print_r($json_response);
        $json_response;
    } else {
        return null;
    }
 
    }

    public function actionDelkunjungan($id)
    {
        $pendaftaranModel = Pendaftaran::findOne($id);
        $kunjunganModel = Kunjungan::find()->andWhere(['pendaftaran_id' => $id])->One();
        $res = Bpjs::deleteKunjungan($kunjunganModel->id);
        $kunjunganModel->bpjs_kunjungan_response = null;
        $kunjunganModel->bpjs_kunjungan_status = null;
        $kunjunganModel->bpjs_kunjungan_no = null;
        $pendaftaranModel->bpjs_pendaftaran_response = null;
        $pendaftaranModel->bpjs_pendaftaran_status = null;
        $pendaftaranModel->bpjs_pendaftaran_nourut = null;
        $pendaftaranModel->save();
        $kunjunganModel->save();
        Yii::$app->session->setFlash('warning', json_encode($res));
        return $this->redirect(['index']);

    }

    public function actionCek($no_bpjs)
    {
        $res = Bpjs::getPeserta($no_bpjs);
        if ($res != null) {
        $json_response = json_decode($res);
        if ($json_response->metaData->code == '200') {
            $peserta = Peserta::findOne($no_bpjs);
            if (is_null($peserta)){
                $peserta = New Peserta();
                $peserta->bpjs_no = $no_bpjs;

            } 
            $peserta->json_data = json_encode($json_response->response);
            $peserta->save();
            Yii::$app->session->setFlash('success', json_encode($json_response));
        } else {
            Yii::$app->session->setFlash('warning', json_encode($json_response));
        }

        return $json_response;
    } else {
        return null;
    }


    }

    public function depdropFaskes($sarana, $spesialis, $date)
    {
        $out = [];

        $poliList = json_decode(Bpjs::getFaskesrujukansubspesialis($spesialis,$sarana,$date));
        if ($poliList->metaData->code != '200') {
            array_push($out, ['id' => 'null', 'name' => 'tidak ada faskes dengan subspesialis/sarana/tanggal yang sesuai']);
            return $out;
        } else {

            foreach ($poliList->response->list as $poli) {
                array_push($out, ['id' => $poli->kdppk, 'name' => $poli->nmppk]);
            }
            return $out;
        }
    }

    public function depdropFaskeskhusus($spesialis, $subspesialis, $kartuNo, $date)
    {
        //DISINI HARUIS BEDAIN ANTARA KHUSUS BIASA DAN KHUSUS THA DAN HEM
        $out = [];

        $poliList = json_decode(Bpjs::getFaskesrujukankhusus($spesialis,$subspesialis,$kartuNo,$date));
        if ($poliList->metaData->code != '200') {
            array_push($out, ['id' => 'null', 'name' => 'tidak ada faskes dengan subspesialis/sarana/tanggal yang sesuai']);
            return $out;
        } else {

            foreach ($poliList->response->list as $poli) {
                array_push($out, ['id' => $poli->kdppk, 'name' => $poli->nmppk]);
            }
            return $out;
        }
    }


    public function depdropSubspesialiskhusus($spesialis)
    {


        $out = [];
        //$poliList = json_decode(Bpjs::getSubspesialis($spesialis));
        $khusus_array = ['THA', 'HEM'];
        if (in_array($spesialis, $khusus_array))
        {
            $subspesialiskhusus_list=[
                ['id' => '3', 'name' => 'PENYAKIT DALAM'],
                ['id' => '8', 'name' => 'HEMATOLOGI - ONKOLOGI MEDIK'],
                ['id' => '26', 'name' => 'ANAK'],
                ['id' => '30', 'name' => 'ANAK HEMATOLOGI ONKOLOGI']
            ];
        } else {
            $subspesialiskhusus_list=[
                ['id' => '0', 'name' => 'NOT APPLICABLE']
            ];
        }

        return $subspesialiskhusus_list;
    }

    public function depdropSubspesialis($spesialis)
    {
        $out = [];
        $poliList = json_decode(Bpjs::getSubspesialis($spesialis));
        foreach ($poliList->response->list as $poli){
                array_push($out, ['id' => $poli->kdSubSpesialis,'name' => $poli->nmSubSpesialis]);
        }
            return $out;
    }
    public function getPolibytipe($issakit)
    {
        $out = [];
        $out2 = [];
        $poliList = json_decode(Bpjs::getPoli());
        foreach ($poliList->response->list as $poli){
           if($poli->poliSakit == true) {
                array_push($out, ['id' => $poli->kdPoli,'name' => $poli->nmPoli]);
            } else {
               array_push($out2, ['id' => $poli->kdPoli,'name' => $poli->nmPoli]);
            }

        }

        if ($issakit == 'sakit') {
            return $out;
        } else {
            return $out2;
        }
    }
    public function actionKunjungan($id)
    {
        Url::remember();
        $polisakit=[];
        $polinonsakit=[];
        $kunjunganModel = Kunjungan::find()->andWhere(['pendaftaran_id' => $id])->One(); // BELUM TENTU ADA. kalau belum bikin new object
      //  $pendaftaran_model = Pendaftaran::findOne($id); //SUDAH PSTI ADA


        if (isset($kunjunganModel))
        {

        } else {
            $kunjunganModel = new Kunjungan;
            $kunjunganModel->pendaftaran_id = $id;


        }





        if (Yii::$app->request->isAjax) {
            Yii::$app->session->setFlash('danger', 'AJAX REQUEST');
        }

        if (\Yii::$app->request->post()){
            $post = \Yii::$app->request->post();

            $kunjunganModel->sistole = $post['Kunjungan']['sistole'];
            $kunjunganModel->diastole = $post['Kunjungan']['diastole'];
            $kunjunganModel->tinggi_badan = $post['Kunjungan']['tinggi_badan'];
            $kunjunganModel->berat_badan = $post['Kunjungan']['berat_badan'];
            $kunjunganModel->keluhan = $post['Kunjungan']['keluhan'];
            $kunjunganModel->respiratory_rate = $post['Kunjungan']['respiratory_rate'];
            $kunjunganModel->heart_rate = $post['Kunjungan']['heart_rate'];
            $kunjunganModel->imt = $post['Kunjungan']['imt'];
            $kunjunganModel->terapi = $post['Kunjungan']['terapi'];
            $kunjunganModel->lingkar_perut = $post['Kunjungan']['lingkar_perut'];
            $kunjunganModel->perawatan = $post['Kunjungan']['perawatan'];
            $kunjunganModel->kode_sadar = $post['Kunjungan']['kode_sadar'];
            $kunjunganModel->kode_dokter = $post['Kunjungan']['kode_dokter'];
            $kunjunganModel->jenis_kunjungan = $post['Kunjungan']['jenis_kunjungan'];
            $kunjunganModel->poli_tujuan = $post['Kunjungan']['poli_tujuan'];
            $kunjunganModel->tanggal_kunjungan = $post['Kunjungan']['tanggal_kunjungan'];
            $kunjunganModel->kode_status_pulang = $post['Kunjungan']['kode_status_pulang'];
            if (strlen($post['Kunjungan']['kode_diagnosa1']) > 1)
                $kunjunganModel->kode_diagnosa1 = $post['Kunjungan']['kode_diagnosa1'];
            if (strlen($post['Kunjungan']['kode_diagnosa2']) > 1)
                $kunjunganModel->kode_diagnosa2 = $post['Kunjungan']['kode_diagnosa2'];
            if (strlen($post['Kunjungan']['kode_diagnosa3']) > 1)
                $kunjunganModel->kode_diagnosa3 = $post['Kunjungan']['kode_diagnosa3'];


            switch (\Yii::$app->request->post('submit1')) {
                case 'save':
                    $kunjunganModel->save();
                    //$rujukanModel->kunjungan_id =  $kunjungan_model->id;
                    //$rujukanModel->save();
                    Yii::$app->session->setFlash('success', 'SAVED');
                    return $this->redirect('index');
                    break;
                case 'addpendaftaran':
                    $kunjunganModel->save();
                    $res = Bpjs::addPendaftaran($kunjunganModel->id);
                    $json_res = json_decode($res);
                    $kunjunganModel->pendaftaran->bpjs_pendaftaran_response = $res;
                    $kunjunganModel->pendaftaran->bpjs_pendaftaran_status = $json_res->metaData->message;
                    if ($json_res->response->field == 'noUrut') {
                        if  (strpos($json_res->response->message,'null') == false) {
                            $kunjunganModel->pendaftaran->bpjs_pendaftaran_nourut = $json_res->response->message;

                            if ($kunjunganModel->pendaftaran->save()) {
//                                $rujukanModel->kunjungan_id =  $kunjungan_model->id;
//                                $rujukanModel->save();
                                Yii::$app->session->setFlash('success', $res);
                            } else {
                                Yii::$app->session->setFlash('danger', json_encode($kunjunganModel->pendaftaran->errors));
                            }
                        } else {
                            Yii::$app->session->setFlash('danger', json_encode($res));
                        }
                      
                    } else {
                        Yii::$app->session->setFlash('danger', $json_res->metaData->message);
                    }
                    

                    
                    break;
                case 'addkunjungan':
                    $kunjunganModel->save();
//                    $rujukanModel->save();
                    $res = Bpjs::addKunjungan($kunjunganModel->id);
                    $json_res = json_decode($res);
                    $kunjunganModel->bpjs_kunjungan_response = $res;
                    $kunjunganModel->bpjs_kunjungan_status = $json_res->metaData->message;
                    //response can be an ARRAY if the response is an error. if response is a success then its only one element
                    if (is_array($json_res->response)) {
                        foreach($json_res->response as $response) {
                            if ($response->field == 'noKunjungan') {
                                if  (strpos($response->message,'null') == false) {
                                    $kunjunganModel->bpjs_kunjungan_no = $response->message;
        
                                    if ($kunjungan_model->save()) {

                                        Yii::$app->session->setFlash('success', $res);
                                    } else {
                                        Yii::$app->session->setFlash('danger', json_encode($kunjunganModel->errors));
                                    }
                                } else {
                                    Yii::$app->session->setFlash('danger', 'no urut null');
                                }
                              
                            } else {
                                Yii::$app->session->setFlash('danger', json_encode($json_res));
                            }
                        }
    
                    } else {
                        if (isset($json_res->response->field)) {
                            if ($json_res->response->field == 'noKunjungan') {
                                if  (strpos($json_res->response->message,'null') == false) {
                                    $kunjunganModel->bpjs_kunjungan_no = $json_res->response->message;
        
                                    if ($kunjunganModel->save()) {
//                                        $rujukanModel->kunjungan_id =  $kunjungan_model->id;
//                                        $rujukanModel->save();
                                        Yii::$app->session->setFlash('success', $res);
                                    } else {
                                        Yii::$app->session->setFlash('danger', json_encode($kunjunganModel->errors));
                                    }
                                } else {
                                    Yii::$app->session->setFlash('danger', 'no urut null');
                                }
                              
                            } else {
                                Yii::$app->session->setFlash('danger', $json_res->metaData->message);
                            }
                        } else { //property doesnt exost
                            Yii::$app->session->setFlash('danger', $json_res->response);
                        }

                    }



                    
                    break;
             }


            //$pendaftaran_model->loadpost(Yii::$app->request->post());
           // $kunjungan_model->load(Yii::$app->request->post());

        } else {
            
        }

        return $this->render('kunjungan', [
            'kunjungan_model' => $kunjunganModel,

        ]);
        
    }





    public function actionIcd10list($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('icd10, name AS text')
                ->from('icd10')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Icd10::find($id)->name];
        }
        return $out;
    }


    public function actionPopup($id) {

        $kunjunganModel = Kunjungan::findOne($id);

        switch (\Yii::$app->request->post('submit1')) {
            case 'send':
                if (\Yii::$app->request->post()) {
                    $post = \Yii::$app->request->post();
                    print_r($post);
                    $kunjunganModel->sistole = $post['Kunjungan']['sistole'];
                    $kunjunganModel->diastole = $post['Kunjungan']['diastole'];
                    $kunjunganModel->tinggi_badan = $post['Kunjungan']['tinggi_badan'];
                    $kunjunganModel->berat_badan = $post['Kunjungan']['berat_badan'];
                    $kunjunganModel->keluhan = $post['Kunjungan']['keluhan'];
                    $kunjunganModel->terapi = $post['Kunjungan']['terapi'];
                    $kunjunganModel->respiratory_rate = $post['Kunjungan']['respiratory_rate'];
                    $kunjunganModel->heart_rate = $post['Kunjungan']['heart_rate'];
                    $kunjunganModel->imt = $post['Kunjungan']['imt'];
                    $kunjunganModel->lingkar_perut = $post['Kunjungan']['lingkar_perut'];
                    $kunjunganModel->perawatan = $post['Kunjungan']['perawatan'];
                    $kunjunganModel->kode_sadar = $post['Kunjungan']['kode_sadar'];
                    $kunjunganModel->kode_dokter = $post['Kunjungan']['kode_dokter'];
                    $kunjunganModel->jenis_kunjungan = $post['Kunjungan']['jenis_kunjungan'];
                    $kunjunganModel->poli_tujuan = $post['Kunjungan']['poli_tujuan'];
                    $kunjunganModel->tanggal_kunjungan = $post['Kunjungan']['tanggal_kunjungan'];
                    $kunjunganModel->kode_status_pulang = $post['Kunjungan']['kode_status_pulang'];
                    if (strlen($post['Kunjungan']['kode_diagnosa1']) > 1)
                        $kunjunganModel->kode_diagnosa1 = $post['Kunjungan']['kode_diagnosa1'];
                    if (strlen($post['Kunjungan']['kode_diagnosa2']) > 1)
                        $kunjunganModel->kode_diagnosa2 = $post['Kunjungan']['kode_diagnosa2'];
                    if (strlen($post['Kunjungan']['kode_diagnosa3']) > 1)
                        $kunjunganModel->kode_diagnosa3 = $post['Kunjungan']['kode_diagnosa3'];


                                    $kunjunganModel->save();
                                    //$rujukanModel->kunjungan_id =  $kunjungan_model->id;
                                    //$rujukanModel->save();
                                    Yii::$app->session->setFlash('success', 'SENT');
                                    return $this->redirect(['closethispage', 'id'=>$id]);
                                    break;

                }
        }

        $this->layout = 'popuplayout';
        return $this->render('popup', [
            'kunjunganModel' => $kunjunganModel,
            //'rujukanModel' => $rujukanModel,
        ]);

    }

    public function actionSubcat() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = self::getSubCatList($cat_id); 
                $out = [
                    1 => 'Electronics',
                    2 => 'Books',
                    3 => 'Home & Kitchen'
                ];

                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }


    public function beforeAction($action)
    {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

        if (!parent::beforeAction($action)) {
            return false;
        }
        $consids = \app\models\UserCons::find()->andWhere(['userid' => yii::$app->user->id])->All();
  if(sizeof($consids) == 0) {
      Yii::$app->session->setFlash('danger', 'NO CONSID');
      //return false;

      return $this->redirect('site/noconsid');
  }

        //return true; // or false to not run the action

        return parent::beforeAction($action);
    }



}
