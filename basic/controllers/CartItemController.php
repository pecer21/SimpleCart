<?php

namespace app\controllers;

use app\models\CartItem;
use app\models\Cart;

class CartItemController extends BaseController
{
	public function actionUpdateQuantityWithItem($itemid)
	{
		if(\Yii::$app->request->isAjax)
		{			
			$cart = Cart::findOne( ['userid' => \Yii::$app->user->identity->id] );
			
			$cartItem = CartItem::findOne(['cartid' => $cart->id, 'itemid' => $itemid]);
			
			$data = \Yii::$app->request->post();
						
			$cartItem->quantity += intval($data['quantity']);
						
			if($cartItem->save())
			{
				return array(
					'item' => $cartItem
				);
			}
			
			return array(
				'error' => $cartItem->getErrors()
			);
		}
	}
	
	public function actionUpdateQuantityWithId($cartitemid)
	{
		if(\Yii::$app->request->isAjax)
		{						
			$cartItem = CartItem::findOne($cartitemid);
			
			$data = \Yii::$app->request->post();
			
			$cartItem->quantity = intval($data['quantity']);
			
			if($cartItem->save())
			{
				return array(
					'item' => $cartItem
				);
			}
			
			return array(
				'error' => $cartItem->getErrors()
			);
		}
	}
	
	public function actionDeleteWithId($cartitemid)
	{
		if(\Yii::$app->request->isAjax)
		{			
			$cartItem = CartItem::findOne($cartitemid);
			
			if($cartItem->delete())
			{
				return array(
					'error' => null
				);
			}
			
			return array(
				'error' => $cartItem->getErrors()
			);
		}
	}
	
}