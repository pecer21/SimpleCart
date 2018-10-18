<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Item;

class ItemController extends Controller
{
	
	public function actionGetItems()
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$items= Item::find()->orderBy('name')->all();
				
		return array(
			'items' => $items,
		);
	}
}