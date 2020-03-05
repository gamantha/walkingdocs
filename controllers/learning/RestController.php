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



    public function traverseItems(&$equation) {


    if (is_array($equation)) {
        foreach ($equation as $eq) {
            if (key_exists('type', $eq)) {
                //$eq->text = "{ name : " . $eq->type. "}";
                $eq->text['name'] = $eq->type;
                unset($eq->type);
            }
            if (key_exists('items', $eq)) {
              //  echo 'items a<br/>';
                $eq->children = $eq->items;
                unset($eq->items);
                $this->traverseItems($eq->children);
            }            else if (key_exists('codes', $eq)) {
                //  echo 'items a<br/>';
                //$eq->children = $eq->codes;
                $eq->children = [];
                foreach ($eq->codes as $code) {
                    $temp['text']['name'] = $code;
                    array_push($eq->children, $temp);
                }


                unset($eq->codes);
            } else {
               // return;
            }
        }
    } else {
        if (key_exists('type', $equation)) {
            //$equation->text = "{ name : " . $equation->type. "}";
            $equation->text['name'] = $equation->type;
            unset($equation->type);
        }
        //if $equation is not yet array
        if (key_exists('items', $equation)) {
            //echo 'items 1<br/>';
            $equation->children = $equation->items;
            unset($equation->items);
            $this->traverseItems($equation->children);

        }
        else if (key_exists('codes', $equation)) {
            //echo 'items 1<br/>';
            $equation->children = $equation->codes;
            unset($equation->codes);

        }
        else {
            return;
        }
    }

    }



    public function actionEncode() {
        $string = '{
            "type": "equation_and",
            "items": [{
                "type": "equation_any",
                "codes": ["Asthma symptom"]
            }, {
                "type": "equation_or",
                "items": [{
                    "type": "equation_any",
                    "codes": ["Asthma history"]
                }, {
                    "type": "equation_any",
                    "codes": ["Asthma trigger"]
                }]
            }, {
                "type": "equation_any",
                "codes": ["Prolonged expiration", "Wheeze", "Decreased breath sounds"]
            }]}';
        $obj = json_decode($string);
        echo(urlencode($string));
    }

    public function actionTree() {
        $request = Yii::$app->request;
       // echo 'rere';
        $json = $request->bodyParams;
        $json_string = json_encode($json);
      //  return json_encode($json);
       // json_de
        $json_object = json_decode($json_string);
        $this->traverseItems($json_object);
         return $this->renderAjax('tree',[
             'json_object' => $json_object
         ]);
       //return json_encode($json_object);

    }


    public function actionGettree($equation) {
        $request = Yii::$app->request;

           // $obj = '{"text":{"name":"equation_xor"},"children":[{"text":{"name":"equation_and"},"children":[{"text":{"name":"equation_xor"},"children":[{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 1"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 2"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 3"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 4"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 5"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 6"}}]}]},{"text":{"name":"equation_xor"},"children":[{"text":{"name":"equation_all"},"children":[{"text":{"name":"Corticosteroid 1"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Corticosteroid 2"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Corticosteroid 3"}}]}]},{"item":{"type":"equation_any","codes":["Adjunct asthma medicine"]},"text":{"name":"equation_not"}}]},{"text":{"name":"equation_and"},"children":[{"text":{"name":"equation_any"},"children":[{"text":{"name":"Severe disease sign"}}]},{"text":{"name":"equation_xor"},"children":[{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 1"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 2"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 3"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 4"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 5"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Beta-agonist 6"}}]}]},{"text":{"name":"equation_xor"},"children":[{"text":{"name":"equation_all"},"children":[{"text":{"name":"Corticosteroid 1"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Corticosteroid 2"}}]},{"text":{"name":"equation_all"},"children":[{"text":{"name":"Corticosteroid 3"}}]}]},{"text":{"name":"equation_or"},"children":[{"text":{"name":"equation_any"},"children":[{"text":{"name":"Terbutaline"}}]},{"text":{"name":"equation_any"},"children":[{"text":{"name":"Magnesium"}}]}]}]}]}';

        $obj = urldecode($equation);
        $json = json_decode($obj);
        $json_string = json_encode($json);
        //  return json_encode($json);
        // json_de
        $json_object = json_decode($json_string);
        $this->traverseItems($json_object);
        return $this->renderAjax('test',[
            'json_object' => $json_object
        ]);
        //return json_encode($json_object);

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

}
