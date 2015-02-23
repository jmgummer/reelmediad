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
				<?php echo $form->textField($model,'search_text',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs','autocomplete'=>"off", 'id'=>'search' )); ?>
			</label>
			<?php if(Yii::app()->user->usertype=='agency'){ ?>
			<div class="form-group">
				<header>Select Company</header>
				<?php 
				echo $form->dropDownList($model, 'company', 
				StorySearch::AgencyCompanies(Yii::app()->user->agencyusername), 
				array('prompt'=>'All Companies','class'=>'form-control', 'id'=>'clientid')); 
				?>
			</div>
			<?php }else{ ?> 
			<input type="hidden" value="<?php echo Yii::app()->user->company_id; ?>" id="clientid">
			<?php } ?>
		    <div class="form-group">
		    	<header>Publication</header>
				<?php echo $form->dropDownList($model, 'publications', StorySearch::getElecList(), array('prompt'=>'All','class'=>'form-control', 'id'=>'media_house_id')); ?>
			</div>
			<label class="input">
				<header>Beginning</header>
				<?php echo $form->textField($model,'startdate',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs','autocomplete'=>"off", 'id'=>'beginning')); ?>
			</label>
			<label class="input">
				<header>Ending</header>
				<?php echo $form->textField($model,'enddate',array('size'=>60,'maxlength'=>60, 'class'=>'input-xs','autocomplete'=>"off", 'id'=>'ending')); ?>
			</label>
		</fieldset>
		<footer>
		<?php echo CHtml::submitButton('Generate', array('class'=>'btn btn-primary', 'name'=>'Generate', 'id'=>'generate')); ?>
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

<script>
$('#beginning,#ending').datepick();
  $("#generate").click(
    function(event) {
    	event.preventDefault();
    	Generate();
    }
);
  
function loadcomplete()
{
	$("#imageloadstatus").hide();
}
function ShowMore(start,stop)
{
	clientid 		= document.getElementById('clientid').value;
	search 			= document.getElementById('search').value;
	beginning 		= document.getElementById('beginning').value;
	ending 			= document.getElementById('ending').value;
	media_house_id	= document.getElementById('media_house_id').value;
	load 			= document.getElementById("load-content");
	load.innerHTML 	= "<div id='preLoaderDiv'><img id='preloaderAnimation' src='<?php echo Yii::app()->request->baseUrl . "/images/loading.gif"; ?>' /></div>";
	$.ajax({
        url: '<?=Yii::app()->createUrl("radiotv/stories");?>',
        data: { 'start': start,'stop': stop,'clientid': clientid, 'search': search, 'beginning':beginning,'ending':ending,'media_house_id':media_house_id  },
        type: 'POST',
        cache: false,
        success: function(data){
            load.innerHTML = data;
        },
        error: function(){
        	load.innerHTML = "<br><h4><span class='label label-info'>There was an error generating the report! Please Try Again Later</span></h4>";
        },
        complete: function() {
            // loadcomplete();
        }
    });
}

function Generate()
{
	
	clientid 		= document.getElementById('clientid').value;
	search 			= document.getElementById('search').value;
	beginning 		= document.getElementById('beginning').value;
	ending 			= document.getElementById('ending').value;
	media_house_id	= document.getElementById('media_house_id').value;
	load 			= document.getElementById("load-content");
	load.innerHTML 	= "<div id='preLoaderDiv'> <img id='preloaderAnimation' src='<?php echo Yii::app()->request->baseUrl . "/images/loading.gif"; ?>' /></div>";
	$.ajax({
        url: '<?=Yii::app()->createUrl("radiotv/stories");?>',
        data: { 'clientid': clientid, 'search': search, 'beginning':beginning,'ending':ending,'media_house_id':media_house_id  },
        type: 'POST',
        cache: false,
        success: function(data){
            load.innerHTML = data;
        },
        error: function(){
        	load.innerHTML = "<br><h4><span class='label label-info'>There was an error generating the report! Please Try Again Later</span></h4>";
        },
        complete: function() {
            // loadcomplete();
        }
    });
}
  </script>