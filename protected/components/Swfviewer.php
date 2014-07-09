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
        <span class="cmention">Download this Page : <a href="http://www.reelforge.com/reelmedia/files/pdf/'.$array->file.'">PDF File</a> | <a href="#">JPG Image</a> | <a href="#">Crop Image</a> | <a href="#">Highlight Page Section</a>
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
}

?>