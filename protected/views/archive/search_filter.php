<?php 

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
			<?php if(Yii::app()->user->usertype=='agency'){ ?>
			<div class="form-group">
				<header>Select Company</header>
				<?php echo $form->dropDownList($model, 'company', StorySearch::AgencyCompanies(Yii::app()->user->agencyusername), array('class'=>'form-control')); ?>
			</div>
			<?php } ?>
		    <div class="form-group">
		    	<header>Publication</header>
				<?php echo $form->dropDownList($model, 'publications', StorySearch::getPrintList('mp01'), array('prompt'=>'All','class'=>'form-control')); ?>
			</div>
			<label class="input">
				<header>Beginning</header>
				<?php echo $form->textField($model,'startdate',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs','autocomplete'=>"off")); ?>
			</label>
			<label class="input">
				<header>Ending</header>
				<?php echo $form->textField($model,'enddate',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs','autocomplete'=>"off")); ?>
			</label>
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
	padding: 0px 10px 0px 0px;
}
.smart-form .checkbox label{
	text-decoration: underline;
}
.smart-form .checkbox .checkbox{
	padding-left: 20px;
	text-decoration: none;
}
.smart-form .checkbox .checkbox label{
	text-decoration: none;
	font-size: 11px;
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
/* Jquery UI Datepicker
    /*====================================================================*/
    $(function () {
        // Date
        $('input[name="StorySearch[start_date]"]').datepicker();
    });
</script>
<script>
  $(function() {
    $( "#StorySearch_startdate" ).datepicker();
    $( "#StorySearch_enddate" ).datepicker();
  });
  </script>