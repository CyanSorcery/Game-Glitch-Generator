<?php

/*
	NES/SNES/GB Glitched Image Generator
	
	Copyright (C) 2021 CyanSorcery
	
	Generates a glitched image in the style of an old game console.
	
*/

//Include palette functions
require('glitchedfunct.php');

function glitched_img_gen($gfx_table_path, $output_path, $scale = 4, $mode_switch = 'RAND')
{
	/*
		Function that generates the glitched images
		
		Arguments:
			$gfx_table_path			= Path to the graphics table we'll be sampling from
			$output_path 			= Location where the file will be saved
			$scale					= (Optional) (Default: 4) How much to upscale the final image
			$mode_switch			= (Optional) (Default: random) What graphics mode to use
		Returns:
			nothing
	*/
	
	//Supported modes
	$modes			= Array('NES', 'SNES', 'GB');
	
	//Is the passed mode a valid mode? if not, simply pick one
	if (in_array($mode_switch, $modes))
		$mode = $mode_switch;
	else
		$mode = $modes[mt_rand(0, count($modes) - 1)];
	
	//Get the appropriate palette for our mode
	//Palette format is as follows:
	//		[pal_index][col_index][r, g, b, a]
	
	switch ($mode)
	{
		case 'NES':
		{
			$our_pal			= get_nes_palette();
			$rand_spr_count		= mt_rand(3, 8);
			$obj_max_size		= 3;
			$screen_w			= 256;
			$screen_h			= 240;
			break;
		}
		
		case 'SNES':
		{
			$our_pal			= get_snes_palette();
			$rand_spr_count		= mt_rand(3, 12);
			$obj_max_size		= 4;
			$screen_w			= 256;
			$screen_h			= 240;
			break;
		}
		
		case 'GB':
		{
			$our_pal			= get_gb_palette();
			$rand_spr_count		= mt_rand(3, 8);
			$obj_max_size		= 3;
			$screen_w			= 160;
			$screen_h			= 144;
			break;
		}
	}
	
	//Get our graphics table
	$graphics_table		= imagecreatefrompng($gfx_table_path);
	$graphics_table_w	= imagesx($graphics_table);
	$graphics_table_h	= imagesy($graphics_table);
	
	//How many cells this is
	$graphics_cells_x	= floor($graphics_table_w / 8);
	$graphics_cells_y	= floor($graphics_table_h / 8);
	
	//Create an image which will replicate the RAM of the console
	//Designed to fit 512 8x8 tiles total
	$tile_table			= imagecreate(256, 128);
	$tile_table_w		= imagesx($tile_table);
	$tile_table_h		= imagesy($tile_table);
	
	//Copy the palette from the graphics table to our tile table
	imagepalettecopy($tile_table, $graphics_table);
	
	//Convert the tile table to true color and then back
	//This randomizes the color palettes
	//imagepalettetotruecolor($tile_table);
	//imagetruecolortopalette($tile_table, false, 255);
	
	//Possible flip modes
	$flipmodes = Array(
				1 => IMG_FLIP_HORIZONTAL,
				2 => IMG_FLIP_VERTICAL,
				3 => IMG_FLIP_BOTH
				);
	
	//A single sprite
	$single_sprite		= imagecreate(8, 8);
	imagepalettecopy($single_sprite, $tile_table);
	
	//Copy random bits of the graphics table into our tile table
	//It's possible but unlikely that this code can copy the same chunk of graphics multiple
	//times, but due to the randomization of this all, it shouldn't be noticeable
	for ($x = 0; $x < $tile_table_w; $x+=8)
	{
		for ($y = 0; $y < $tile_table_h; $y+=8)
		{
			//Random chance of it just being a garbage tile
			if (mt_rand(0, 10) > 8)
			{
				//Generate garbage tile, replicates when games use code as tile graphics
				for ($garbage_x = $x; $garbage_x < $x + 8; $garbage_x++)
				{
					for ($garbage_y = $y; $garbage_y < $y + 8; $garbage_y++)
					{
						imagesetpixel($tile_table, $garbage_x, $garbage_y, mt_rand(0, 3));
					}
				}
			}
			else
			{
				//Copy the tile to the single sprite
				imagecopy($single_sprite, $graphics_table, 0, 0, mt_rand(0, $graphics_cells_x - 1) * 8, mt_rand(0, $graphics_cells_y - 1), 8, 8);
				
				//Do we flip it?
				$flip_mode = mt_rand(0, 3);
				
				if ($flip_mode > 0)
					imageflip($single_sprite, $flip_mode);
				
				//Copy it to the actual table
				imagecopy($tile_table, $single_sprite, $x, $y, 0, 0, 8, 8);
			}
		}
	}
	
	//Get rid of the graphics table as we don't need it now
	imagedestroy($graphics_table);
	imagedestroy($single_sprite);
	
	//Write the RAM image for debugging
	//imagepng($tile_table, 'chrmap.png');
	
	//Create an image on which we'll load graphics data. We'll sample a random chunk of it
	$padding			= 64;		//MUST be multiple of 8
	$fin_img			= imagecreate(256+$padding, 256+$padding);
	$finimg_w			= imagesx($fin_img);
	$finimg_h			= imagesy($fin_img);
	$padding_tiles		= floor($padding / 8);
	$finimg_tiles_w		= floor($finimg_w / 8);
	$finimg_tiles_h		= floor($finimg_h / 8);
	
	//Draw the background color to our image
	$rand_pal			= $our_pal[array_rand($our_pal)];
	
	$bg_col_arr			= $rand_pal[mt_rand(0, count($rand_pal) - 2)];		//Last index is always transparency
	
	//Allocate the BG color (automatically draws it)
	imagecolorallocate($fin_img, $bg_col_arr['r'], $bg_col_arr['g'], $bg_col_arr['b']);
	
	//Convert this to a true color image from now on
	//imagepalettetotruecolor($fin_img);
	
	//Go through our color array and replace the RGBA values with the
	//palette index from imagecolorallocate
	foreach ($our_pal as $palkey => $palette)
	{
		foreach ($palette as $colkey => $color)
		{
			$our_pal[$palkey][$colkey]['palind'] = imagecolorallocate($fin_img, $color['r'], $color['g'], $color['b']);
		}
	}
	
	//Put a background on the image?
	if (mt_rand(0, 5) > 1)
	{
		
		//Get a palette
		$tile_pal			= $our_pal[mt_rand(0, count($our_pal) - 1)];
				
		$tile_id		= mt_rand(0, 511);
		
		//Figure out where in the table we sample the tile from
		$tile_sample_x		= $tile_id % 64;
		$tile_sample_y		= floor($tile_id / 64);
		
		for ($finimg_x = 0; $finimg_x < $finimg_tiles_w; $finimg_x++)
		{
			for ($finimg_y = 0; $finimg_y < $finimg_tiles_h; $finimg_y++)
			{
				//Draw the tile to the final image
				for ($tile_x = 0; $tile_x < 8; $tile_x++)
				{
					for ($tile_y = 0; $tile_y < 8; $tile_y++)
					{
						//Get the color index at this position (subtract 1 to it to account for the background color)
						$col_ind		= max(0, imagecolorat($tile_table, $tile_sample_x + $tile_x, $tile_sample_y + $tile_y));
						
						//Write the color to this position if it's not transparent
						if ($tile_pal[$col_ind]['a'] > 0)
						{
							imagesetpixel($fin_img, ($finimg_x * 8) + $tile_x, ($finimg_y * 8) + $tile_y, ($col_ind * 4) + $tile_pal[$col_ind]['palind']);
						}
					}
				}
			}
		}
	}
	
	//Get our level data
	$level_data			= load_nova_level();
	
	//What is the width and height of our level data?
	$level_width		= count($level_data[0]);
	$level_height		= count($level_data[0][0]);
	
	//Figure out our base offset (can be up to $padding_tiles tiles outside the boundary, will be filled with randomization
	
	if (mt_rand(0, 10) > 7)
	{
		$base_offset_x		= floor(mt_rand(-(128 / 8), $level_width));
		$base_offset_y		= floor(mt_rand(-(128 / 8), $level_height));
	}
	else
	{
		$base_offset_x		= mt_rand(0, $level_width - 16);
		$base_offset_y		= mt_rand(0, $level_height - 15);
	}
	
	$layer_curr			= 0;
	$layer_max			= count($level_data);
						
	//Go through data for each layer
	foreach ($level_data as $layer)
	{
		
		//Reset the offsets
		$offset_x			= $base_offset_x;
		$offset_y			= $base_offset_y;
	
		//Draw tiles to the image, assigning a random palette to each tile (draw them in 16x16 chunks)
		for ($finimg_x = 0; $finimg_x < $finimg_tiles_w; $finimg_x+=2)
		{
			for ($finimg_y = 0; $finimg_y < $finimg_tiles_h; $finimg_y+=2)
			{
				//Get a palette
				$tile_pal			= $our_pal[mt_rand(0, count($our_pal) - 1)];
				
				//Micro tile offset
				for ($microtile_x = 0; $microtile_x < 2; $microtile_x++)
				{
					for ($microtile_y = 0; $microtile_y < 2; $microtile_y++)
					{
						//Is this out of bounds? If so, get a random tile. If not, fetch a tile ID from the level data
						if ($offset_x + $microtile_x < 0 || $offset_x + $microtile_x >= $level_width - 1 || $offset_y + $microtile_y < 0 || $offset_y + $microtile_y >= $level_height - 1)
						{
							$tile_id		= mt_rand(0, 511);
						}
						else
						{
							$tile_id		= $layer[$offset_x + $microtile_x][$offset_y + $microtile_y];
						}
						
						//If the tile ID is 0, don't do anything
						if ($tile_id > 0)
						{
							
							//Figure out where in the table we sample the tile from
							$tile_sample_x		= $tile_id % 64;
							$tile_sample_y		= floor($tile_id / 64);
							
							//Draw the tile to the final image
							for ($tile_x = 0; $tile_x < 8; $tile_x++)
							{
								for ($tile_y = 0; $tile_y < 8; $tile_y++)
								{
									//Get the color index at this position (subtract 1 to it to account for the background color)
									$col_ind		= max(0, imagecolorat($tile_table, $tile_sample_x + $tile_x, $tile_sample_y + $tile_y));
									
									//Write the color to this position if it's not transparent
									if ($tile_pal[$col_ind]['a'] > 0)
									{
										imagesetpixel($fin_img, (($finimg_x + $microtile_x) * 8) + $tile_x, (($finimg_y + $microtile_y) * 8) + $tile_y, $tile_pal[$col_ind]['palind']);
									}
								}
							}
						}
					}
				}
				
				$offset_y++;
			}
			
			//Reset the Y offset, add to the X offset
			$offset_x	+=2;
			$offset_y	= $base_offset_y;
		}
		
		$layer_curr++;
		
		//If we're about to draw the sprite layer, possibly add a cool effect
		//to the composited background layer
		if ($layer_curr <= $layer_max - 1)
		{
			//figure out if we're gonna do cool effects or not
			$cooleffects = mt_rand(0, 5);
			switch ($cooleffects)
			{
				case 5:
				{
					//wave effect, like we're under water - can't be done on NES
					switch ($mode)
					{
						case 'SNES':
						case 'GB':
						{
							//create temporary buffer image to copy from
							$buffer = imagecreatetruecolor($finimg_w, $finimg_h);
			
							//copy image to buffer
							imagecopy($buffer, $fin_img, 0, 0, 0, 0, $finimg_w, $finimg_h);
							
							//determine how big to make the wave effect, the stronger it is the more distorted it is
							$sinestrength = mt_rand(1, 16);
							
							//the smaller the height, the less wavy it is
							$sineheight = mt_rand(0, 30);
							
							//copy image back to main image, line by line
							
							/*
								how this works:
								-	First, divide the sine strength by 2
								-	Next, we take $y and multiply it by 5 + the sine height
									This tells us how many degrees we're going to offer to the sine wave
								-	we then convert the degrees to radians, to pass to the sine
								-	the sine returns between -1 and 1, so we multiply by the strength and then round
							*/
							
							for ($y = 0; $y < $finimg_h; $y++)
							{
								$offset = round(($sinestrength/2) * sin(deg2rad($y * (5 + $sineheight))));
								imagecopyresized($fin_img, $buffer, $offset, $y, 0, $y, $finimg_w, 1, $finimg_h, 1);
							}
							
							//Delete the buffer
							imagedestroy($buffer);
							
							break;
						}
					}
				}
			}
		}
		
	}
	
	//Put random junk on the screen (for objects)
	for ($count = 0; $count < $rand_spr_count; $count++)
	{
		$obj_x			= mt_rand(0, $finimg_w);
		$obj_y			= mt_rand(0, $finimg_h);
		$obj_w			= mt_rand(1, $obj_max_size);
		$obj_h			= mt_rand(1, $obj_max_size);
		
		//Get a palette
		$tile_pal			= $our_pal[mt_rand(0, count($our_pal) - 1)];
		
		for ($finimg_x = $obj_x; $finimg_x < $obj_x + ($obj_w * 8); $finimg_x+=8)
		{
			for ($finimg_y = $obj_y; $finimg_y < $obj_y + ($obj_h * 8); $finimg_y+=8)
			{
				//Come up with a tile ID
				$tile_id		= mt_rand(0, 511);
				
				//Figure out where in the table we sample the tile from
				$tile_sample_x		= $tile_id % 64;
				$tile_sample_y		= floor($tile_id / 64);
						
				//Draw the tile to the final image
				for ($tile_x = 0; $tile_x < 8; $tile_x++)
				{
					for ($tile_y = 0; $tile_y < 8; $tile_y++)
					{
						//Get the color index at this position (subtract 1 to it to account for the background color)
						$col_ind		= max(0, imagecolorat($tile_table, $tile_sample_x + $tile_x, $tile_sample_y + $tile_y));
						
						//Write the color to this position if it's not transparent
						if ($tile_pal[$col_ind]['a'] > 0)
						{
							imagesetpixel($fin_img, $finimg_x + $tile_x, $finimg_y + $tile_y, ($col_ind * 4) + $tile_pal[$col_ind]['palind']);
						}
					}
				}
			}
		}
	}
	
	//Get rid of the tile table
	imagedestroy($tile_table);
	
	//Sample a bit of it
	$sample_x			= mt_rand(0, $finimg_w - $screen_w);
	$sample_y			= mt_rand(0, $finimg_h - $screen_h);
	
	$cropped_img		= imagecreatetruecolor($screen_w, $screen_h);
	
	imagecopy($cropped_img, $fin_img, 0, 0, $sample_x, $sample_y, $screen_w, $screen_h);
	
	//Get rid of the old image 
	imagedestroy($fin_img);
	
	//Upsize the image (not cropped yet, fix this later)
	$upsized_img		= imagecreatetruecolor($screen_w * $scale, $screen_h * $scale);
	$upsized_w			= imagesx($upsized_img);
	$upsized_h			= imagesy($upsized_img);
	
	imagecopyresized($upsized_img, $cropped_img, 0, 0, 0, 0, $upsized_w, $upsized_h, $screen_w, $screen_h);
	
	//Convert it to a palette based image
	imagetruecolortopalette($upsized_img, false, 255);
	
	//Get rid of the cropped image
	imagedestroy($cropped_img);
	
	//Output the file
	imagepng($upsized_img, $output_path);
	
	//Destroy all the images
	imagedestroy($upsized_img);
}

?>