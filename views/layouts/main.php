<?php
	use yii\helpers\Html;
	use yii\bootstrap\Nav;
	use yii\bootstrap\NavBar;
	use yii\widgets\Breadcrumbs;
	use app\assets\AppAsset;
	/* @var $this \yii\web\View */
	/* @var $content string */
	AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" data-ng-app="chatApp">
<head>
	<meta charset="<?= Yii::$app->charset?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
	<meta name="description" content=""/>
	<meta name="author" content=""/>
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<title>BOOTSTRAP CHAT EXAMPLE</title>
	<!-- BOOTSTRAP CORE STYLE CSS -->

	<?= Html::csrfMetaTags()?>
	<?php $this->head();?>
	<link href="assets/css/bootstrap.css" rel="stylesheet"/>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
	<script>
		var chatApp = angular.module('chatApp', []);
		chatApp.controller('chatController', function($scope, $http, $timeout) {

			var getAllMessage = function getMessage(){
				$http.get("/message").success(function (response) {
					$scope.messages = response;
				});
				$timeout(getAllMessage, 3000);
			}
			$timeout(getAllMessage, 100);

			//Submit message
			$scope.submit = function(){
					$http.post("/message", this.formData).success(function (response) {
						$scope.formData = '';
					});
			}
		});
	</script>

</head>
<body>

<?php $this->beginBody() ?>
<div class="container">
	<div class="row " style="padding-top:40px;">
		<h3 class="text-center">Anonymous chat</h3>
		<br/><br/>
		<div class="col-md-12" data-ng-controller="chatController">

			<div class="panel panel-info">
				<div class="panel-heading">RECENT CHAT HISTORY</div>
				<div class="panel-body" style="height: 400px; overflow: scroll;">
					<ul class="media-list">
						<li class="media" data-ng-repeat="message in messages | orderBy : 'time':true">
							<div class="media-body">
								<div class="media">
									<div class="media-body">
										<small class="text-muted">{{message.ip}} | {{message.time | date:'dd.MM.yyyy H:mm:ss'}}
										</small>
										<br/>
										{{message.message}}
										<hr/>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="panel-footer">
					<div class="input-group">
						<form method="get" action="" data-ng-submit="submit()">
							<input type="text" name="message" data-ng-model="formData.message" class="input-group form-control" placeholder="Enter Message"/>
                                    <span class="input-group-btn">
										<input class="btn btn-info" type="submit" value="Submit Form">
                                    </span>
						</form>

					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
