<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Cart extends ActiveRecord
{

	public static function tableName()
	{
		return 'cart';
	}
	
	public function getCartItems()
	{
		return $this->hasMany(CartItem::className(), ['cartid' => 'id']);
	}
	
	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
				// password is validated by validatePassword()
				[['userid'], 'required'],
				[['userid'], 'integer'],
		];
	}
	
}