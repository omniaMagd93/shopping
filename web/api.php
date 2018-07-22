<?php

// $character = json_decode($data); //to convert to string
// echo $character->name;

$url = 'wizards.json'; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
// $characters = json_decode($data); // decode the JSON feed

// // echo $characters[0]->name; //to get first element in data

// foreach ($characters as $character) {
// 	echo $character->name . '<br>';
// }

// $characters = json_decode($data,true); // decode the JSON feed to associative array

// foreach ($characters as $character) {
//        echo $character['race'];
// }

$wizards = json_decode($data,true);
foreach ($wizards as $wizard) {
	echo $wizard['name'] . '\'s wand is ' . 
			 $wizard['wand'][0]['wood'] . ', ' . 
		   $wizard['wand'][0]['length'] . ', with a ' . 
		   $wizard['wand'][0]['core'] . ' core. <br>' ;
}