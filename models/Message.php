<?php
	namespace app\models;

	class Message extends \yii\elasticsearch\ActiveRecord
	{

		public  $_id;
		/**
		 * @return array the list of attributes for this record
		 */

		public function rules(){
			return [
				[['message'], 'required'],
				[['time'], 'default', 'value' => round(microtime(true) * 1000)],
				[['ip'], 'default', 'value' => $_SERVER['REMOTE_ADDR']]
			];
		}

		public function attributes()
		{
			return ['message', 'time', 'ip'];
		}
	}