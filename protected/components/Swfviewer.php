<?php

class Swfviewer{
	public static function GetStory($id)
	{
		if($story = Story::model()->find('Story_ID=:a', array(':a'=>$id))){
			return $story;
		}
	}

	public static function GetSwfHeader($array)
	{
		return '<p><strong>'.$array->Publication.'</strong><br>'.$array->FStoryDate.'<br>'.str_replace(':', '', $array->Page).'<br></p>
    <p><span class="cmention"><strong>Actions</strong> 
    <br><a href="http://www.reelforge.com/reelmedia/files/pdf/'.$array->file.'"><i class="fa fa-file-pdf-o"></i> Download PDF File</a> 
    <br><a href="'.Yii::app()->createUrl("swf/image", array("file"=>$array->file)).'"><i class="fa fa-file-image-o"></i> Download JPG Image</a> 
    <br><a href="'.Yii::app()->createUrl("swf/crop", array("file"=>$array->file)).'"><i class="fa fa-crop"></i> Crop This Image</a> 
    <br><a href="'.Yii::app()->createUrl("swf/highlight", array("file"=>$array->file)).'"><i class="fa fa-file-text"></i> Highlight Page Section</a></span></p>';
	}

  public static function GetSwfTitles($array){
    return '<span class="style3"><p><strong>'.$array->Title.'</strong></p><strong class="cmention">Companies Mentioned : </strong><font class="cmention">'.substr($array->CompanyMentions, 0, -2).'</font></span><br><hr class="simple"></hr>';
  }

  public static function GetSwfFile($link)
  {
    return $_SERVER['DOCUMENT_ROOT'].'/reelmedia/files/pdf/'.$link;
  }
}

?>