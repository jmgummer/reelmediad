<?php
if(!isset($_POST['StorySearch']))
{
	$model->startdate = date('Y-m-d');
	$model->enddate = date('Y-m-d');
}
?>
<div id="wid-id-0" class="jarviswidget jarviswidget-sortable"style="" role="widget">
	<header role="heading"><h2>Search Form</h2></header>
	<div role="content">
		<div class="widget-body no-padding">
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array('id'=>'login-form','type'=>'smart-form','enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true), 'htmlOptions'=>array('class'=>'smart-form'))); ?>
		<?php echo $form->errorSummary($model); ?>
		<fieldset>
			<label class="input">
				<header>Search Text</header>
				<?php echo $form->textField($model,'search_text',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs','autocomplete'=>"off" )); ?>
			</label>
			<label class="input">
				<header>Beginning</header>
				<?php echo $form->textField($model,'startdate',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs','autocomplete'=>"off", 'id'=>'beginning')); ?>
			</label>
			<label class="input">
				<header>Ending</header>
				<?php echo $form->textField($model,'enddate',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs','autocomplete'=>"off", 'id'=>'ending')); ?>
			</label>
			<?php if(Yii::app()->user->usertype=='agency'){ ?>
			<div class="form-group">
				<header>Select Company</header>
				<?php echo $form->dropDownList($model, 'company', StorySearch::AgencyCompanies(Yii::app()->user->agencyusername), 
				array(
					'empty'=>'--Please Select An Company --',
					'class'=>'form-control',
					'ajax'=>array(
						'type'=>'POST',
						'data'=>array('company'=>'js:this.value'),
						'url'=>CController::createURL('getdata'),'update'=>'#StorySearch_industry',
						),
					'required'=>'required'
					)); 
				?>
			</div>
			<?php } ?>
			<div class="form-group">
				<header>Platform</header>
				<?php echo $form->dropDownList($model,'storytype', Platforms::model()->getPlatformList(), array('class'=>'form-control')); ?>
		    </div>
			<div class="form-group">
				<header>Classification</header>
				<?php 
				echo $form->dropDownList($model, 'industry', Themes::model()->getCompanyList($onlinecompany->id), array('multiple'=>true, 'class'=>'form-control','required'=>'required'));
				?>
			</div>
			
		</fieldset>
		<footer>
		<?php echo CHtml::submitButton('Generate', array('class'=>'btn btn-primary')); ?>
		</footer>
		<?php $this->endWidget(); ?>




		</div>
	</div>
</div>
<style type="text/css">
.smart-form .alert ul li{
	list-style: none;
}
.smart-form .checkbox{
	padding: 0px 10px;
}
.smart-form .checkbox input, .smart-form .radio input{
	position: relative;
	left: 0;
}
.smart-form .checkbox input{
	margin-top: 6px;
}
.smart-form .radio{
	padding-left: 10px;
}
label header, .form-group header,  .radio header {
	font-size: 13px !important;
	margin: 0px 0px 10px 0px !important;
}

fieldset .col-md-4{
	width: 32.33%;
	padding: 0px 10px 0px 0px;
}
fieldset .col-md-3{
	width: 22.33%;
	padding: 0px 10px 0px 0px;
}
</style>
<script type="text/javascript">
$('#beginning,#ending').datepick({dateFormat: "yyyy-mm-dd"});
  </script>