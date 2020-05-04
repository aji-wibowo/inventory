<?php 


function visualArr($array){
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function currency_format($number){
	return number_format($number, 0, ',', '.');
}