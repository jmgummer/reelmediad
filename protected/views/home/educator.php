<p>Welcome to your Educator account.</p>
<?php
$model = new StorySearch('search');
		$model->unsetAttributes();
		if(isset($_POST['StorySearch']))
		{
			$model->attributes=Yii::app()->input->stripClean($_POST['StorySearch']);
			$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
			$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		}else{
			$clientid = Yii::app()->user->company_id;
			$classificationsql = "SELECT * FROM company_story_classification WHERE company_id = $clientid ORDER BY classification_order";
			$cats = CompanyStoryClassification::model()->findAllBySql($classificationsql);
			$catsarray = array();
			if($cats){
				foreach ($cats as $key) {
					$catsarray[] = $key->classification_id;
				}
			}
			$model->storytype = 1;
			$model->industry = $catsarray;
			$model->startdate = date('Y-m-d');
			$model->enddate = date('Y-m-d');
		}
		
		?><link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.css'; ?>"> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.plugin.js'; ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.js'; ?>"></script>
<div class="row-fluid clearfix">
<div class="col-md-12">
<div id="wid-id-0" class="jarviswidget jarviswidget-sortable"style="" role="widget">
	<header role="heading"><h2>Search Form</h2></header>
	<div role="content">
		<div class="widget-body no-padding">
			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array('id'=>'login-form','type'=>'smart-form','enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true), 'htmlOptions'=>array('class'=>'smart-form'))); ?>
			<?php echo $form->errorSummary($model); ?>
			<fieldset>
			    <?php if(Yii::app()->user->usertype=='agency'){ ?>
					<div class="col-md-4">
						<div class="form-group">
							<header>Select Company</header>
							<?php echo $form->dropDownList($model, 'company', StorySearch::AgencyCompanies(Yii::app()->user->agencyusername), 
							array(
								'empty'=>'--Please Select An Company --',
								'class'=>'form-control forcehs',
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
			</fieldset>
		<footer>
		<?php echo CHtml::submitButton('Generate', array('class'=>'btn btn-primary')); ?>
		</footer>
		<?php $this->endWidget(); ?>
		</div>
	</div>
</div>
</div>
<div class="col-md-12">
<?php
$startdate = $model->startdate;
	$enddate = $model->enddate;
$clientid = Yii::app()->user->company_id;
	// $startdate = $model->startdate;
	// $enddate = $model->enddate;
	$initialized = new EducatorSearch($clientid,$startdate,$enddate);
	$data = $initialized->GetMentions();
	$tabledata = $initialized->CreateTable();
	echo '<div class="tab-pane fade active in" id="s4">';
	echo $tabledata;
	echo '</div>';
	?>
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
.radio label{
	/*font-weight: bold;*/
	/*margin-left: -10px;*/
}
.search-params{
	padding: 10px 13px;
	clear: both;
}
.pdf-excel{
	margin: 5px 1px;
}
#chat-body {
    background: linear-gradient(to bottom, #F5FCFF 0px, #FFF 100%) repeat scroll 0% 0% transparent;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.04) inset;
    display: block;
    height: 270px;
    overflow-y: scroll;
    overflow-x: hidden;
    padding: 10px;
    box-sizing: border-box;
    border-right: 1px solid #FFF;
    border-width: 0px 1px 1px;
    border-style: none solid solid;
    border-color: -moz-use-text-color #FFF #FFF;
    -moz-border-top-colors: none;
    -moz-border-right-colors: none;
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    border-image: none;
}
table{
	font-size: 12px;
}
table a{
	color: #2F5961;
}
.reveal-footer{
	display: block;
	padding: 7px 14px 15px;
	border-top: 1px solid rgba(0, 0, 0, 0.1);
	background: none repeat scroll 0% 0% rgba(248, 248, 248, 0.9);
	margin: 0px;
	box-sizing: content-box;
	color: #666;
	border: 1px solid #C2C2C2;
}
</style>
<script type="text/javascript">
$('#beginning,#ending').datepick({dateFormat: "yyyy-mm-dd"});
  </script>