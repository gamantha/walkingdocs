<?php

namespace app\components;


use app\models\Consid;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;

class pcareComponent extends Component
{
    public function welcome()
    {
        echo "Hello..Welcome to MyComponent";
    }

    public function getUsercreds($consId)
    {
        $usercreds = [];
        $bpjs_user = Consid::find()->andWhere(['cons_id' => $consId])->One();
        if ($bpjs_user == null) {
            $usercreds['isnull'] = true;
            return $usercreds;
        } else {
            $usercreds['isnull'] = false;
        }
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


    public function integrationCheck($consid)
    {
//        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $bpjs_user = self::getUsercreds($consid);
        if ($bpjs_user['isnull']) {
            Yii::warning("null response");
            $response['response'] = null;
            $response['metaData'] = null;
            return json_encode($response);
        }
        try {

            $client = new Client(['baseUrl' => 'https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0/kesadaran']);
            $request = $client->createRequest()
//                ->setContent($payload)->setMethod('POST')
                ->setHeaders(['X-cons-id' => $bpjs_user['cons_id']])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['X-Timestamp' => $bpjs_user['time']])
                ->addHeaders(['X-Signature' => $bpjs_user['encoded_sig']])
                ->addHeaders(['X-Authorization' => $bpjs_user['encoded_auth_string']]);

            $response = $request->send();
            return $response->content;
        } catch (\yii\base\Exception $exception) {

            Yii::warning("ERROR GETTING RESPONSE FROM BPJS.");
        }
    }

}
?>