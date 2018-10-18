<?php

namespace app\models;

use yii\db\ActiveRecord;

class Item extends ActiveRecord
{
	public static function tableName()
	{
		return 'item';
	}
	
	public function attributeLabels()
	{
		return [
				'name' => 'Megnevezés',
		];
	}
	
	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
				// password is validated by validatePassword()
				[['name'], 'required'],
				[['name'], 'string'],
		];
	}
}
