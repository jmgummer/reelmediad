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
		return '<table>
    <tr>
      <td width="100%" valign="top">
        <span class="style3">
          <strong>Newspaper : '.$array->Publication.'</strong> | <strong>Date</strong>: '.$array->FStoryDate.' | <strong>Page</strong>: '.$array->Page.' |<strong>Type</strong>: '.$array->MediaType.'
        </span>
      </td>
    </tr>
    <tr>
      <td width="100%" valign="top">
        <span class="cmention">Download this Page : <a href="http://www.reelforge.com/reelmedia/files/pdf/'.$array->file.'">PDF File</a> | <a href="'.Yii::app()->createUrl("swf/image", array("file"=>$array->file)).'">JPG Image</a> | <a href="'.Yii::app()->createUrl("swf/crop", array("file"=>$array->file)).'">Crop Image</a> | <a href="'.Yii::app()->createUrl("swf/highlight", array("file"=>$array->file)).'">Highlight Page Section</a>
        </span>
      </td>
    </tr>
    <tr>
      <td width="100%" valign="top">
        <span class="style3"><h3>'.$array->Title.'</h3><strong class="cmention">Companies Mentioned :</strong><font class="cmention">'.$array->CompanyMentions.'</font></span>
      </td>
    </tr>
  </table>';
	}

  public static function GetSwfFile($link)
  {
    return $_SERVER['DOCUMENT_ROOT'].'/reelmedia/files/pdf/'.$link;
  }
}

?>