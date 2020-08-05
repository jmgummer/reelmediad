<?php

/**
* Swfviewer Component Class
* This Class Is Used To Render SWF Files to the Browser
* DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
* 
* @package     Reelmedia
* @subpackage  Components
* @category    Reelforge Client Systems
* @license     Licensed to Reelforge, Copying and Modification without prior permission is not allowed and can result in legal proceedings
* @author      Steve Ouma Oyugi - Reelforge Developers Team
* @version     v.1.0
* @since       July 2008
*/

class Swfviewer{
	public static function GetStory($id)
	{
		if($story = Story::model()->find('Story_ID=:a', array(':a'=>$id))){
			return $story;
		}
	}

	public static function GetSwfHeader($array)
	{
    $filename = str_replace(" ", "_", $array->Title).'_'.str_replace(" ", "_", $array->Publication).'_'.str_replace(" ", "_", $array->FStoryDate).'_'.str_replace(" ", "_", $array->Page);
    $filename = str_replace("_%", "_", $filename);
    // echo $array->File;

		return '<p><strong>'.$array->Publication.'</strong><br>'.$array->FStoryDate.'<br>'.str_replace(':', '', $array->Page).'<br>'.$array->Continues.'</p>
    <p><span class="cmention"><strong>Actions</strong> 
    <br><a href="'.Yii::app()->params['pdf_link'].$array->File.'" target="_blank"><i class="fa fa-file-pdf-o"></i> Download PDF File</a> 
    <br><a href="'.Yii::app()->createUrl("swf/image", array("file"=>$array->File, "name"=>"download_".$filename)).'" target="_blank"><i class="fa fa-file-image-o"></i> Download JPG Image</a> 
    <br><a href="'.Yii::app()->createUrl("swf/crop", array("file"=>$array->File, "name"=>"crop_".$filename)).'" target="_blank"><i class="fa fa-crop"></i> Crop This Image</a> 
    <br><a href="'.Yii::app()->createUrl("swf/highlight", array("file"=>$array->File, "name"=>"highlight_".$filename)).'" target="_blank"><i class="fa fa-file-text"></i> Highlight Page Section</a></span></p>
    <br><p><strong>Summary</strong><br>'.$array->Story.'</p>';
	}

  public static function PublicGetSwfHeader($array)
  {
    $filename = str_replace(" ", "_", $array->Title).'_'.str_replace(" ", "_", $array->Publication).'_'.str_replace(" ", "_", $array->FStoryDate).'_'.str_replace(" ", "_", $array->Page);
    $filename = str_replace("_%", "_", $filename);

    return '<p><strong>'.$array->Publication.'</strong><br>'.$array->FStoryDate.'<br>'.str_replace(':', '', $array->Page).'<br>'.$array->Continues.'</p>
    <p><span class="cmention"><strong>Actions</strong> 
    <br><a href="'.Yii::app()->params['pdf_link'].$array->File.'" target="_blank"><i class="fa fa-file-pdf-o"></i> Download PDF File</a> 
    <br><a href="'.Yii::app()->createUrl("swf/image", array("file"=>$array->File, "name"=>"download_".$filename)).'" target="_blank"><i class="fa fa-file-image-o"></i> Download JPG Image</a> 
    <br><a href="'.Yii::app()->createUrl("swf/crop", array("file"=>$array->File, "name"=>"crop_".$filename)).'" target="_blank"><i class="fa fa-crop"></i> Crop This Image</a> 
    <br><a href="'.Yii::app()->createUrl("swf/highlight", array("file"=>$array->File, "name"=>"highlight_".$filename)).'" target="_blank"><i class="fa fa-file-text"></i> Highlight Page Section</a></span></p>
    <br>';
  }

  public static function GetSwfTitles($array){
    return '<span class="style3"><h3>'.$array->Title.'</h3><strong class="cmention">Companies Mentioned : </strong><font class="cmention">'.substr($array->CompanyMentions, 0, -2).'</font></span><br><hr class="simple"></hr>';
  }

  public static function GetSwfFile($link)
  {
    $site = 'http://www.reelforge.com';
    // return $_SERVER['DOCUMENT_ROOT'].'/reelmedia/files/pdf/'.$link;
    return $site.'/reelmedia/files/pdf/'.$link;
  }
}

?>