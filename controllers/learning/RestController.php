<?php

namespace app\controllers\learning;
use app\models\learning\Feedback;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Response;
use Nahid\JsonQ\Jsonq;

USE Flow\JSONPath\JSONPath;

class RestController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['stats'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],

            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetchecklistversion()
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists', 1);

//        print_r($files);
        return $files[0];
        //return \Yii::$app->response->sendFile(  $appPath . '/assets/checklists/checklist.json');
    }

    public function actionGetchecklist()
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists', 1);
        //return $files[0];
        return \Yii::$app->response->sendFile($appPath . '/assets/checklists/' . $files[0]);
    }

    public function actionPostfeedback()
    {
        $appPath = Yii::getAlias('@app');
        if ($_POST) {
            $feedback = new Feedback();
            $feedback->message = $_POST['message'];
            $feedback->email = $_POST['email'];
            $feedback->phone = $_POST['phone'];
            $feedback->status = 'new';
            if ($feedback->save()) {
                echo 'success';
            } else {
                echo 'feedback failed to save';
            }
        } else {
            return 'not allowed';
        }
//        $files = scandir($appPath . '/assets/checklists', 1);
//        //return $files[0];
//        return \Yii::$app->response->sendFile(  $appPath . '/assets/checklists/' . $files[0]);
    }


    public function deEquation($string)
    {
        $ret = str_replace('equation_', '', $string);

        if ($ret == 'xor') {
            $ret = 'only one';
        } else if ($ret == 'or') {
            $ret = 'only one';
        } else if ($ret == 'and') {
            $ret = 'all';
        }
        return $ret;
    }

    public function collapseSingle(&$equation) {
        /** collapse NOT and collapse Single     */
        if (is_array($equation)) {

            foreach ($equation as $eq) {

                if (key_exists('children', $eq)) {
                    if (sizeof($eq->children) == 1) {
//                        echo 'only single children      ' . $eq->text['name'] . '<br/>';
                        /** find sub children */

                        if (key_exists('children', $eq->children[0])) {
//                            echo  $eq->children[0]->text['name'] . 'nina<br/>';
//                            echo '_____CHILDREN EXISTS!!!!<br/>';
                            /** collapseNot : this collapses nodes that are NOT -> THING into one node that is called NOT THING */
                            if(strpos($eq->text['name'], 'not') !== false){
//                            if (trim($eq->text['name']) == 'not') {

                                $eq->text['name'] = $eq->text['name']  . ' ' . $eq->children[0]->text['name'];
                            } else {
//                                echo '________' . $eq->text['name'] . '!!!!<br/>';
                                /** collapseSingle = true, // this collapses nodes that only have one child into a single node: THING -> CHILD turns into CHILD */
                                $eq->text['name'] = ' ' . $eq->children[0]->text['name'];
                            }
                            $eq->children = $eq->children[0]->children;
                            $collapsesinglenodes = false;
                            if ($collapsesinglenodes) {

                                $this->collapseSingle($eq->children);

                            } else {
                                $this->collapseSingle($eq->children);
                            }
                        } else {
//                            echo '____no more children     ' . $eq->text['name'] . '<br/>';
                            /** no more subchildren */

                            $eq->text['name'] = $eq->children[0]['text']['name'];

                            unset($eq->children);
                        }
                    } else {
//                        echo 'size : ' . sizeof($eq->children). ' <br/>';
                        $this->collapseSingle($eq->children);
                    }
                }
            }
        } else { //IF equation is not array
//            echo  '<hr/><pre>';
////            print_r($equation);
//            echo 'reno';
//            echo '</pre>';
            if (key_exists('children', $equation)) {

                if (sizeof($equation->children) == 1) {
                    //echo 'nina';
                } else {
                    //echo sizeof($equation->children);
                    // print_r($equation->children);
                }

                $this->collapseSingle($equation->children);
            }
        }
    }

    public function collapseNot(&$equation) {
        /** collapse NOT and collapse Single     */
        if (is_array($equation)) {

            foreach ($equation as $eq) {

                if (key_exists('children', $eq)) {
                    if (sizeof($eq->children) == 1) {
//                        echo 'only single children      ' . $eq->text['name'] . '<br/>';
                        /** find sub children */

                        if (key_exists('children', $eq->children[0])) {
//                            echo  $eq->children[0]->text['name'] . 'nina<br/>';
                            echo '_____CHILDREN EXISTS!!!!<br/>';
                            /** collapseNot : this collapses nodes that are NOT -> THING into one node that is called NOT THING */
                            if(strpos(strtolower($eq->text['name']), 'not') !== false){
//                            if (trim($eq->text['name']) == 'not') {
                                ECHO " ================================ " . $eq->text['name'] ."<br/>";
                                $eq->text['name'] = strtoupper($eq->text['name']);
                            } else {
                                echo '_____&___' . $eq->text['name'] . '!!!!<br/>';
                                /** collapseSingle = true, // this collapses nodes that only have one child into a single node: THING -> CHILD turns into CHILD */
                                $eq->text['name'] = ' ' . $eq->children[0]->text['name'];
                            }
                            $eq->children = $eq->children[0]->children;
                            $collapsesinglenodes = false;
                            if ($collapsesinglenodes) {

                                $this->collapseNot($eq->children);

                            } else {
                                $this->collapseNot($eq->children);
                            }
                        } else {
//                            echo '____no more children     ' . $eq->text['name'] . '<br/>';
                            /** no more subchildren */
                            if(strpos(strtolower($eq->text['name']), 'not') !== false){
                                $eq->text['name'] = $eq->text['name']  . $eq->children[0]['text']['name'];
                                unset($eq->children);
                            } else {
                                $eq->text['name'] = $eq->children[0]['text']['name'];

                                unset($eq->children);
                            }


                        }
                    } else {
                        echo 'size : ' . sizeof($eq->children). ' <br/>';
                        $this->collapseNot($eq->children);
                    }
                }
            }
        } else { //IF equation is not array
//            echo  '<hr/><pre>';
////            print_r($equation);
//            echo 'reno';
//            echo '</pre>';
            if (key_exists('children', $equation)) {

                if (sizeof($equation->children) == 1) {
                    //echo 'nina';
                } else {
                    //echo sizeof($equation->children);
                    // print_r($equation->children);
                }

                $this->collapseNot($equation->children);
            }
        }
    }


    public function removeTrailingNumber($name)
    {
        $arr = explode(" ", $name);
        if (sizeof($arr) > 0) {
            if (is_numeric($arr[sizeof($arr) - 1])) {
                array_pop($arr);
                return implode(" ", $arr);
            }
        }

        return $name;
    }

    public function itemsToChildren($equation)
    {
        if (is_array($equation)) {
            foreach ($equation as $eq) {

                if (key_exists('items', $eq)) {
                    $eq->children = $eq->items;
                    unset($eq->items);
                    $this->itemsToChildren($eq->children);
                } else if (key_exists('item', $eq)) {
                    $eq->children = [];
                    array_push($eq->children, $eq->item);
                    unset($eq->item);
                    $this->itemsToChildren($eq->children);
                }
            }
        } else { //IF equation is not array

            if (key_exists('items', $equation)) {
                $equation->children = $equation->items;
                unset($equation->items);
                $this->itemsToChildren($equation->children);

            } else {
                return;
            }
        }


    }

    public function traverseItems(&$equation)
    {

        if (is_array($equation)) {
            $comparator = null;
            $flag = 0;

            foreach ($equation as $eq) {
                if (key_exists('type', $eq)) {
                    //$eq->text = "{ name : " . $eq->type. "}";
                    $eq->text['name'] = ' ' . $this->deEquation($eq->type) . ' ';
                    unset($eq->type);
                }
                if (key_exists('items', $eq)) {

//                    $eq->children = $eq->items;
//                unset($eq->items);
                    $this->traverseItems($eq->items);
                } else if (key_exists('codes', $eq)) {
                    $eq->children = [];
                    foreach ($eq->codes as $code) {
                        $temp['text']['name'] = ' ' . $this->removeTrailingNumber($code) . ' ';
                        array_push($eq->children, $temp);
                    }
                    unset($eq->codes);

                } else if (key_exists('item', $eq)) {
//                $eq->children = [];
//                array_push( $eq->children, $eq->item);
//                unset($eq->item);
                    $this->traverseItems($eq->item);
                } else {
                    // return;
                }
            }
        } else { //IF equation is not array
            if (key_exists('type', $equation)) {
                $equation->text['name'] = ' ' . $this->deEquation($equation->type) . ' ';
                unset($equation->type);
            }
            //if $equation is not yet array
            if (key_exists('items', $equation)) {
//            $equation->children = $equation->items;
//            unset($equation->items);
                $this->traverseItems($equation->items);

            } else if (key_exists('codes', $equation)) {
                $equation->children = [];
                foreach ($equation->codes as $code) {
                    $temp['text']['name'] = ' ' . $this->removeTrailingNumber($code) . ' ';
                    array_push($equation->children, $temp);
                }

                unset($equation->codes);

            } else {
                return;
            }
        }

    }





    public function actionDiagram($search, $type)
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists', 1);
        $newFilePath = $appPath . '/assets/checklists/' . $files[0];
        $rawcontent = file_get_contents($newFilePath);
        $contents = json_decode($rawcontent);


        foreach ($contents as $content) {
            if (strpos(strtolower($content->name->text), strtolower($search)) !== false) {

                if (property_exists($content, 'quality_checks')) {
                    foreach ($content->quality_checks as $content1) {
                        if (strpos(strtolower($content1->name), strtolower($type)) !== false) {
                            $this->traverseItems($content1->equation);
                            echo '<pre>';
                            print_r($content1->equation);
//                           print_r(json_encode($content1->equation));
                            echo '</pre>';
                        }
                    }

                }

                echo '<hr/>';


            } else {
            }
        }


        // return $this->render('diagram');
    }

    public function actionSortquiz()
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists', 1);

        $json_content = file_get_contents($appPath . '/assets/checklists/' . $files[0]);

        $ret = [];
        function is_json($string, $return_data = false)
        {
            $data = json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
        }

        $json_object = json_decode($json_content);

        usort($json_object, function($a, $b) { //Sort the array using a user defined function
            return $a->name->text < $b->name->text ? -1 : 1; //Compare the scores
        });

//        $result = (new JSONPath($json_object))->find('$..reference'); // returns new JSONPath
        $diff_results = (new JSONPath($json_object))->find('$..[?(@.differential_diagnosis)]'); // returns new JSONPath




        foreach($diff_results as $diff_result) {
            $temparray = [];
            echo "what is the differential diagnosis for " . $diff_result->name->text . '<br/>';
            if (sizeof($diff_result->differential_diagnosis) > 0) {
                $tempstring = '';
                foreach($diff_result->differential_diagnosis as $diff_diag) {
                    $tempstring = $tempstring . json_encode($diff_diag->name->text) . ', ';
                }
                $temparray['preface'] = 'What is the differential diagnosis for ';
                $temparray['type'] = 'differential_diagnosis';
                $temparray['question'] = $tempstring;
                if (strpos($diff_result->name->text, '(')) {
                    $temparray['answer'] = substr($diff_result->name->text, 0, strpos($diff_result->name->text, '(')) ;
                } else {
                    $temparray['answer'] = $diff_result->name->text;
                }


                array_push($ret, $temparray);
            }
        }

    }

    public function actionGetquizall()
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists', 1);

        $json_content = file_get_contents($appPath . '/assets/checklists/' . $files[0]);

        $ret = [];
        function is_json($string,$return_data = false) {
            $data = json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
        }

        $json_object = json_decode($json_content);

        usort($json_object, function($a, $b) { //Sort the array using a user defined function
            return $a->name->text < $b->name->text ? -1 : 1; //Compare the scores
        });


//        $result = (new JSONPath($json_object))->find('$..reference'); // returns new JSONPath
        $diff_results = (new JSONPath($json_object))->find('$..[?(@.differential_diagnosis)]'); // returns new JSONPath
        $bg_results = (new JSONPath($json_object))->find('$..[?(@.background)]'); // returns new JSONPath
        $img_results = (new JSONPath($json_object))->find('$..[?(@.image)]'); // returns new JSONPath
        foreach($diff_results as $diff_result) {
            $temparray = [];
//            echo "what is the differential diagnosis for " . $diff_result->name->text . '<br/>';
            if (sizeof($diff_result->differential_diagnosis) > 0) {
                $tempstring = '';
                foreach($diff_result->differential_diagnosis as $diff_diag) {
                    $tempstring = $tempstring . json_encode($diff_diag->name->text) . ', ';
                }
                $temparray['preface'] = 'What is the differential diagnosis for ';
                $temparray['type'] = 'differential_diagnosis';
                $temparray['question'] = $tempstring;
                if (strpos($diff_result->name->text, '(')) {
                    $temparray['answer'] = substr($diff_result->name->text, 0, strpos($diff_result->name->text, '(')) ;
                } else {
                    $temparray['answer'] = $diff_result->name->text;
                }


                array_push($ret, $temparray);
            }
        }

        foreach($bg_results as $bg_result) {
            $temparray = [];
//            echo "what is the differential diagnosis for " . $diff_result->name->text . '<br/>';
            if (($bg_result->background->text == null)
                || ($bg_result->name->text == null)
                || ($bg_result->name->text == "")
                || ($bg_result->background->text == "")
            ){

            } else {


                $tempstring = $bg_result->background->text;

                $temparray['preface'] = 'Describe ';
                $temparray['type'] = 'background';
                if(strpos($bg_result->name->text, '(')) {
                    $temparray['question'] = substr($bg_result->name->text, 0, strpos($bg_result->name->text, '(')) ;
                } else {
                    $temparray['question'] = $bg_result->name->text;
                }


                $temparray['answer'] = $tempstring;

//                echo '<hr/>';
                array_push($ret, $temparray);
            }
        }

        foreach($img_results as $img_result) {
            $temparray = [];
//    echo json_encode($img_result->image);
            if (($img_result->name == null)
//                || ($img_result->name == "")
            ){

            } else {
                $tempstring = $img_result->name->text;

                $temparray['preface'] = 'What is this?  ';
                $temparray['type'] = 'image';

                $temparray['question'] = $img_result->image;

                $temparray['answer'] = $tempstring;

//                echo '<hr/>';
                array_push($ret, $temparray);
            }

        }

//        $randoms = array_rand($ret,10);
        $randoms = $ret;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $randoms;

    }

    public function actionGetquizver() {
        $ret['version'] = '0.1';
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $ret;
    }

    public function actionGetquizcompre()
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists',
            1);

        $json_content = file_get_contents($appPath . '/assets/checklists/' . $files[0]);

        $ret = [];
        function is_json($string,$return_data = false) {
            $data = json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
        }

        $json_object = json_decode($json_content);
        usort($json_object, function($a, $b) { //Sort the array using a user defined function
            return $a->name->text < $b->name->text ? -1 : 1; //Compare the scores
        });
//        $result = (new JSONPath($json_object))->find('$..reference'); // returns new JSONPath
        $diff_results = (new JSONPath($json_object))->find('$..[?(@.differential_diagnosis)]'); // returns new JSONPath

        foreach($diff_results as $diff_result) {
            $temparray = [];
//            echo "what is the differential diagnosis for " . $diff_result->name->text . '<br/>';
            if (sizeof($diff_result->differential_diagnosis) > 0) {
                $tempstring = '';
                foreach($diff_result->differential_diagnosis as $diff_diag) {
                    $tempstring = $tempstring . json_encode($diff_diag->name->text) . ', ';
                }
                $temparray['preface'] = 'What is the differential diagnosis for ';
                $temparray['type'] = 'differential_diagnosis';
                $temparray['question'] = $tempstring;
                if (strpos($diff_result->name->text, '(')) {
                    $temparray['answer'] = substr($diff_result->name->text, 0, strpos($diff_result->name->text, '(')) ;
                } else {
                    $temparray['answer'] = $diff_result->name->text;
                }


                array_push($ret, $temparray);
            }
        }

//        $randoms = array_rand($ret,10);
        $randoms = $ret;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $randoms;

    }


    public function actionGetquizdiff()
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists',
            1);

        $json_content = file_get_contents($appPath . '/assets/checklists/' . $files[0]);

        $ret = [];
        function is_json($string,$return_data = false) {
            $data = json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
        }

        $json_object = json_decode($json_content);
        usort($json_object, function($a, $b) { //Sort the array using a user defined function
            return $a->name->text < $b->name->text ? -1 : 1; //Compare the scores
        });
//        $result = (new JSONPath($json_object))->find('$..reference'); // returns new JSONPath
        $diff_results = (new JSONPath($json_object))->find('$..[?(@.differential_diagnosis)]'); // returns new JSONPath

        $this->getDiff($ret,$diff_results);
//        $randoms = array_rand($ret,10);
        $randoms = $ret;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $randoms;

    }



    public function actionGetquizbg()
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists',
            1);

        $json_content = file_get_contents($appPath . '/assets/checklists/' . $files[0]);

        $ret = [];
        function is_json($string,$return_data = false) {
            $data = json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
        }

        $json_object = json_decode($json_content);
        usort($json_object, function($a, $b) { //Sort the array using a user defined function
            return $a->name->text < $b->name->text ? -1 : 1; //Compare the scores
        });
        $bg_results = (new JSONPath($json_object))->find('$..[?(@.background)]'); // returns new JSONPath
        $img_results = (new JSONPath($json_object))->find('$..[?(@.image)]'); // returns new JSONPath


        foreach($bg_results as $bg_result) {
            $temparray = [];
//            echo "what is the differential diagnosis for " . $diff_result->name->text . '<br/>';
            if (($bg_result->background->text == null)
                || ($bg_result->name->text == null)
                || ($bg_result->name->text == "")
                || ($bg_result->background->text == "")
            ){

            } else {


                $tempstring = $bg_result->background->text;

                $temparray['preface'] = 'Describe ';
                $temparray['type'] = 'background';
                if(strpos($bg_result->name->text, '(')) {
                    $temparray['question'] = substr($bg_result->name->text, 0, strpos($bg_result->name->text, '(')) ;
                } else {
                    $temparray['question'] = $bg_result->name->text;
                }


                $temparray['answer'] = $tempstring;

//                echo '<hr/>';
                array_push($ret, $temparray);
            }
        }


//        $randoms = array_rand($ret,10);
        $randoms = $ret;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $randoms;

    }

    public function actionGetquizimg()
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists',
            1);

        $json_content = file_get_contents($appPath . '/assets/checklists/' . $files[0]);

        $ret = [];
        function is_json($string,$return_data = false) {
            $data = json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
        }

        $json_object = json_decode($json_content);

        usort($json_object, function($a, $b) { //Sort the array using a user defined function
            return $a->name->text < $b->name->text ? -1 : 1; //Compare the scores
        });
        $img_results = (new JSONPath($json_object))->find('$..[?(@.image)]'); // returns new JSONPath


        foreach($img_results as $img_result) {
            $temparray = [];
//    echo json_encode($img_result->image);
            if (($img_result->name == null)
//                || ($img_result->name == "")
            ){

            } else {
                $tempstring = $img_result->name->text;

                $temparray['preface'] = 'What is this?  ';
                $temparray['type'] = 'image';

                $temparray['question'] = $img_result->image;

                $temparray['answer'] = $tempstring;

//                echo '<hr/>';
                array_push($ret, $temparray);
            }

        }

//        $randoms = array_rand($ret,10);
        $randoms = $ret;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $randoms;

    }

    public function getDiff(&$ret, $diff_results){

        foreach($diff_results as $diff_result) {
            $temparray = [];
//            echo "what is the differential diagnosis for " . $diff_result->name->text . '<br/>';
            if (sizeof($diff_result->differential_diagnosis) > 0) {
                $tempstring = '';
                foreach($diff_result->differential_diagnosis as $diff_diag) {
                    $tempstring = $tempstring . json_encode($diff_diag->name->text) . ', ';
                }
                $temparray['preface'] = 'What is the differential diagnosis for ';
                $temparray['type'] = 'differential_diagnosis';
                $temparray['answer'] = $tempstring;
                if (strpos($diff_result->name->text, '(')) {
                    $temparray['question'] = substr($diff_result->name->text, 0, strpos($diff_result->name->text, '(')) ;
                } else {
                    $temparray['question'] = $diff_result->name->text;
                }


                array_push($ret, $temparray);
            }
        }
    }
    public function actionGetquiz()
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists',
            1);

        $json_content = file_get_contents($appPath . '/assets/checklists/' . $files[0]);

        $ret = [];
        function is_json($string,$return_data = false) {
            $data = json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
        }

        $json_object = json_decode($json_content);

//        $result = (new JSONPath($json_object))->find('$..reference'); // returns new JSONPath
        $diff_results = (new JSONPath($json_object))->find('$..[?(@.differential_diagnosis)]'); // returns new JSONPath
        $bg_results = (new JSONPath($json_object))->find('$..[?(@.background)]'); // returns new JSONPath
        $img_results = (new JSONPath($json_object))->find('$..[?(@.image)]'); // returns new JSONPath

        $this->getDiff($ret,$diff_results);
        foreach($bg_results as $bg_result) {
            $temparray = [];
//            echo "what is the differential diagnosis for " . $diff_result->name->text . '<br/>';
            if (($bg_result->background->text == null)
                || ($bg_result->name->text == null)
                || ($bg_result->name->text == "")
                || ($bg_result->background->text == "")
            ){

            } else {


                $tempstring = $bg_result->background->text;

                $temparray['preface'] = 'Describe ';
                $temparray['type'] = 'background';
                if(strpos($bg_result->name->text, '(')) {
                    $temparray['question'] = substr($bg_result->name->text, 0, strpos($bg_result->name->text, '(')) ;
                } else {
                    $temparray['question'] = $bg_result->name->text;
                }


                $temparray['answer'] = $tempstring;

//                echo '<hr/>';
                array_push($ret, $temparray);
            }
        }

        foreach($img_results as $img_result) {
            $temparray = [];
//    echo json_encode($img_result->image);
            if (($img_result->name == null)
//                || ($img_result->name == "")
            ){

            } else {
                $tempstring = $img_result->name->text;

                $temparray['preface'] = 'What is this?  ';
                $temparray['type'] = 'image';

                $temparray['question'] = $img_result->image;

                $temparray['answer'] = $tempstring;

//                echo '<hr/>';
                array_push($ret, $temparray);
            }

        }

//        $randoms = array_rand($ret,10);
        $randoms = $ret;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $randoms;

    }
    private function collapseCommonPrefixBackup(&$json_object)
    {

        if (is_array($json_object)) {
            $comparator = null;
            $flag = 0;
            foreach ($json_object as $eq) {
                if (key_exists('children', $eq)) {

                    if ($name = $this->collapseCommonPrefix($eq->children))
                    {
//                    echo 'common prefix : ' . $name .'<br/>';
                        $eq->text['name'] = $eq->text['name'] . ' ' . $name;
                    } else {
//                    echo 'common prefix<br/>';
                    }

                } else {
                    // no more sub-children

                    if(is_array($eq)) {
                        echo 'NO MORE CHILDREN - Still array<br/>';
                    } else {
                        echo 'NO MORE CHILDREN - no array<br/>';
                        if (is_null($comparator)) {
                            $comparator = $eq->text['name'];
                        } else if ($comparator != $eq->text['name']) {
                        } else {
                            $flag = 1;
                        }
                    }
                }

            }

            if ($flag == 1) {
                $json_object = $json_object[0];
//                $json_object->text['name'] = $json_object->text['name'] . ' kkjj';
                $flag = 0;
                return $json_object->text['name'];
            }
        } else {
//            echo 'not an array<br/>';
            if (key_exists('children', $json_object)) {
                $this->collapseCommonPrefix($json_object->children);

            }
        }
    }

    private function collapseCommonPrefix(&$json_object)
    {

        if (is_array($json_object)) {
            $comparator = null;
            $flag = 0;
            $comp = null;
            echo 'size of : ' . sizeof($json_object) . '<br/>';
            foreach ($json_object as $eq) {
            if (key_exists('children', $eq)) {
                echo ' - <br/>';
                if($comp = $this->collapseCommonPrefix($eq->children)) {
                    $eq->text['name'] = $eq->text['name'] . ' ' . $comp;
                    unset($eq->children);
                } else {
                    echo 'null comp <br/>';
                }
                } else {
                echo 'children doesnt exist : ' . json_encode($eq) . '<hr/>';
                $eq2 = json_decode(json_encode($eq),true);
                if (is_null($comparator)) {
                    $comparator = $eq2['text']['name'];
                } else {
                    if ($comparator == $eq2['text']['name']) {
                        $flag = 1;
                    } else {

                    }
                }
//             print_r($eq2['text']['name']);
//                echo '++++++++++++' . json_decode($eq,true)['text'] ['name'] . '<br/>';

                if ($flag == 1) {
                    echo 'POPOPOPOPO : '. $comparator.'<hr/>';
//                    $json_object = $eq;
//                $json_object->text['name'] = $json_object->text['name'] . ' kkjj';
                    $flag = 0;
//                    return $json_object->text['name'];
                    return $comparator;
                }


            }





            }

        } else {
//            echo 'not an array<br/>';
            if (key_exists('children', $json_object)) {
                $this->collapseCommonPrefix($json_object->children);

            }
        }
    }

    public function actionGettree($equation)
    {
        $request = Yii::$app->request;


        $obj = urldecode($equation);
        $json = json_decode($obj);
        $json_string = json_encode($json);
        //  return json_encode($json);
        // json_de
        $json_object = json_decode($json_string);
        $this->traverseItems($json_object);

        $this->itemsToChildren($json_object);
//
//        $this->collapseNodes($json_object);
//        $this->collapseSingle($json_object);
        $this->collapseNot($json_object);
        echo '<hr/><hr/>';
        $this->collapseNot($json_object);
        ob_end_clean();
        ob_start();
        $this->collapseCommonPrefix($json_object);

        ob_end_clean();
        ob_start();

        return $this->renderAjax('test', [
            'json_object' => $json_object
        ]);

        ob_end_clean();
        ob_start();
        echo '<pre>';
        print_r($json_object);
        echo '</pre>';

        // return;

    }

}
