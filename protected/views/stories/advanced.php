<?php
$this->pageTitle=Yii::app()->name.' | Advanced Search';
$this->breadcrumbs=array('Advanced Search');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.css'; ?>"> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.plugin.js'; ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.js'; ?>"></script>
<div class="row-fluid clearfix">
<div class="col-md-12">
<?php $this->renderPartial('advancedsearch_filter',array('model'=>$model)); ?>
</div>
<div class="col-md-12">

<?php
$todays = date('Y-m-d');
$startdate = $enddate = $todays;
$search = ' ';
// Adding Country Code
$country = Yii::app()->user->country_id;
$industries = '';
echo '<div class="widget-body">
<ul id="myTab1" class="nav nav-tabs bordered">
<li class="active"><a href="#s4" data-toggle="tab">Advanced Search</a></li>
<li class="pull-right">
<a href="javascript:void(0);">
<div class="sparkline txt-color-pinkDark text-align-right" data-sparkline-height="18px" data-sparkline-width="90px" data-sparkline-barwidth="7"><canvas width="52" height="18" style="display: inline-block; width: 52px; height: 18px; vertical-align: top;"></canvas></div> </a>
</li>
</ul>';
echo '<div id="myTabContent1" class="tab-content padding-10">';

$html = '';
if(isset($_POST['StorySearch'])){
	if(Yii::app()->user->usertype=='agency'){
		$clientid = $model->company;
	}else{
		$clientid = Yii::app()->user->company_id;
	}
	$startdate = $model->startdate;
	$enddate = $model->enddate;
	$initialized = new AdvancedSearch($clientid,$startdate,$enddate);
	$data = $initialized->GetMentions();
	$tabledata = $initialized->CreateTable();
	echo '<div class="tab-pane fade active in" id="s4">';
	echo $tabledata;
	echo '</div>';
	?>
	<?php
}else{
	echo '<div class="tab-pane fade active in" id="s4">';
	echo "<p>Select start and end date to search</p>";
	echo '</div>';
}

echo '</div>';
echo '</div>';  
?>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="clsmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Classification</h4>
      </div>
      <div class="modal-body">
        <div id="editsector"></div>
        <input type="hidden" name="clsstoryid" id="clsstoryid" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveClsUpdate();">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="techmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Technical Area</h4>
      </div>
      <div class="modal-body">
        <div id="edit_technical_sector"></div>
        <input type="hidden" name="tareastoryid" id="tareastoryid" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveTAUpdate();">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tnltymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Tonality</h4>
      </div>
      <div class="modal-body">
        <div id="edittonalysector"></div>
        <input type="hidden" name="tnlystoryid" id="tnlystoryid" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="SaveTnlyUpdate();">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function UpdateClientClassification(storyid){
		var link = '../stories/editclassification';
		var clientid = $('#StorySearch_company').val();
		$('#clsmodal').modal('show');
		document.getElementById('clsstoryid').value = storyid;
	    var load = document.getElementById('editsector');
	    load.innerHTML = "Loading data ...";
	    jQuery.ajax({
	        url:link,
	        data:{'storyid':storyid,'clsmodal':true,'clientid':clientid},
	        type:'POST',
	        cache:false,
	        success:function(data){
	            load.innerHTML = data;
	        },
	        error:function(){
	            load.innerHTML = "There was an error processing the request";
	        }
	    });
	}
	function SaveClsUpdate(){
		var link = '../stories/editclassification';
		var storyid = $('#clsstoryid').val();
		var clsclassific = $('#clsclassific').val();
		var editid = $('#editid').val();
		var clientid = $('#StorySearch_company').val();
		var load = document.getElementById('editsector');
		jQuery.ajax({
	        url:link,
	        data:{'storyid':storyid,'clsclassific':clsclassific,'editid':editid,'clsedmodal':true,'clientid':clientid},
	        type:'POST',
	        cache:false,
	        success:function(data){
	            load.innerHTML = data;
	        },
	        error:function(){
	            load.innerHTML = "There was an error processing the request";
	        }
	    });
	}
	function UpdateTechnicalArea(storyid){
		var link = '../stories/edittechnicalarea';
		var clientid = $('#StorySearch_company').val();
		$('#techmodal').modal('show');
		document.getElementById('tareastoryid').value = storyid;
	    var load = document.getElementById('edit_technical_sector');
	    load.innerHTML = "Loading data ...";
	    jQuery.ajax({
	        url:link,
	        data:{'storyid':storyid,'techmodal':true,'clientid':clientid},
	        type:'POST',
	        cache:false,
	        success:function(data){
	            load.innerHTML = data;
	        },
	        error:function(){
	            load.innerHTML = "There was an error processing the request";
	        }
	    });
	}
	function SaveTAUpdate(){
		var link = '../stories/edittechnicalarea';
		var tarea_id = $('#tarea_id').val();
		var techstoryid = $('#techstoryid').val();
		var t_country = $('#t_country').val();
		var t_county = $('#t_county').val();
		var clientid = $('#StorySearch_company').val();
		var load = document.getElementById('edit_technical_sector');
		load.innerHTML = "Saving ... ";
		jQuery.ajax({
	        url:link,
	        data:{'tarea_id':tarea_id,'techstoryid':techstoryid,'t_country':t_country,'t_county':t_county,'tedmodal':true,'clientid':clientid},
	        type:'POST',
	        cache:false,
	        success:function(data){
	            load.innerHTML = data;
	        },
	        error:function(){
	            load.innerHTML = "There was an error processing the request";
	        }
	    });
	}
	function AddClientTonality(storyid){
		var link = '../stories/edittonality';
		var clientid = $('#StorySearch_company').val();
		$('#tnltymodal').modal('show');
		document.getElementById('tnlystoryid').value = storyid;
	    var load = document.getElementById('edittonalysector');
	    load.innerHTML = "Loading data ...";
	    jQuery.ajax({
	        url:link,
	        data:{'storyid':storyid,'tnltymodal':true,'clientid':clientid},
	        type:'POST',
	        cache:false,
	        success:function(data){
	            load.innerHTML = data;
	        },
	        error:function(){
	            load.innerHTML = "There was an error processing the request";
	        }
	    });
	}
	function SaveTnlyUpdate(){
		var link = '../stories/edittonality';
		var storyid = $('#tnlystoryid').val();
		var tnlyclassific = $('#tnlyclassific').val();
		var editid = $('#editid').val();
		var clientid = $('#StorySearch_company').val();
		var load = document.getElementById('edittonalysector');
		jQuery.ajax({
	        url:link,
	        data:{'storyid':storyid,'tnlyclassific':tnlyclassific,'editid':editid,'clsedmodal':true,'clientid':clientid},
	        type:'POST',
	        cache:false,
	        success:function(data){
	            load.innerHTML = data;
	        },
	        error:function(){
	            load.innerHTML = "There was an error processing the request";
	        }
	    });
	}
</script>

<style type="text/css">
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