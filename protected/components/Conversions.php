<?php
 class Conversions{

// Converts a number into a short version, eg: 1000 -> 1k
// Based on: http://stackoverflow.com/a/4371114
public static function number_format_short( $n ) {
 if ($n > 0 && $n < 1000) { 
 // 1 - 999 
 	$n_format = number_format($n); $suffix = '';
  } else if ($n >= 1000 && $n < 1000000) {
   // 1k-999k 
  	$n_format = number_format(($n / 1000),2); 
  	$suffix = 'K'; 
  }else if ($n >= 1000000 && $n < 1000000000) { 
  // 1m-999m
   $n_format = number_format(($n / 1000000),2); 
   $suffix = 'M'; 
}else if ($n >= 1000000000 && $n < 1000000000000) {
 // 1b-999b 
	$n_format = number_format(($n / 1000000000),2); 
	$suffix = 'B'; 
}  else if ($n >= 1000000000000) { 
// 1t+ 
	$n_format = number_format(($n / 1000000000000),2);
	 $suffix = 'T+'; 
} return !empty($n_format . $suffix) ? $n_format . $suffix : 0; 
}

 }