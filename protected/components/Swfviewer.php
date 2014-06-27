<?php

class Swfviewer{
	public static function GetStory($id)
	{
		if($story = Story::model()->find('Story_ID=:a', array(':a'=>$id))){
			return $story;
		}
	}

	public static function GetSwfHeader()
	{
		return '<table>
    <tr>
      <td width="100%" valign="top">
        <span class="style3">
          <strong>Newspaper : The People Daily</strong> | <strong>Date</strong>: 25-Jun-2014 | <strong>Page</strong>: 46 |<strong>Type</strong>: Print
        </span>
      </td>
    </tr>
    <tr>
      <td width="100%" valign="top">
        <span class="cmention">Download this Page : <a href="#">PDF File</a> | <a href="#">JPG Image</a> | <a href="#">Crop Image</a> | <a href="#">Highlight Page Section</a>
        </span>
      </td>
    </tr>
    <tr>
      <td width="100%" valign="top">
        <span class="style3"><h3>Title</h3><strong class="cmention">Companies Mentioned :</strong><font class="cmention">Company 1, Company 2</font></span>
      </td>
    </tr>
  </table>';
	}
}

?>