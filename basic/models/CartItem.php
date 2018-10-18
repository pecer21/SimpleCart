<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class CartItem extends ActiveRecord
{		
	public static function tableName()
	{
		return 'cart_item';
	}
	
	public function getCart()
	{
		return $this->hasOne(Cart::className(), ['id' => 'cartid']);
	}
	
	public function getItem()
	{
		return $this->hasOne(Item::className(), ['id' => 'itemid']);
	}
	
	public function fields()
	{
		$fields = parent::fields();
		
		return array_merge($fields, [
				'item' => function ($model) {
					return $model->item; // Return related model property, correct according to your structure
				},
			]
		);
	}
	
	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
				// password is validated by validatePassword()
				[['cartid', 'itemid', 'quantity'], 'required'],
				[['cartid', 'itemid', 'quantity'], 'integer'],
				['quantity', 'compare', 'compareValue' => 0, 'operator' => '>'],
		];
	}
}