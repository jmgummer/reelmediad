<?php

class AccountController  extends Controller
{
	/**
	 * @var This is the Archive controller
	 */
	public $layout='//layouts/column1';

	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','password','users','updateuser','companies','assignclients'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$model=$this->loadModel(Yii::app()->user->user_id);
		// $this->render('index',array('model'=>$this->loadModel(Yii::app()->user->user_id)));
		if(isset($_POST['ClientUsers']))
		{
			$model->attributes=$_POST['ClientUsers'];
			if($model->save()){
				Yii::app()->user->setFlash('success', "<strong>Success ! </strong> Details Updated");
			}else{
				Yii::app()->user->setFlash('danger', "<strong>Error ! </strong>Your Details were not Updated, please try later");
			}
		}
		$this->render('index',array('model'=>$model,));
	}

	public function actionPassword()
	{
		$model=$this->loadModel(Yii::app()->user->user_id);
		if(isset($_POST['ClientUsers'])){
			$old = md5($_POST['ClientUsers']['dummypass']);
			$new = md5($_POST['ClientUsers']['dummypass2']);
			$confirm = md5($_POST['ClientUsers']['dummypass3']);

			if($_POST['ClientUsers']['dummypass2'] =='' || $_POST['ClientUsers']['dummypass3']==''){
				Yii::app()->user->setFlash('danger', "<strong>Error ! You need to add values in the Password Fields! </strong>");
			}else{
				if($old==$model->password && $new==$confirm){
					$model->password=$confirm;
					if($model->save()){
						Yii::app()->user->setFlash('success', "<strong>Success ! Your account password has been updated, login again to effect changes! </strong>");
					}
				}else{
					Yii::app()->user->setFlash('danger', "<strong>Error ! Your account could not be updated, check your passwords again! </strong>");
				}
			}
		}
		$this->render('update',array('model'=>$model,));
	}

	public function loadModel($id)
	{
		$model = ClientUsers::model()->find('client_users_id=:a', array(':a'=>$id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		elseif($model->client_users_id!=Yii::app()->user->user_id)
			throw new CHttpException(404,'The requested page does not exist.');
		else
			return $model;
	}

	public function actionUsers()
	{
		$this->render('users');
	}

	public function actionAdduser()
	{
		$this->render('adduser');
	}

	public function actionUpdateuser($id)
	{
		$model = AgencyUsers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		else
			$this->render('updateuser', array('model'=>$model));
		
		
	}

	public function actionCompanies()
	{
		$this->render('companies');
	}

	public function actionAssignclients($id)
	{
		$model = AgencyUsers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		else
			if(isset($_POST['remove'])){
				if(isset($_POST['company_id'])){
					$void = Yii::app()->input->stripClean($_POST['company_id']);
					foreach($void as $company_id)
					{
						$values = Products::model()->find('id=:a',array(':a'=>$company_id));
						if($values==true){
							if($values->delete()){
								Yii::app()->user->setFlash('success', "<strong>Success ! Product(s) Deleted </strong>");
							}else{
								Yii::app()->user->setFlash('danger', "<strong>Error ! Product(s) NOT Deleted </strong>");
							}
						}else{
							Yii::app()->user->setFlash('danger', "<strong>Warning ! Product(s) Could not be found, try again later </strong>");
						}
					}
				}else{
					Yii::app()->user->setFlash('danger', "<strong>Error ! You need to select at LEAST one Product</strong>");
				}
			}
			$user_id = $id;
			$this ->render('assignclients',array('user_id'=>$user_id));
	}
	
}
?>