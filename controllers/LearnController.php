<?php

namespace app\controllers;

class LearnController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTool()
    {
        return $this->render('tool');
    }

}
