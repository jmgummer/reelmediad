<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
?>

<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
	<h1 class="txt-color-red login-header-big">Reelforge</h1>
	<div class="hero">

		<div class="pull-left login-desc-box-l">
			<h4 class="paragraph-header">Experience the simplicity of Reelforge, everywhere you go!</h4>
			<div class="login-app-icons">
				<a href="javascript:void(0);" class="btn btn-danger btn-sm">Go to Site</a>
				<a href="javascript:void(0);" class="btn btn-danger btn-sm">Latest News</a>
			</div>
		</div>
		<img src="<?php echo Yii::app()->request->baseUrl . '/images/reelapp.jpg'; ?>" class="pull-right display-image" alt="" style="width:210px">
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<h5 class="about-heading">About Reelforge</h5>
			<p>
				We are a Media Monitoring Company, other text ....
			</p>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<h5 class="about-heading">Contact Us!</h5>
			<p>
				Contact us if you have any questions .....
			</p>
		</div>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
	<div class="well no-padding">
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array('id'=>'login-form','type'=>'horizontal','enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true), 'htmlOptions'=>array('class'=>'smart-form client-form'))); ?>
			<header>
				Sign In
			</header>
			<fieldset>
				<section>
					<?php echo $form->labelEx($model,'username',array('class'=>'label')); ?>
					<label class="input"> <i class="icon-append fa fa-user"></i>
					<?php echo $form->textField($model,'username'); ?></label>
					<?php echo $form->error($model,'username'); ?>
				</section>

				<section>
					<?php echo $form->labelEx($model,'password',array('class'=>'label')); ?>
					<label class="input"> <i class="icon-append fa fa-lock"></i>
					<?php echo $form->passwordField($model,'password'); ?></label>
					<?php echo $form->error($model,'password'); ?>
				</section>

			</fieldset>
			<footer>
				<?php echo CHtml::submitButton('Login', array('class'=>'btn')); ?>
			</footer>
		<?php $this->endWidget(); ?>
	</div>
</div>