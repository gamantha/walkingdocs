<?php

namespace app\controllers\learning;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;

class DashboardController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $args = [
            'credentials' => [
                'key' => 'AKIAITUU3I7XGWNZAQNQ',
                'secret' => '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',
            ],
            'region' => 'ap-southeast-1',
            'version' => 'latest',

            'app_client_id' => '7oogi1gfr7hgod62cv1re21g87',
            'app_client_secret' => 'bl18m3fbika2be35f34n2m1edvvmbqj0v4fc84dqba2q36cp5j5',
            'user_pool_id' => 'ap-southeast-1_MyfrNxgT8'
        ];

        $client = new CognitoIdentityProviderClient($args);

        $userId = "renowijoyo@gmail.com";
        $clientId = "7oogi1gfr7hgod62cv1re21g87";
        $clientSecret = "bl18m3fbika2be35f34n2m1edvvmbqj0v4fc84dqba2q36cp5j5";
        $s = hash_hmac('sha256', $userId.$clientId, $clientSecret, true);
        $secret_hash =  base64_encode($s);


        $result = $client->initiateAuth([
//            'AnalyticsMetadata' => [
//                'AnalyticsEndpointId' => '<string>',
//            ],
            'AuthFlow' => 'USER_PASSWORD_AUTH', // REQUIRED
            'AuthParameters' => [
                'USERNAME' => 'renowijoyo@gmail.com',
                'PASSWORD' => 'reno123',
                'SECRET_HASH' => $secret_hash
//                'SECRET_HASH' => base64_encode(hash_hmac('sha256', 'renowijoyo@gmail.com' . '4s0puccdrd78pn7gntd6f0nrnq', '4lcbtdgd47am8knkngkqh78ke1ds67j0r631ef4vv1au5rgoqo5', true))
            ],
            'ClientId' => '7oogi1gfr7hgod62cv1re21g87', // REQUIRED
//            'ClientMetadata' => ['<string>', ...],
//            'UserContextData' => [
//                'EncodedData' => '<string>',
//            ],
            'UserPoolId' => 'ap-southeast-1_MyfrNxgT8',
        ]);
        $accessToken = $result->get('AuthenticationResult')['AccessToken'];

//        print_r($accessToken);

        $result = $client->listIdentities(array(
            // IdentityPoolId is required
            'IdentityPoolId' => 'string',
            // MaxResults is required
//            'MaxResults' => integer,
            'NextToken' => 'string',
//            'HideDisabled' => true || false,
        ));


        //return $this->render('index');
    }

}
