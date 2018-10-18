<?php

namespace app\controllers;

use app\models\Cart;
use app\models\CartItem;

class CartController extends BaseController
{
	public function actionGetCartItems()
	{
		$cart = Cart::findOne( ['userid' => \Yii::$app->user->identity->id] );
				
		if($cart)
		{
			$cart_items = $cart->cartItems;
		}
		
		return array(
				'items' => isset($cart_items) ? $cart_items: null
		);
	}
	
	public function actionHasItemInCart($itemid)
	{
		$cart = Cart::findOne( ['userid' => \Yii::$app->user->identity->id] );
		
		if($cart)
		{
			$cartItem = CartItem::findOne(['cartid' => $cart->id, 'itemid' => $itemid]);
		}
		
		return array(
				'item' => isset($cartItem) ? $cartItem : null
		);
	}
	
	public function actionAddItemToCart()
	{
		if(\Yii::$app->request->isAjax)
		{
			$cartItem = new CartItem();
			
			$cart = Cart::findOne( ['userid' => \Yii::$app->user->identity->id] );
			
			if(!$cart)
			{
				$cart = new Cart();
				$cart->userid = \Yii::$app->user->identity->id;
				if(!$cart->save())
				{
					return array(
							'error' => $cart->getErrors()
					);
				}
			}
			
			$cartItem->cartid = $cart->id;
			
			$data = \Yii::$app->request->post();
			
			$cartItem->itemid = $data['itemid'];
			$cartItem->quantity = $data['quantity'];
			
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
}