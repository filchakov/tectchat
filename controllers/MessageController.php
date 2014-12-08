<?php

namespace app\controllers;

use app\models\Message;
use yii\rest\Controller;

class MessageController extends Controller
{
	public $modelClass = 'app\models\Message';

	public function actionIndex(){
		$data = \Yii::$app->getRequest();
		$data = $_REQUEST;
		$customer = Message::find()->limit(500)->orderBy('time desc');

		if(isset($data['time'])){
			$customer = $customer->query([
				"filtered" => [
					"filter" => [
						"range" => [
							'time' => [
								"gte" => $data['time']+1
							]
						]
					],
				]
			]);
			unset($data['time']);
		}

		if(is_array($data) && count($data)>0){
			$customer = $customer->filterWhere($data);
		}

		$customer = $customer->all();

		$rows = [];
		foreach ($customer as $m) {
			$rows[] = $m->attributes;
		}
		return $rows;
	}


	public function actionCreate()
	{
		$data = \Yii::$app->getRequest()->getBodyParams();
		$message = new Message();
		$message->message = isset($data['message']) ? $data['message'] : '';
		$message->time = round(microtime(true) * 1000);
		$message->save();
		echo json_encode(['create'=>'success']);
	}

	public function actionDelete($id)
	{
		$message = Message::get($id)->delete();
		return json_encode(['delete'=>$id]);
	}

}