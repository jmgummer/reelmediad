<?php $this->breadcrumbs=array('Highlight Image Sections'); ?>
<?php $image = $png_file; ?>
<?php if(isset($_GET['name'])){ $title = preg_replace('/[^A-Za-z0-9\-\_]/', '', $_GET['name']); } else{ $title = 'highlight'; } ?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/cropper.min.js'; ?>"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . '/css/cropper.css'; ?>">
<div class="row-fluid clearfix">
	<div class="example">
        <h2>Image Highlighting</h2>
        <p><em>Click and drag anywhere on the image below to select the area to highlight and click the button</em></p>
        <p><form class="form-horizontal">
            <div class="form-group dont-show">
                <label class="col-xs-5 control-label"><em>x1</em> coordinate</label>
                <div class="col-xs-7">
                    <input type="text" name="x1" id="x-1" class="form-control" value="0" />
                </div>
            </div>
            <div class="form-group dont-show">
                <label class="col-xs-5 control-label"><em>x2</em> coordinate</label>
                <div class="col-xs-7">
                    <input type="text" name="x2" id="x-2" class="form-control" value="0" />
                </div>
            </div>
            <div class="form-group dont-show">
                <label class="col-xs-5 control-label"><em>y1</em> coordinate</label>
                <div class="col-xs-7">
                    <input type="text" name="y1" id="y-1" class="form-control" value="0" />
                </div>
            </div>
            <div class="form-group dont-show">
                <label class="col-xs-5 control-label"><em>y2</em> coordinate</label>
                <div class="col-xs-7">
                    <input type="text" name="y2" id="y-2" class="form-control" value="0" />
                </div>
            </div>
            <div class="form-group dont-show">
                <label class="col-xs-5 control-label">Selected <em>width</em></label>
                <div class="col-xs-7">
                    <input type="text" name="width" id="width-1" class="form-control" value="0" />
                </div>
            </div>
            <div class="form-group dont-show">
                <label class="col-xs-5 control-label">Selected <em>height</em></label>
                <div class="col-xs-7">
                    <input type="text" name="height" id="height-1" class="form-control" value="0" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-5 control-label"></label>
                <div class="col-xs-7">
                    <input type="submit" value="Highlight Section" class="btn btn-primary" onclick="event.preventDefault();SendData(this);" />
                </div>
            </div>
        </form></p>
        <?php echo '<img src="http://www.reelforge.com/reelmediad/conversions/'.$png_file.'" style="width:1000px; height:1298px;" id="image-1" alt="" />'; ?>
    </div>
</div>
<style type="text/css">
.dont-show{
    display: none;
}
</style>
<script type="text/javascript">
    document.getElementById('image-1').onload = function () {
        new Cropper(this, {
            update: function (coordinates) {
                for (var i in coordinates) {
                    document.getElementById(i + '-1').value = coordinates[i];
                }
                
                var x1 = parseInt(document.getElementById('x-1').value);
                var w1 = parseInt(document.getElementById('width-1').value);
                var total = x1 + w1;
                document.getElementById('x-2').value = total;

                var y1 = parseInt(document.getElementById('y-1').value);
                var h1 = parseInt(document.getElementById('height-1').value);
                var total2 = y1 + h1;
                document.getElementById('y-2').value = total2;
            }
        });
    }
    function SendData(){
        var x1 = document.getElementById("x-1").value;
        var y1 = document.getElementById("y-1").value;
        var width = document.getElementById("width-1").value;
        var height = document.getElementById("height-1").value;
        var image = '<?=$image;?>';
        var link = '<?=Yii::app()->createUrl("swf/manipulator");?>';
        var name = '<?=$title;?>';

        if (x1 == null || x1 == 0 || y1 == null || y1 ==0 || width == null || width == 0 || height == null || height ==0 ) {
            alert("Please Select Required Fields");
            return false;
        }else{
            $.ajax({
                // This is the Post Instruction
                url: link,
                data: { 'x1': x1, 'y1': y1, 'width':width,'height':height,'image':image },
                type: 'POST',
                cache: false,

                success: function(data) {
                    // window.location = "http://www.reelforge.com/reelmediad/tmp/"+data;
                    window.location = "http://www.reelforge.com/reelmediad/swf/downloadimage/?image="+data+"&name="+name;
                },
                //In Case Of Failure, Do This
                error: function() {
                    alert("Error! There was an error Generating the Section, Notify Admin");
                }
            });
        }
    }
</script>