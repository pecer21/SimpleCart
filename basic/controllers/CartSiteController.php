<?php

namespace app\controllers;

use yii\web\Controller;

class CartSiteController extends Controller
{
	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	
	public function actionIndex()
	{
		return $this->render('index');
	}
}