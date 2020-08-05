<?php
   $this->pageTitle=Yii::app()->name.' | Media Stories';
   $this->breadcrumbs=array('Media Stories');

$country = Yii::app()->user->country_id;
$client = Yii::app()->user->company_id;
$user = Yii::app()->user->usertype;

//echo "<pre>".print_r($model,true)."</pre>";die();

?>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.css'; ?>">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.plugin.js'; ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.js'; ?>"></script>


<div id="wid-id-0"  class="jarviswidget jarviswidget-sortable col-md-3"style="" role="widget">
	<header role="heading"><center><h2>Media Search Form</h2></center></header>
	<div role="content">
		<div class="widget-body">
			<div class = "row">
   				<div class = "col-md-12">
      				<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array('id'=>'login-form','method'=>'POST','type'=>'smart-form','enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true), 'htmlOptions'=>array('class'=>'smart-form'))); ?>
                  

      					<div class="form-group">
                        <label for="Beginning:" class="control-label">Beginning:</label>
                        <?php echo $form->textField($story,'startdate',array('size'=>60,'required'=>'required','maxlength'=>60, 'class'=>'form-control','autocomplete'=>"off", 'id'=>'beginning','readonly'=>'readonly','placeholder'=>'Click to choose start date')); ?>
                     </div>
                     <div class="form-group">
                        <label for="Ending:" class="control-label">Ending:</label>
                       <?php echo $form->textField($story,'enddate',array('size'=>60,'maxlength'=>60, 'class'=>'form-control','autocomplete'=>"off", 'id'=>'ending','readonly'=>'readonly','required'=>'required','placeholder'=>'Click to choose End date')); ?>
                     </div>
                     <div class="form-group">
      						<label for="Journalist Name:" class="control-label">Journalist Name:</label>
                        <?php echo $form->dropDownList($story, 'firstname', Mediajournalist2::model()->getJournalistName(), array('prompt'=>'--All--','class'=>'form-control','id'=>'fullname')); ?>
      					</div>
      					<div class="form-group">
      						<label for="Media:" class="control-label">Media:</label>
      						<?php echo $form->dropDownList($story, 'Media_ID',Mediatable::model()->mediaType(), array('prompt'=>'--All--','class'=>'form-control','ajax' => array(
                                                'type'=>'POST', 
                                                'url'=>Yii::app()->createUrl('Home/media'), //  get MediaHouse list
                                                'update'=>'#media_house', // add the MediaHouse dropdown id
                                                'data'=>array('Media_ID'=>'js:this.value'),
                                                ))); 
                                                ?>
      					</div>
                     <div class="form-group">
                        <label for="Media House:" class="control-label">Media House:</label>
                        <?php echo $form->dropDownList($story, 'Media_House_List', Mediahouse::model()->getMediahouseName(), array('prompt'=>'--All--','class'=>'form-control select2','id'=>'media_house')); ?>
                     </div>
      					<div class="form-group">
      						<label for="Thematic Area:" class="control-label">Thematic Area:</label>
      						<select multiple="multiple" name="thematic[]" class="form-control" id="thematic">
      							<option value="">All</option>
      						</select>
      					</div>
      					<div class="form-group">
      						<label for="Industry:" class="control-label">Industry:</label>
      						<?php                              

                        if($user=='agency'){
              
                  echo $form->dropDownList($story, 'industry_List', Industry::model()->IndaNames(), array('ID'=>'Industry','class'=>'form-control','required'=>'required','multiple'=>true));
               }else{
                        echo $form->dropDownList($story, 'industry_List', Industry::model()->AgencyIndustryList($client), array('ID'=>'Industry','class'=>'form-control','required'=>'required','multiple'=>true)); 
               }
                        ?>
      					</div>
      				<footer id="footer">
      					<?php echo CHtml::submitButton('Generate', ['class'=>'btn btn-primary']); ?>
      				</footer>

      				<?php $this->endWidget(); ?>
    			</div>
			</div>
		</div>
</div>
</div>
<div class="col-md-9">

   <?php

   //If JournalistStory is SET  
   if(isset($_POST['JournalistStory'])){
      $excel = ExcelResults::Genexcel($results);
      $excel_link = Yii::app()->request->baseUrl."/docs/excel/".$excel;
      echo "<div class='row'>
               <div class='col-md-12'>
                     <center><a href = '$excel_link' target='_blank' name='excel_generator' class='btn btn-primary' style='margin:10px;'>Export as Excel <i class='fa fa-bg fa-file-excel-o'></i></a></center>
               </div>  
            </div>";
          echo "
            <div class='row'>
               <div class='col-md-12'>";  
       $count = 0;
      $story->startdate = date('Y-m-d');
      $story->enddate = date('Y-m-d');
      
      /*echo count($results) ."Records Found";*/
   //TABLE HEADER
      echo CHtml::openTag('table',array('width'=>'100%','class'=>'table table-hover table-bordered table-stripped','id'=>'jourmalist_story'));
      echo CHtml::openTag('thead',array('class'=>"thead-dark"));
      echo CHtml::openTag('tr');
      echo CHtml::tag('th', array(), '#');
      echo CHtml::tag('th', array(), 'DATE');
      echo CHtml::tag('th', array(), 'JOURNALIST');
      echo CHtml::tag('th', array(), 'PUBLICATION');
      echo CHtml::tag('th', array(), 'TITLE/HEADING');
      echo CHtml::tag('th', array(), 'PAGE');
      echo CHtml::tag('th', array(), 'AVE');

      echo CHtml::closeTag('tr',array());
      echo CHtml::closeTag('thead');

//Number of Rows
$NUM = count($results);

if ($NUM > 0) {
        foreach ($results as  $value) {
         //echo"<pre>".print_r($value)."</pre>";
         //data
         

      $count++;
      if ($count > 0) {
        $jname = $value['journalist'];
      $sdate = $value['StoryDate'];
      $title = $value['Title'];
      $media = $value['Media_House_ID'];
      $page = $value['StoryPage'];
      $ave = $value['ave'];
      $stmedia = $value['Media_ID'];
      $Story_ID = $value['Story_ID'];
      $mediahouse = Mediahouse::model()->getMediahouseName2($media);
      $me = implode("", $mediahouse);

      //data Link
      if ($stmedia == 'mp01') {
         $link = "https://media.reelforge.com/player/index.php?storyid=$Story_ID";
         $page = $page;
      } else {
         $link = "https://media.reelforge.com/player/video.php?storyid=$Story_ID";
         $page = '--';
      }
      
      //data-table
      
      echo CHtml::openTag('tr');
      echo CHtml::Tag('td',array(),$count);
      echo CHtml::Tag('td',array(), $sdate);
      echo CHtml::Tag('td',array(), $jname);
      echo CHtml::Tag('td',array(),$me);
      echo CHtml::Tag('td',array(),CHtml::link($title,$link,array('target' => '_blank')));
      echo CHtml::Tag('td',array(),$page);
      echo CHtml::Tag('td',array(),$ave);
      echo CHtml::closeTag('tr');       

      }
      
      
               
            }
            // display pagination
/*$this->widget('CLinkPager', array(
    'pages' => $pages,
    ))*/
} else {
      echo CHtml::openTag('tr');
      echo CHtml::tag('td',array('colspan'=>'7'),"<div class='alert alert-danger'>No Records Found.</div>");
      echo CHtml::closeTag('tr');
}  

      
   



         }else{
               echo "<center><h2><div class='alert alert-info'>Your data will be displayed here</div></h2></center>";
            }
       echo CHtml::closeTag('table');

echo "</div>";

         ?>
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
.form-group{
	border-bottom: dotted 1px;
	padding-bottom:10px;
}

</style>
<script type="text/javascript">
$(document).ready(function() {
//date Picker
   if ($('#beginning').val() =='') {
      var b_today = new Date().toISOString().slice(0,10);
   } else {
       var b_today = $('#beginning').val();
   }

   if ($('#ending').val() =='') {
      var e_today = new Date().toISOString().slice(0,10);
   } else {
       var e_today = $('#ending').val();
   }
   
   $('#beginning').datepick({dateFormat: "yyyy-mm-dd", todayHighlight: true,autoclose: true}).datepick("setDate", b_today);
   $('#ending').datepick({dateFormat: "yyyy-mm-dd", todayHighlight: true,autoclose: true}).datepick("setDate", e_today);
//End Of DatePicker
   $('#jourmalist_story').DataTable();
   $('.select2').select2();
} );
</script>