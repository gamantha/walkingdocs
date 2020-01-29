<?php

namespace app\models;

use app\models\Cachebyconsid;

use Yii;
use yii\base\Model;
use app\models\Consid;
use yii\httpclient\Client;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Bpjs extends Model
{
    public $no_bpjs;
    public $nama;
    public $sex;
    public $tanggal_lahir;
    public $tanggal_mulai_aktif;
    public $tanggal_akhir_berlaku;
    public $nohp;
    public $noktp;
    public $gol_darah;
    public $aktif;
    public $ket_aktif;
    public $tunggakan;

    public $jenisKelasKode;
    public $jenisKelasNama;
    public $jenisPesertaKode;
    public $jenisPesertaNama;
    

    static $globalConsId = '30428';
    static $globalWdId = 'wdid1';

    static $globalKdProviderPeserta = '0114U163';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
          //  [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
          //  ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
           // ['password', 'validatePassword'],
        ];
    }

    public function loadData($data)
    {
        $this->nama = $data->nama;
        $this->sex = $data->sex;
        $this->tanggal_lahir = $data->tglLahir;
        $this->tanggal_mulai_aktif = $data->tglMulaiAktif;
        $this->tanggal_akhir_berlaku = $data->tglAkhirBerlaku;

        $this->nohp = $data->noHP;
        $this->noktp = $data->noKTP;
        $this->gol_darah = $data->golDarah;
        $this->aktif = $data->aktif;
        $this->ket_aktif = $data->ketAktif;
        $this->tunggakan = $data->tunggakan;

        $this->jenisKelasKode = $data->jnsKelas->kode;
        $this->jenisKelasNama = $data->jnsKelas->nama;
        $this->jenisPesertaKode = $data->jnsPeserta->kode;
        $this->jenisPesertaNama = $data->jnsPeserta->nama;


    }
    public function getSpesialis()
    {

        $bpjs_user = self::getUsercreds(self::$globalWdId);
        $model = Cachebyconsid::find()->andWhere(['consId' => $bpjs_user['cons_id']])->One();
        if(self::isDataOld($model) || is_null($model->spesialis_list)) {
            try {
                //code...

                $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis']);
                $request = $client->createRequest()
                    ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                    ->addHeaders(['content-type' => 'application/json'])
                    ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                    ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                    ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

                $response = $request->send();

                if ((json_encode(json_decode($response->content)->metaData->code) < 300) && (json_encode(json_decode($response->content)->metaData->code) >= 200)) {
                    //success 200
                    self::addCachebyconsid($bpjs_user['cons_id'], $response->content, 'spesialis');
                    //return json_encode(json_decode($response->content)->metaData->code);
                } else {
                    //anything but success
                    if(is_null($model)) {
                        return $response->content;
                    } else {
                        return $model->json_data;
                    }
                }



                return $response->content;
            } catch (\yii\base\Exception $exception) {
                //return null;
                Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
            }
        } else {
            return $model->spesialis_list;
        }
    }

    public function getKhusus()
    {

        $bpjs_user = self::getUsercreds(self::$globalWdId);
        $model = Cachebyconsid::find()->andWhere(['consId' => $bpjs_user['cons_id']])->One();
        if(self::isDataOld($model) || is_null($model->khusus_list)) {
            try {
                //code...

                $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/khusus']);
                $request = $client->createRequest()
                    ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                    ->addHeaders(['content-type' => 'application/json'])
                    ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                    ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                    ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

                $response = $request->send();
                if ((json_encode(json_decode($response->content)->metaData->code) < 300) && (json_encode(json_decode($response->content)->metaData->code) >= 200)) {
                    //success 200
                    self::addCachebyconsid($bpjs_user['cons_id'], $response->content, 'khusus');
                    //return json_encode(json_decode($response->content)->metaData->code);
                } else {
                    //anything but success
                    if(is_null($model)) {
                        return $response->content;
                    } else {
                        return $model->json_data;
                    }
                }


                return $response->content;
            } catch (\yii\base\Exception $exception) {
                //return null;
                Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
            }
        } else {
            return $model->khusus_list;
        }
    }


    public function getObat($keyword)
    {

        $bpjs_user = self::getUsercreds(self::$globalWdId);

            try {
                //code...

                $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/obat/dpho/'.$keyword.'/0/9999']);
                $request = $client->createRequest()
                    ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                    ->addHeaders(['content-type' => 'application/json'])
                    ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                    ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                    ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

                $response = $request->send();

                return $response->content;
            } catch (\yii\base\Exception $exception) {
                //return null;
                Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
                Yii::$app->session->setFlash('danger', 'ERROR GETTING RESPONSE FROM BPJS.');
            }

    }
    public function getPoli()
    {
      
      $bpjs_user = self::getUsercreds(self::$globalWdId);
        $model = Cachebyconsid::find()->andWhere(['consId' => $bpjs_user['cons_id']])->One();
        if(self::isDataOld($model) || is_null($model->poli_list)) {
      try {
        //code...

      $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/poli/fktp/0/999']);
      $request = $client->createRequest()
      ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
      ->addHeaders(['content-type' => 'application/json'])
      ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
      ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
      ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);
      
      $response = $request->send();
          if ((json_encode(json_decode($response->content)->metaData->code) < 300) && (json_encode(json_decode($response->content)->metaData->code) >= 200)) {
              //success 200
              self::addCachebyconsid($bpjs_user['cons_id'], $response->content, 'poli');
              //return json_encode(json_decode($response->content)->metaData->code);
          } else {
              //anything but success
              if(is_null($model)) {
                  return $response->content;
              } else {
                  return $model->json_data;
              }
          }
      return $response->content;
    } catch (\yii\base\Exception $exception) {
     //return null;
     Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
          Yii::$app->session->setFlash('danger', 'ERROR GETTING RESPONSE FROM BPJS.');
    }
        } else {
            return $model->poli_list;
        }
    }

    public function isDataOld($model)
    {

        if (isset($model)) {
            $datetime1 = new \Datetime($model->modified_at);
            date_default_timezone_set('UTC');
            $datetime2 = new \Datetime(date('Y-m-d H:i:s'));
            $interval = $datetime2->diff($datetime1);

            if ($interval->days < 1) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }

    }
    public function getSarana() //cache enabled DONE
    {
        //if data is current (less than a day) get from cache
        $bpjs_user = self::getUsercreds(self::$globalWdId);
        $model = Cachebyconsid::find()->andWhere(['consId' => $bpjs_user['cons_id']])->One();
        if(self::isDataOld($model)|| is_null($model->sarana_list)) {
            try {
                //code...

                $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/sarana']);
                $request = $client->createRequest()
                    ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                    ->addHeaders(['content-type' => 'application/json'])
                    ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                    ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                    ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

                $response = $request->send();
                if ((json_encode(json_decode($response->content)->metaData->code) < 300) && (json_encode(json_decode($response->content)->metaData->code) >= 200)) {
                    //success 200
                    self::addCachebyconsid($bpjs_user['cons_id'], $response->content, 'sarana');
                    //return json_encode(json_decode($response->content)->metaData->code);
                } else {
                    //anything but success
                    if(is_null($model)) {
                        return $response->content;
                    } else {
                        return $model->json_data;
                    }
                }
                return $response->content;
            } catch (\yii\base\Exception $exception) {
                //return null;
                Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
            }
        } else {
            return $model->sarana_list;
        }


    }



    public function addCachepeserta($bpjs_no, $data){
        $cache = Peserta::find()->andWhere(['bpjs_no' => $bpjs_no])->One();
        $cache->json_data = $data;
        if (isset($cache->created_at)) {
            $cache->modified_at = date('Y-m-d H:i:s');
        } else {
            $cache->created_at = date('Y-m-d H:i:s');
            $cache->modified_at = date('Y-m-d H:i:s');
        }

        $cache->save();

    }
    public function addCachebyconsid($consId, $data, $type)
    {
        $col = $type . '_list';
        $cache = Cachebyconsid::find()->andWhere(['consId' => $consId])->One();
        if (isset($cache))
        {

        } else {
            $cache = new Cachebyconsid();
            $cache->consId = $consId;
        }
        $command = '$cache->' .$col . ' = $data';
        eval($command . ';');
        if (isset($cache->created_at)) {
            $cache->modified_at = date('Y-m-d H:i:s');
        } else {
            $cache->created_at = date('Y-m-d H:i:s');
            $cache->modified_at = date('Y-m-d H:i:s');
        }

        $cache->save();


    }
    public function getFaskesrujukansubspesialis($subspesialis, $sarana, $date)
    {
        $bpjs_user = self::getUsercreds(self::$globalWdId);
        try {
            //code...
            $tanggal = date("d-m-Y" , strtotime($date));
            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/rujuk/subspesialis/'.$subspesialis.'/sarana/' .$sarana . '/tglEstRujuk/' . $tanggal]);
            $request = $client->createRequest()
                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

            $response = $request->send();
            return $response->content;
        } catch (\yii\base\Exception $exception) {
            //return null;
            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
            //return null;
        }

    }

    public function getFaskesrujukankhusus($spesialis, $subspesialis, $noKartu,$date)
    {
        $bpjs_user = self::getUsercreds(self::$globalWdId);
        try {
            //code...
            $tanggal = date("d-m-Y" , strtotime($date));

            $khusus_array = ['THA', 'HEM'];
            if (in_array($spesialis, $khusus_array))
            {


                $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/rujuk/khusus/'.$spesialis.'/subspesialis/'.$subspesialis.'/noKartu/' .$noKartu . '/tglEstRujuk/' . $tanggal]);

            } else {
                $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/rujuk/khusus/'.$spesialis.'/noKartu/' .$noKartu . '/tglEstRujuk/' . $tanggal]);
            }

            $request = $client->createRequest()
                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

            $response = $request->send();
            return $response->content;
        } catch (\yii\base\Exception $exception) {
            //return null;
            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
            //return null;
        }

    }


    public function getSubspesialis($spesialis)
    {

        $bpjs_user = self::getUsercreds(self::$globalWdId);
        try {
            //code...

            $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/spesialis/'.$spesialis.'/subspesialis']);
            $request = $client->createRequest()
                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

            $response = $request->send();
            return $response->content;
        } catch (\yii\base\Exception $exception) {
            //return null;
            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
        }


    }

    public function getStatuspulang($rawatInap)
    {
      $bpjs_user = self::getUsercreds(self::$globalWdId);
        $model = Cachebyconsid::find()->andWhere(['consId' => $bpjs_user['cons_id']])->One();
        if(self::isDataOld($model) || is_null($model->statuspulangrawatinap_list) || is_null($model->statuspulang_list)) {
      try {
        //code...

      $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/statuspulang/rawatInap/' . $rawatInap]);
      $request = $client->createRequest()
      ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
      ->addHeaders(['content-type' => 'application/json'])
      ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
      ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
      ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);
      
      $response = $request->send();
      if ($rawatInap == 'true')
      {
          if ((json_encode(json_decode($response->content)->metaData->code) < 300) && (json_encode(json_decode($response->content)->metaData->code) >= 200)) {
              //success 200
              self::addCachebyconsid($bpjs_user['cons_id'], $response->content, 'statuspulangrawatinap');
              //return json_encode(json_decode($response->content)->metaData->code);
          } else {
              //anything but success
              if(is_null($model)) {
                  return $response->content;
              } else {
                  return $model->json_data;
              }
          }

      } else {
          if ((json_encode(json_decode($response->content)->metaData->code) < 300) && (json_encode(json_decode($response->content)->metaData->code) >= 200)) {
              //success 200
              self::addCachebyconsid($bpjs_user['cons_id'], $response->content, 'statuspulang');
              //return json_encode(json_decode($response->content)->metaData->code);
          } else {
              //anything but success
              if(is_null($model)) {
                  return $response->content;
              } else {
                  return $model->json_data;
              }
          }

      }


      return $response->content;
    } catch (\yii\base\Exception $exception) {
     //return null;
     Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
    }

        } else {
            if ($rawatInap == 'true') {
                return $model->statuspulangrawatinap_list;
            } else {
                return $model->statuspulang_list;
            }

        }


    }

    public function getDokter()
    {
      $bpjs_user = self::getUsercreds(self::$globalWdId);
        $model = Cachebyconsid::find()->andWhere(['consId' => $bpjs_user['cons_id']])->One();
        if(self::isDataOld($model)|| is_null($model->dokter_list)) {
      try {
        //code...

      $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/dokter/0/999']);
      $request = $client->createRequest()
      ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
      ->addHeaders(['content-type' => 'application/json'])
      ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
      ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
      ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);
      
      $response = $request->send();
          if ((json_encode(json_decode($response->content)->metaData->code) < 300) && (json_encode(json_decode($response->content)->metaData->code) >= 200)) {
              //success 200
              self::addCachebyconsid($bpjs_user['cons_id'], $response->content, 'dokter');
              //return json_encode(json_decode($response->content)->metaData->code);
          } else {
              //anything but success
              if(is_null($model)) {
                  return $response->content;
              } else {
                  return $model->json_data;
              }
          }
      return $response->content;
    } catch (\yii\base\Exception $exception) {
     //return null;
     Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
    }
        } else {
            return $model->dokter_list;
        }

    }

    public function getUsercreds($wdId)
    {
      $usercreds = [];
      $bpjs_user = Consid::find()->andWhere(['wd_id' => $wdId])->One();
      $usercreds['username'] = $bpjs_user->username;
      $usercreds['password'] = $bpjs_user->password;
      $usercreds['kdaplikasi'] = $bpjs_user->kdaplikasi;
      $usercreds['secretkey'] = $bpjs_user->secretkey;
      $usercreds['cons_id'] = $bpjs_user->cons_id;
      $auth_string = $bpjs_user->username . ':' . $bpjs_user->password . ':' . $bpjs_user->kdaplikasi;
      $usercreds['encoded_auth_string'] = 'Basic ' . base64_encode($auth_string);
      date_default_timezone_set('UTC');
      $usercreds['time'] = time();
      $message =  $bpjs_user->cons_id . '&' . $usercreds['time'];
      $sig = hash_hmac('sha256', $message, $bpjs_user->secretkey);
      
      $return = '';
      foreach(str_split($sig, 2) as $pair){
        $return .= chr(hexdec($pair));
      }

      $usercreds['encoded_sig'] = base64_encode($return);

      return $usercreds;
    }


    public function getProvider()
    {
      $bpjs_user = self::getUsercreds(self::$globalWdId);
        $model = Cachebyconsid::find()->andWhere(['consId' => $bpjs_user['cons_id']])->One();
        if(self::isDataOld($model)|| is_null($model->provider_list)) {
      try {
        //code...

      $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/provider/0/999']);
      $request = $client->createRequest()
      ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
      ->addHeaders(['content-type' => 'application/json'])
      ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
      ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
      ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);
      
      $response = $request->send();
          if ((json_encode(json_decode($response->content)->metaData->code) < 300) && (json_encode(json_decode($response->content)->metaData->code) >= 200)) {
              //success 200
              self::addCachebyconsid($bpjs_user['cons_id'], $response->content, 'provider');
              //return json_encode(json_decode($response->content)->metaData->code);
          } else {
              //anything but success
              if(is_null($model)) {
                  return $response->content;
              } else {
                  return $model->json_data;
              }
          }
      return $response->content;
    } catch (\yii\base\Exception $exception) {
     //return null;
     Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
    }
        } else {
            return $model->provider_list;
        }

    }


    public function addPendaftaran($kunjungan_id)
    {
      $bpjs_user = self::getUsercreds(self::$globalWdId);


      $kunjunganModel = Kunjungan::findOne($kunjungan_id);
      $kunjunganSakit = ($kunjunganModel->jenis_kunjungan == "sakit")? true : false;
      $payload = '{
        "kdProviderPeserta": "'.self::$globalKdProviderPeserta.'",
        "tglDaftar": "'.date("d-m-Y" , strtotime($kunjunganModel->tanggal_kunjungan)).'", 
        "noKartu": "'.$kunjunganModel->pendaftaran->no_bpjs.'",
        "kdPoli": "'.$kunjunganModel->poli_tujuan.'",
        "keluhan": "'.$kunjunganModel->keluhan.'",
        "kunjSakit": '. $kunjunganSakit .',
        "sistole": '.$kunjunganModel->sistole.',
        "diastole": '.$kunjunganModel->diastole.',
        "beratBadan": '.$kunjunganModel->berat_badan.',
        "tinggiBadan": '.$kunjunganModel->tinggi_badan.',
        "respRate": '.$kunjunganModel->respiratory_rate.',
        "heartRate": '.$kunjunganModel->heart_rate.',
        "rujukBalik": 0,
        "kdTkp": "10"
      }';
      try {

      $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/pendaftaran']);
      $request = $client->createRequest()
      ->setContent($payload)->setMethod('POST')
          ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
          ->addHeaders(['content-type' => 'application/json'])
          ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
          ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
          ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);
      
      $response = $request->send();
      return $response->content;
      //return $kunjunganModel;
      //return $payload;
    } catch (\yii\base\Exception $exception) {

     Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
    }

    }

    public function addKunjungan($kunjungan_id)
    {
      $bpjs_user = self::getUsercreds(self::$globalWdId);
      $kunjunganModel = Kunjungan::findOne($kunjungan_id);
      $rujukanModel = Rujukan::find()->andWhere(['kunjungan_id' => $kunjungan_id])->One();
      //$kunjunganModel = Kunjungan::find()->andWhere(['pendaftaran_id' => $kunjungan_id])->One();
      try {


          $content2 = '{
  "noKunjungan": null,
  "noKartu": "0000039043765",
  "tglDaftar": "17-11-2019",
  "kdPoli": "001",
  "keluhan": "keluhan",
  "kdSadar": "01",
  "sistole": 10,
  "diastole": 10,
  "beratBadan": 130,
  "tinggiBadan": 130,
  "respRate": 10,
  "heartRate": 10,
  "terapi": "catatan",
  "kdStatusPulang": "4",
  "tglPulang": "28-11-2019",
  "kdDokter": "97600",
  "kdDiag1": "A01.0",
  "kdDiag2": null,
  "kdDiag3": null,
  "kdPoliRujukInternal": null,
  "rujukLanjut": {	
  	"tglEstRujuk":"18-11-2019",
    "kdppk": "0222R005",
    "subSpesialis": null,
    "khusus": {
      "kdKhusus": "HDL",
      "kdSubSpesialis": null,
      "catatan": "peserta sudah biasa hemodialisa"
    }
  },
  "kdTacc": 0,
  "alasanTacc": null
}';


          if ($rujukanModel->tipe_rujukan == 'spesialis') {
              $spesialis_content = '{
      "kdSubSpesialis1": "'.$rujukanModel->kdSubSpesialis1.'",
      "kdSarana": "'.$rujukanModel->kdSarana.'"
    }';
              $khusus_content = 'null';
          } else if ($rujukanModel->tipe_rujukan == 'khusus') {
          $spesialis_content = 'null';
          $khusus_content = '{
          "kdKhusus": "'.$rujukanModel->kdKhusus.'",
      "kdSubSpesialis": "'.$rujukanModel->kdSubSpesialisKhusus.'",
      "catatan": "'.$rujukanModel->kdSarana.'"
    }';
          }

          $kdDiag1 = null;
          $kdDiag2 = null;
          $kdDiag3 = null;

          if (strlen($kunjunganModel->kode_diagnosa1) > 1)
              $kdDiag1 = substr_replace($kunjunganModel->kode_diagnosa1, ".", 3, 0);
          if (strlen($kunjunganModel->kode_diagnosa2) > 1)
              $kdDiag2 = substr_replace($kunjunganModel->kode_diagnosa2, ".", 3, 0);
          if (strlen($kunjunganModel->kode_diagnosa3) > 1)
              $kdDiag3 = substr_replace($kunjunganModel->kode_diagnosa3, ".", 3, 0);

          $content = '
      {
        "noKunjungan": null,
        "tglDaftar": "'.date("d-m-Y" , strtotime($kunjunganModel->tanggal_kunjungan)).'", 
        "noKartu": "'.$kunjunganModel->pendaftaran->no_bpjs.'",
        "kdPoli": "'.$kunjunganModel->poli_tujuan.'",
        "keluhan": "'.$kunjunganModel->keluhan.'",
        "kdSadar": "'.$kunjunganModel->kode_sadar.'",
        "sistole": '.$kunjunganModel->sistole.',
        "diastole": '.$kunjunganModel->diastole.',
        "beratBadan": '.$kunjunganModel->berat_badan.',
        "tinggiBadan": '.$kunjunganModel->tinggi_badan.',
        "respRate": '.$kunjunganModel->respiratory_rate.',
        "heartRate": '.$kunjunganModel->heart_rate.',
        "terapi": "'.$kunjunganModel->terapi.'",
        "kdStatusPulang": "'.$kunjunganModel->kode_status_pulang.'",
        "tglPulang": "'.date("d-m-Y" , strtotime($kunjunganModel->tanggal_kunjungan)).'",
        "kdDokter": "'.$kunjunganModel->kode_dokter.'",
        "kdDiag1": "'.$kdDiag1.'",
        "kdDiag2": "'.$kdDiag2.'",
        "kdDiag3": "'.$kdDiag3.'",
        "kdPoliRujukInternal": null,
        "rujukLanjut": {	
            "tglEstRujuk":"'. date("d-m-Y" , strtotime($rujukanModel->tanggal_estimasi)).'",
               "kdppk": "'.$rujukanModel->kdppk.'",
                "subSpesialis": '.$spesialis_content.',
            "khusus": '.$khusus_content.'
        },
        "kdTacc": 0,
        "alasanTacc": null


      }
      ';
      $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/kunjungan']);
      $request = $client->createRequest()->setContent($content)->setMethod('POST')
          ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
          ->addHeaders(['content-type' => 'application/json'])
          ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
          ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
          ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);
      
      $response = $request->send();

      echo '<pre>';
      print_r($content);
      return $response->content;
      //return $kunjunganModel;
    } catch (\yii\base\Exception $exception) {

     Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
    }

    }

    public function deleteKunjungan($kunjungan_id)
    {
      $bpjs_user = self::getUsercreds(self::$globalWdId);
      $kunjunganModel = Kunjungan::findOne($kunjungan_id);
      
      try {

      $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/kunjungan/' . $kunjunganModel->bpjs_kunjungan_no]);
      $request = $client->createRequest()
      ->setMethod('DELETE')
          ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
          ->addHeaders(['content-type' => 'application/json'])
          ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
          ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
          ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);
      
      $response = $request->send();
      //print_r($response);
      return $response->content;
    } catch (\yii\base\Exception $exception) {

     Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
    } 
    }

    public function getPeserta($no_bpjs)
    {

      $bpjs_user = self::getUsercreds(self::$globalWdId);

        $model = Peserta::find()->andWhere(['bpjs_no' => $no_bpjs])->One();
        //return $model->json_data;
        /**
         * 1. if data is OLD OR no data then hit
         * 2. if not getting valid data on hit then return cache (if old) or return error message (if no data)
         * 3. if not no.1 then return data
         */
        if(!isset($model->json_data)) {
            //return json_encode($no_bpjs);
            try {
                //code...

                $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/peserta/' . $no_bpjs]);
                $request = $client->createRequest()
                    ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                    ->addHeaders(['content-type' => 'application/json'])
                    ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                    ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                    ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

                $response = $request->send();
                if ((json_encode(json_decode($response->content)->metaData->code) < 300) && (json_encode(json_decode($response->content)->metaData->code) >= 200)) {
                    //success 200
                    self::addCachepeserta($no_bpjs, $response->content);
                    //return json_encode(json_decode($response->content)->metaData->code);
                } else {
                    //anything but success
                  //  return '1';
                        //return $response->content;
                }
                //return '0';
                return $response->content;
            } catch (\yii\base\Exception $exception) {
                return json_encode(['response' => null,'metaData' => ['message' => 'PROBLEM CONNECTING TO BPJS', 'code' => 400]]);
                //Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
            }
        } else {
            if(self::isDataOld($model)){
                try {
                    //code...
                    $client = new Client(['baseUrl' => 'https://dvlp.bpjs-kesehatan.go.id:9081/pcare-rest-v3.0/peserta/' . $no_bpjs]);
                    $request = $client->createRequest()
                        ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                        ->addHeaders(['content-type' => 'application/json'])
                        ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                        ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                        ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

                    $response = $request->send();
                    if ((json_encode(json_decode($response->content)->metaData->code) < 300) && (json_encode(json_decode($response->content)->metaData->code) >= 200)) {
                        //success 200
                        self::addCachepeserta($no_bpjs, $response->content);
                    } else {
                        //anything but success

                    //    return '7'; //old->error to bpjs. use old data
                        return $model->json_data;
                    }
                    //return '8'; //new data from bpjs'
                    return $response->content;
                } catch (\yii\base\Exception $exception) {
                    return json_encode(['response' => null,'metaData' => ['message' => 'PROBLEM CONNECTING TO BPJS', 'code' => 400]]);
                    Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
                }
            }  else {
                //return '9'; //data is current
                return $model->json_data;

            }

        }


    }


   
} # LAST BRACKET 
