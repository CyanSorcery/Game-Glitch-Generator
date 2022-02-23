<?php
	//example usage of glitched image generator
	include('./glitchedimggen.php');
	
	//optimize the example sprite table
	spriteTableOpt('./example.png', './exampleopt.png', true, 64);
	
	//generate a glitched image based on this sprite table
	glitched_img_gen('./exampleopt.png', './'.time().'.png', 5);
?>