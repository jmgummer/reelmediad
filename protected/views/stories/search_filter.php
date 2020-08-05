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
			<div class="col-md-4">
				<label class="input">
					<header>Search Text</header>
					<?php echo $form->textField($model,'search_text',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs forcehs','autocomplete'=>"off" )); ?>
				</label>
			</div>
			<div class="col-md-4">
				<label class="input">
					<header>Beginning</header>
					<?php echo $form->textField($model,'startdate',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs forcehs','autocomplete'=>"off", 'id'=>'beginning')); ?>
				</label>
			</div>
			<div class="col-md-4">
				<label class="input">
					<header>Ending</header>
					<?php echo $form->textField($model,'enddate',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs forcehs','autocomplete'=>"off", 'id'=>'ending')); ?>
				</label>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<header>Type of Story</header>
					<?php echo $form->dropDownList($model,'storytype', StoryType::model()->getStoryTypes(), array('class'=>'form-control forcehs')); ?>
			    </div>
		    </div>
		    <?php if(Yii::app()->user->usertype=='agency'){ ?>
				<div class="col-md-4">
					<div class="form-group">
						<header>Select Company</header>
						<?php echo $form->dropDownList($model, 'company', StorySearch::AgencyCompanies(Yii::app()->user->agencyusername), 
						array(
							'empty'=>'--Please Select An Company --',
							'class'=>'form-control forcehs',
							'ajax'=>array(
								'type'=>'POST',
								'data'=>array('classificationcompany'=>'js:this.value'),
								'url'=>CController::createURL('getdata'),'update'=>'#StorySearch_industry',
								),
							'required'=>'required'
							)); 
						?>
					</div>
				</div>
			<?php }else{ ?>
				<div class="col-md-4">
					<div class="form-group">
						<header>Company</header>
						<?php echo $form->dropDownList($model, 'company', array(Yii::app()->user->company_id=>Yii::app()->user->company_name), 
						array(
							'class'=>'form-control forcehs',
							'required'=>'required'
							)); 
						?>
					</div>
				</div>
			<?php } ?>
		    <div class="col-md-4">
				<div class="form-group">
					<header>Classification</header>
					<?php 
					if(Yii::app()->user->usertype=='agency'){
						if(isset($model->company)){
							echo $form->dropDownList($model, 'industry', CompanyStoryClassification::model()->getCompanyClassificationList($model->company), array('multiple'=>true, 'class'=>'form-control','required'=>'required'));
						}else{
							echo $form->dropDownList($model, 'industry', array(), array('multiple'=>true, 'class'=>'form-control','required'=>'required'));
						}
						
					}else{
						echo $form->dropDownList($model, 'industry', CompanyStoryClassification::model()->getClassificationList(), array('multiple'=>true, 'class'=>'form-control','required'=>'required'));
					} 
					?>
				</div>
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
.forcehs{
	height: 32px !important;
	font-size: 13px !important;
}
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