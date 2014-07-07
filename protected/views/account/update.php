<?php
$this->pageTitle=Yii::app()->name.' | Client Account';
$this->breadcrumbs=array('User Account'=>array('account/index'), 'Change Password');
?>

<?php

// if($user_details = ClientUsers::model()->find('client_users_id=:a', array(':a'=>Yii::app()->user->user_id)))
// {
// 	echo 'Awesome';
// }else{
// 	echo 'Trouble';
// }

?>

<div id="wid-id-0" class="jarviswidget jarviswidget-sortable"style="" role="widget">
	<header role="heading"><h2>Update Your Password</h2></header>
	<div role="content">
		<div class="widget-body no-padding">
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array('id'=>'login-form','type'=>'smart-form','enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true), 'htmlOptions'=>array('class'=>'smart-form'))); ?>
		<?php echo $form->errorSummary($model); ?>
		<fieldset>
			<label class="input">
				<?php echo $form->passwordFieldRow($model,'dummypass',array('required'=>'required', 'class'=>'input-xs','placeholder'=>'')); ?>
			</label>
			<label class="input">
				<?php echo $form->passwordFieldRow($model,'dummypass2',array('required'=>'required', 'class'=>'input-xs')); ?>
			</label>
			<label class="input">
				<?php echo $form->passwordFieldRow($model,'dummypass3',array('required'=>'required', 'class'=>'input-xs')); ?>
			</label>
		</fieldset>
		<footer>
		<?php echo CHtml::submitButton('Save', array('class'=>'btn btn-success')); ?>
		</footer>
		<?php $this->endWidget(); ?>




		</div>
	</div>
</div>