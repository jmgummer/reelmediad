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
				<?php echo $form->textFieldRow($model,'search_text',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs')); ?>
			</label>
			<hr class="simple"></hr>
			<label class="input">
				<?php echo $form->textFieldRow($model,'startdate',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs')); ?>
			</label>
			<hr class="simple"></hr>
			<label class="input">
				<?php echo $form->textFieldRow($model,'enddate',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs')); ?>
			</label>
			<hr class="simple"></hr>
			<label class="checkbox">
				<?php echo $form->checkBoxRow($model,'country', array('checked'=>'checked')); ?>
			</label>
			<hr class="simple"></hr>
			<label class="radio">
				<?php echo $form->radioButtonListRow($model,'storytype', StoryType::model()->getStoryTypes(), array('class'=>'radio-beat')); ?>
		    </label>
		    <hr class="simple"></hr>
		    <label class="radio">
		    	<?php echo $form->radioButtonListRow($model,'storycategory', StoryCategory::model()->getStoryCategories()); ?>
			</label>
			<hr class="simple"></hr>
		    <div class="form-group">
				<?php echo $form->dropDownListRow($model, 'news_section', Category::model()->getCategories(), array('prompt'=>'All','class'=>'form-control')); ?>
			</div>
			<hr class="simple"></hr>
			<div class="form-group">
				<?php echo $form->dropDownListRow($model, 'industry', Industry::model()->getIndustryList(), array('multiple'=>true, 'class'=>'form-control')); ?>
			</div>
			<hr class="simple"></hr>
			<label class="checkbox">
				<?php echo $form->checkBoxRow($model,'create_sheet', array('value'=>1, 'uncheckValue'=>0)); ?>
			</label>
			<hr class="simple"></hr>
			<label class="checkbox">
				<?php echo $form->checkBoxRow($model,'create_pdf',array('value'=>1, 'uncheckValue'=>0)); ?>
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