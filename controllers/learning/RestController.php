<?php

namespace app\controllers\learning;
use Yii;
use Nahid\JsonQ\Jsonq;

class RestController extends \yii\web\Controller
{
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
        return \Yii::$app->response->sendFile(  $appPath . '/assets/checklists/' . $files[0]);
    }

    public function deEquation($string) {
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

    public function actionTest() {
        $test = '{
            "type": "equation_xor",
            "items": [{
                "type": "equation_and",
                "items": [{
                    "type": "equation_xor",
                    "items": [{
                        "type": "equation_all",
                        "codes": ["Beta-agonist 1"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Beta-agonist 2"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Beta-agonist 3"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Beta-agonist 4"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Beta-agonist 5"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Beta-agonist 6"]
                    }]
                }, {
                    "type": "equation_xor",
                    "items": [{
                        "type": "equation_all",
                        "codes": ["Corticosteroid 1"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Corticosteroid 2"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Corticosteroid 3"]
                    }]
                }, {
                    "type": "equation_not",
                    "item": {
                        "type": "equation_any",
                        "codes": ["Adjunct asthma medicine"]
                    }
                }]
            }, {
                "type": "equation_and",
                "items": [{
                    "type": "equation_any",
                    "codes": ["Severe disease sign"]
                }, {
                    "type": "equation_xor",
                    "items": [{
                        "type": "equation_all",
                        "codes": ["Beta-agonist 1"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Beta-agonist 2"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Beta-agonist 3"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Beta-agonist 4"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Beta-agonist 5"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Beta-agonist 6"]
                    }]
                }, {
                    "type": "equation_xor",
                    "items": [{
                        "type": "equation_all",
                        "codes": ["Corticosteroid 1"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Corticosteroid 2"]
                    }, {
                        "type": "equation_all",
                        "codes": ["Corticosteroid 3"]
                    }]
                }, {
                    "type": "equation_or",
                    "items": [{
                        "type": "equation_any",
                        "codes": ["Terbutaline"]
                    }, {
                        "type": "equation_any",
                        "codes": ["Magnesium"]
                    }]
                }]
            }]
        }';

        $json_object = json_decode($test);
        print_r(json_encode($json_object));
    }

    public function collapseNodes(&$equation) {

        if (is_array($equation)) {
            foreach ($equation as $eq) {
                if (key_exists('children', $eq)) {

                    if (sizeof($eq->children) == 1) {
/** find sub children */
                        if (key_exists('children', $eq->children[0])) {
                            /** collapseNot : this collapses nodes that are NOT -> THING into one node that is called NOT THING */
                            if ($eq->text['name'] == 'not') {
                                $eq->text['name'] = 'not ' . $eq->children[0]->text['name'];
                            } else {

                                /** collapseSingle = true, // this collapses nodes that only have one child into a single node: THING -> CHILD turns into CHILD */
                                $eq->text['name'] = $eq->children[0]->text['name'];
                            }
//                            echo $eq->text['name'];
//                            echo '<br/>';
                            $eq->children = $eq->children[0]->children;
                            $collapsesinglenodes = true;
                            if ($collapsesinglenodes) {
                                $eq->text['name'] = $eq->text['name'] . ' '.$eq->children[0]['text']['name'];
                                unset($eq->children);
                            } else {
                                $this->collapseNodes($eq->children);
                            }


                        } else {
            /** no more subchildren */
//                            echo sizeof($eq->children[0]);
                            $eq->text['name'] = $eq->children[0]['text']['name'];
//                            unset($eq->children[0]->children);

                            unset($eq->children);

                        }


                    } else {
//                        echo 're ' . sizeof($eq->children);
//                        print_r($eq->text);
                        $this->collapseNodes($eq->children);
                    }


                } else {

                }
            }
        } else {
            if (key_exists('children', $equation)) {

                if (sizeof($equation->children) == 1) {
                    //echo 'nina';
                } else {
                    //echo sizeof($equation->children);
                   // print_r($equation->children);
                }

                $this->collapseNodes($equation->children);
            }
        }

    }

    public function removeTrailingNumber($name) {
        $arr = explode(" ", $name);
        if (sizeof($arr) > 0) {
            if (is_numeric($arr[sizeof($arr) - 1])) {
                array_pop($arr);
                return implode(" ", $arr);
            }
        }

        return $name;
    }
    public function traverseItems(&$equation) {


    if (is_array($equation)) {


        foreach ($equation as $eq) {
            if (key_exists('type', $eq)) {
                //$eq->text = "{ name : " . $eq->type. "}";
                $eq->text['name'] = $this->deEquation($eq->type);
                unset($eq->type);
            }
            if (key_exists('items', $eq)) {

                if(sizeof($eq->items) == 1) {

                } else {

                }
                    $eq->children = $eq->items;


                unset($eq->items);
                $this->traverseItems($eq->children);
            } else if (key_exists('codes', $eq)) {
                $eq->children = [];
                foreach ($eq->codes as $code) {
                    $temp['text']['name'] = $this->removeTrailingNumber($code);
                    array_push($eq->children, $temp);
                }


                unset($eq->codes);

            } else if (key_exists('item', $eq)) {
                $eq->children = [];
                array_push( $eq->children, $eq->item);
                unset($eq->item);
                $this->traverseItems($eq->children);
            } else {
               // return;
            }
        }
    } else {
        if (key_exists('type', $equation)) {

            $equation->text['name'] = $this->deEquation($equation->type);
            unset($equation->type);
        }
        //if $equation is not yet array
        if (key_exists('items', $equation)) {
            $equation->children = $equation->items;
            unset($equation->items);
            $this->traverseItems($equation->children);

        }
        else if (key_exists('codes', $equation)) {
            $equation->children = [];
            foreach ($equation->codes as $code) {
                $temp['text']['name'] = $this->removeTrailingNumber($code);
                array_push($equation->children, $temp);
            }

            unset($equation->codes);

        }
        else {
            return;
        }
    }

    }


    public function actionGettree($equation) {
        $request = Yii::$app->request;


        $obj = urldecode($equation);
        $json = json_decode($obj);
        $json_string = json_encode($json);
        //  return json_encode($json);
        // json_de
        $json_object = json_decode($json_string);
        $this->traverseItems($json_object);
        $this->collapseNodes($json_object);
        $this->collapseCommonPrefix($json_object);
        return $this->renderAjax('test',[
            'json_object' => $json_object
        ]);
        echo '<pre>';
        print_r($json_object);

    }



    public function actionDiagram($search,$type)
    {
        $appPath = Yii::getAlias('@app');

        $files = scandir($appPath . '/assets/checklists', 1);
        $newFilePath = $appPath . '/assets/checklists/' . $files[0];
        $rawcontent=file_get_contents($newFilePath);
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

    private function collapseCommonPrefix(&$json_object)
    {

        if (is_array($json_object)) {
            $comparator = null;
            $flag = 0;
            foreach ($json_object as $eq) {
               // echo $eq->text['name'];
            if (key_exists('children', $eq)) {
//                echo sizeof($eq->children);
//                echo $eq->
                if ($name = $this->collapseCommonPrefix($eq->children))
                {
//                    echo 'sasa<br/>';
                    $eq->text['name'] = $eq->text['name'] . ' ' . $name;
                } else {
//                    echo '00000<br/>';
                }

                } else {
                // no more sub-children
                        if(is_array($eq)) {
//                            echo 'array :' . $eq['text']['name'];
                        } else {
                           // echo $eq->text['name'];
                            if (is_null($comparator)) {
                                $comparator = $eq->text['name'];
                            } else if ($comparator != $eq->text['name']) {
                                //echo 'difference';
                            } else {
                                $flag = 1;
                            }


                        }
//                echo $eq->text['name'];
//                                echo '<br/>';
            }

            }

            if ($flag == 1) {
                $json_object = $json_object[0];
//                $json_object->text['name'] = $json_object->text['name'] . ' kkjj';
                $flag = 0;
                return $json_object->text['name'];
            }
        } else {
//            echo 'not array';
            if (key_exists('children', $json_object)) {
                //echo "andrea<br/>";
              //  $equation->children = $equation->items;
                //unset($equation->items);
                $this->collapseCommonPrefix($json_object->children);

            }
        }
    }

}
