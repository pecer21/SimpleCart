<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{
	public function beforeAction($action)
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		if(!isset(\Yii::$app->user->identity->id))
		{
			throw new ForbiddenHttpException("You must log in.");
		}
		
		return parent::beforeAction($action);
	}
}