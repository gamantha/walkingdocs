<?php

namespace app\controllers\learning;

use app\models\learning\Like;
use app\models\learning\Ratingcomment;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use JsonPath\JsonObject;
USE Flow\JSONPath\JSONPath;
use Yii;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\data\ActiveDataProvider;

class DashboardController extends \yii\web\Controller
{

    public function actionTest()
    {
        $this->layout = '@daxslab/coreui/views/layouts/main.php';
        return $this->renderPartial('test',[

        ]);
    }

    public function actionComments()
    {
        return $this->renderPartial('comments',[

        ]);
    }
    public function actionIndex()
    {

        $result = $this->getCognitoUsers();
        $users_array = $this->getUserarray($result['Users']);
        $occupation_array = $this->groupByOccupation($users_array);
        $top_checklist = $this->topChecklist();
        $checklist_arr = $this->getChecklistitem();
        $average_rating = $this->getAveragerating();
        $checklist_rating = $this->getChecklistrating();

        $top_checklist_merge = [];


        $ratingsquery = Ratingcomment::find();

        $ratingsprovider = new ActiveDataProvider([
            'query' => $ratingsquery,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'rating' => SORT_DESC,
//                    'title' => SORT_ASC,
                ]
            ],
        ]);

        foreach ($top_checklist as $top_item_key => $top_item_value) {
            $arr_to_be_pushed = [];
            $arr_to_be_pushed['itemId'] = $top_item_key;
            $arr_to_be_pushed['count'] = $top_item_value;
            if (key_exists($top_item_key,$checklist_arr)) {
                $arr_to_be_pushed['name'] = $checklist_arr[$top_item_key];
            }
        array_push($top_checklist_merge, $arr_to_be_pushed);
        }

        $query = new Query;
        $provider = new ArrayDataProvider([
            'allModels' => $top_checklist_merge,
            'sort' => [
                //'attributes' => ['id', 'username', 'email'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


//echo '<pre>';
//print_r($top_checklist_merge);
//echo'</pre>';

        return $this->render
        ('index',[
            'users' => $result,
            'users_array' => $users_array,
            'occupation_array' => $occupation_array,
            'provider' => $provider,
            'average_rating' => $average_rating,
            'checklist_rating' => $checklist_rating,
            'ratingsprovider' => $ratingsprovider
            ]);
    }

    private function getUserarray($users) {
        $ret_array = [];
        foreach($users as $user ) {

            $userobj['username'] = $user['Username'];
            $userobj['create_date'] = $user['UserCreateDate']->format('Y-m-d H:i:s');
            foreach($user['Attributes'] as $attribute) {
                if ($attribute['Name'] == 'custom:occupation')
                {
                    $userobj['occupation'] =  $attribute['Value'];
                } else if ($attribute['Name'] == 'email')
                {
                    $userobj['email'] =  $attribute['Value'];
                }
            }

            array_push($ret_array, $userobj);
        }
        return $ret_array;
    }

    private function getCognitoUsers()
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


        $result = $client->listUsers([
//                    'AttributesToGet' => ['<string>', ...],
//                    'Filter' => '<string>',
//                    'Limit' => <integer>,
//    'PaginationToken' => '<string>',
            'UserPoolId' => 'ap-southeast-1_MyfrNxgT8',
        ]);


return $result;
    }
    public function actionCognito()
    {

        $result = $this->getCognitoUsers();

echo "Total users : "  . sizeof($result['Users']);
echo '<hr/>';
$users_array = $this->getUserarray($result['Users']);
$occupation_array = $this->groupByOccupation($users_array);

echo '<pre>';
//        print_r($result['Users']);
//        print_r($users_array);
        print_r($occupation_array);
        echo '</pre>';
        //return $this->render('index');
    }

    private function groupByOccupation(array $users_array)
    {
        $ret_array = [];
//        $arr['occupation'] = '';
        foreach ($users_array as $user) {
            if (key_exists('occupation', $user)) {
                $occupation = \_\lowerCase(trim($user['occupation']));
                if (!key_exists( $occupation, $ret_array)) {
                    $ret_array[$occupation] = [];
                }
            array_push($ret_array[$occupation], $user);
            }

        }
        return $ret_array;
    }

    private function topChecklist()
    {
        $ret_array = [];
        $likes = Like::find()
            ->andWhere(['type' => 'checklist'])
            ->andWhere(['like' => 'true'])
            ->All();
        foreach($likes as $like) {
            if($like->like == 'true') {
                if (!key_exists($like->itemId, $ret_array)) {
                    $ret_array[$like->itemId] = 0;
                }
                $ret_array[$like->itemId]++;
            }
        }
        arsort($ret_array);
        return $ret_array;
    }

    public function getChecklistitem()
    {

        $ret_array = [];

        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists', 1);

//        print_r($files);


                $filecontent = file_get_contents("../assets/checklists/" . $files[0]);
        $checklist = json_decode($filecontent);

//        return $files[0];


//
        foreach ($checklist as $item)
        {
            $ret_array[$item->id] = $item->name->text;
//            echo $item->id;
//            echo $item->name->text;
//            echo '<br/>';
        }

return $ret_array;
    }
    private function getAveragerating()
    {
        $sum = Ratingcomment::find()->sum('rating');
        $count = Ratingcomment::find()->count('rating');
        return $sum/$count;
    }

    public function getChecklistrating()
    {
        $ret_array = [];
        $counttrue = Like::find()->andWhere(['like' => 'true'])->count();
        $countall = Like::find()->count();

        $percentage = $counttrue / $countall;
        return $percentage  * 100;
    }

}
