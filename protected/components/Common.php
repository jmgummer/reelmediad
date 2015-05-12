<?php

class Common{

	public static function ExcelNumberFormat($value){
		$formatted = $value;
		$cleaned = str_replace(",", "", $formatted);
		return $cleaned;
	}
}