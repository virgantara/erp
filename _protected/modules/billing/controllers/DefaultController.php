<?php

namespace app\modules\billing\controllers;

use yii\web\Controller;

/**
 * Default controller for the `billing` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAddTagihan()
    {
    	
    }
}
