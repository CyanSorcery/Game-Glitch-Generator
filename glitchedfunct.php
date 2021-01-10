<?php

	//Contains functions that return a palette to be used
	//by the glitch generator
	
	function get_nes_palette()
	{
		//Returns an array of palettes to use
		
		//All possible NES color values
		$nescol = Array();
		$nescol[] = '666666';
		$nescol[] = 'ADADAD';
		$nescol[] = 'FFFFFF';
		$nescol[] = '002A88';
		$nescol[] = '155FD9';
		$nescol[] = '64B0FF';
		$nescol[] = 'C0DFFF';
		$nescol[] = '1412A7';
		$nescol[] = '4240FF';
		$nescol[] = '9290FF';
		$nescol[] = 'D3D2FF';
		$nescol[] = '3B00A4';
		$nescol[] = '7527FE';
		$nescol[] = 'C676FF';
		$nescol[] = 'E8C8FF';
		$nescol[] = '5C007E';
		$nescol[] = 'A01ACC';
		$nescol[] = 'F26AFF';
		$nescol[] = 'FAC2FF';
		$nescol[] = '6E0040';
		$nescol[] = 'B71E7B';
		$nescol[] = 'FF6ECC';
		$nescol[] = 'FFC4EA';
		$nescol[] = '6C0700';
		$nescol[] = 'B53210';
		$nescol[] = 'FF8170';
		$nescol[] = '561D00';
		$nescol[] = '994E00';
		$nescol[] = 'EA9E22';
		$nescol[] = 'F7D8A5';
		$nescol[] = '333500';
		$nescol[] = '6B6D00';
		$nescol[] = 'BCBE00';
		$nescol[] = 'E4E594';
		$nescol[] = '0C4800';
		$nescol[] = '388700';
		$nescol[] = '88D800';
		$nescol[] = 'CFEF96';
		$nescol[] = '005200';
		$nescol[] = '0D9300';
		$nescol[] = '5CE430';
		$nescol[] = 'BDF4AB';
		$nescol[] = '004F08';
		$nescol[] = '008F32';
		$nescol[] = '34E082';
		$nescol[] = '3BF3CC';
		$nescol[] = '00404D';
		$nescol[] = '007C8D';
		$nescol[] = '48CDDE';
		$nescol[] = '000000';
		$nescol[] = '4F4F4F';
		$nescol[] = 'B8B8B8';
		
		//How many colors are in the color array
		//Subtract one as we're simply using this as a boundary
		//for the mt_rand function
		$nes_col_count		= count($nescol) - 1;
		
		//Used to have the RGBA of each palette
		$rgba				= Array('r', 'g', 'b', 'a');
		
		//Create a return palette
		
		$ret_pal			= Array();
		
		//NES can have 4 palettes that are 3 + a transparent color
		for ($pal = 0; $pal < 4; $pal++)
		{
			//Create an array for this entry
			$ret_pal[$pal]		= Array();
			
			//Sub palette index
			for ($subpal = 0; $subpal < 3; $subpal++)
			{
				//Fetch a hex string
				$hex_str			= $nescol[mt_rand(0, $nes_col_count)];
				
				//Go through the colors for this entry and store the RGBA values
				for ($col = 0; $col < 3; $col++)
				{
					$ret_pal[$pal][$subpal][$rgba[$col]] = round(base_convert(substr($hex_str, $col * 2, 2), 16, 10));
				}
				
				//Put the alpha
				$ret_pal[$pal][$subpal]['a']	= 127;
			}
			
			//Put the fourth one as transparency
			$ret_pal[$pal][3]['r'] = 0;
			$ret_pal[$pal][3]['g'] = 0;
			$ret_pal[$pal][3]['b'] = 0;
			$ret_pal[$pal][3]['a'] = 0;
		}
		
		//Return the palette
		return $ret_pal;
	}
	
	function get_snes_palette()
	{
		$snespal = Array();
		
		//Used to have the RGBA of each palette
		$rgba				= Array('r', 'g', 'b', 'a');
		
		for ($i = 0; $i < 2; $i ++)
		{
			$snespal[$i] = Array();
			
			//subpal index. SNES uses 15bit INTs with 5bits per color, for 32 possible values on each of the R G B
			//we multiply by 8 to get a range of 256, and then take one off if it's greater than 255
			//each palette can have 16 colors
			for ($j = 0; $j < 15; $j++)
			{
				//color for this index
				for ($k = 0; $k < 3; $k++)
				{
					$snestmpcol = mt_rand(0, 32) * 8;
					if ($snestmpcol >=256)
					{
						$snestmpcol = 255;
					}
					$snespal[$i][$j][$rgba[$k]] = $snestmpcol;
				}
				
				$snespal[$i][$j]['a'] = 127;
			}
			
			$snespal[$i][15] = Array('r' => 0, 'b' => 0, 'g' => 0, 'a' => 0);
		}
		
		return $snespal;
	}
	
	function get_gb_palette()
	{
				//Gameboy color palette
		//colors are stored in RRGGBB format, with 4 colors each, starting with the brightest color
		
		$palettegrid = Array();
		$palettegrid['GB'] = '9BBC0F7DA4003062300F380F';
		
		$palettegrid['SGB1'] = Array();
		$palettegrid['SGB1']['A'] = 'F8E8C8D89048A82820301850';
		$palettegrid['SGB1']['B'] = 'D8D8C0C8B070B05010000000';
		$palettegrid['SGB1']['C'] = 'F8C0F8E89850983860383898';
		$palettegrid['SGB1']['D'] = 'F8F8A8C08048F80000501800';
		$palettegrid['SGB1']['E'] = 'F8D8B078C078688840583820';
		$palettegrid['SGB1']['F'] = 'D8E8F8E08850A80000004010';
		$palettegrid['SGB1']['G'] = '00005000A0E8787800F8F858';
		$palettegrid['SGB1']['H'] = 'F8E8E0F8B888804000301800';
		
		$palettegrid['SGB2'] = Array();
		$palettegrid['SGB2']['A'] = 'F0C8A0C08848287800000000';
		$palettegrid['SGB2']['B'] = 'F8F8F8F8E850F83000500058';
		$palettegrid['SGB2']['C'] = 'F8C0F8E888887830E8282898';
		$palettegrid['SGB2']['D'] = 'F8F8A000F800F83000000050';
		$palettegrid['SGB2']['E'] = 'F8C88090B0E0281060100810';
		$palettegrid['SGB2']['F'] = 'D0F8F8F89050A00000180000';
		$palettegrid['SGB2']['G'] = '68B838E05040E0B880001800';
		$palettegrid['SGB2']['H'] = 'F8F8F8B8B8B8707070000000';
		
		$palettegrid['SGB3'] = Array();
		$palettegrid['SGB3']['A'] = 'F8D09870C0C0F86028304860';
		$palettegrid['SGB3']['B'] = 'D8D8C0E08020005000001010';
		$palettegrid['SGB3']['C'] = 'E0A8C8F8F87800B8F8202058';
		$palettegrid['SGB3']['D'] = 'F0F8B8E0A87808C800000000';
		$palettegrid['SGB3']['E'] = 'F8F8C0E0B068B07820504870';
		$palettegrid['SGB3']['F'] = '7878C8F868F8F8D000404040';
		$palettegrid['SGB3']['G'] = '60D850F8F8F8C83038380000';
		$palettegrid['SGB3']['H'] = 'E0F8A078C838488818081800';
		
		$palettegrid['SGB4'] = Array();
		$palettegrid['SGB4']['A'] = 'F0A86878A8F8D000D0000078';
		$palettegrid['SGB4']['B'] = 'F0E8F0E8A060407838180808';
		$palettegrid['SGB4']['C'] = 'F8E0E0D8A0D098A0E0080000';
		$palettegrid['SGB4']['D'] = 'F8F8B890C8C8486878082048';
		$palettegrid['SGB4']['E'] = 'F8D8A8E0A878785888002030';
		$palettegrid['SGB4']['F'] = 'B8D0D0D880D88000A0380000';
		$palettegrid['SGB4']['G'] = 'B0E018B82058381000281000';
		$palettegrid['SGB4']['H'] = 'F8F8C8B8C058808840405028';
		
		$palettegrid['GBC1'] = Array();
		$palettegrid['GBC1']['UP'] = 'FFFFFFFFAD63833100000000';
		$palettegrid['GBC1']['UPA'] = 'FFFFFFFF8584943A3A000000';
		$palettegrid['GBC1']['UPB'] = 'FFE7C5CC9C85846B29000000';
		
		$palettegrid['GBC2'] = Array();
		$palettegrid['GBC2']['LEFT'] = 'FFFFFF65A49B0000FE000000';
		$palettegrid['GBC2']['LEFTA'] = 'FFFFFF8B8CDE53528C000000';
		$palettegrid['GBC2']['LEFTB'] = 'FFFFFFA5A5A5525252000000';
		
		$palettegrid['GBC3'] = Array();
		$palettegrid['GBC3']['DOWN'] = 'FFFFA5FE94949394FE000000';
		$palettegrid['GBC3']['DOWNA'] = 'FFFFFFFFFF00FE0000000000';
		$palettegrid['GBC3']['DOWNB'] = 'FFFFFFFFFF007D4900000000';
	
		$palettegrid['GBC4'] = Array();
		$palettegrid['GBC4']['RIGHT'] = 'FFFFFF51FF00FF4200000000';
		$palettegrid['GBC4']['RIGHTA'] = 'FFFFFF7BFF300163C6000000';
		$palettegrid['GBC4']['RIGHTB'] = '000000008486FFDE00FFFFFF';
		
		$palettegrid['INVERT'] = Array();
		$palettegrid['INVERT']['0'] = 'F4E1E1D17676297E7F0A2020';
		$palettegrid['INVERT']['1'] = 'F4EBE2D1A37729537F0A1520';
		$palettegrid['INVERT']['2'] = 'F4F4E2D1D07729297F0A0A20';
		$palettegrid['INVERT']['3'] = 'EBF4E2A6D17753297F150A20';
		$palettegrid['INVERT']['4'] = 'E2F4E279D1777E297F200A20';
		$palettegrid['INVERT']['5'] = 'E2F4EB77D1A17F2956200A15';
		$palettegrid['INVERT']['6'] = 'E2F4F477D1CD7F292B200A0A';
		$palettegrid['INVERT']['7'] = 'E2EBF477A8D17F512920150A';
		$palettegrid['INVERT']['8'] = 'E2E2F4777CD17F7C2920200A';
		$palettegrid['INVERT']['9'] = 'EBE2F49F77D1587F2915200A';
		$palettegrid['INVERT']['A'] = 'F4E2F4CB77D12D7F290A200A';
		$palettegrid['INVERT']['B'] = 'F4E2EBD177AA297F4F0A2015';
		
		$palettegrid['RAINBOW'] = Array();
		$palettegrid['RAINBOW']['0'] = 'F4E1E1D176767F292B200A0A';
		$palettegrid['RAINBOW']['1'] = 'F4EBE2D1A3777F512920150A';
		$palettegrid['RAINBOW']['2'] = 'F4F4E2D1D0777F7C2920200A';
		$palettegrid['RAINBOW']['3'] = 'EBF4E2A6D177587F2915200A';
		$palettegrid['RAINBOW']['4'] = 'E2F4E279D1772D7F290A200A';
		$palettegrid['RAINBOW']['5'] = 'E2F4EB77D1A1297F4F0A2015';
		$palettegrid['RAINBOW']['6'] = 'E2F4F477D1CD297E7F0A2020';
		$palettegrid['RAINBOW']['7'] = 'E2EBF477A8D129537F0A1520';
		$palettegrid['RAINBOW']['8'] = 'E2E2F4777CD129297F0A0A20';
		$palettegrid['RAINBOW']['9'] = 'EBE2F49F77D153297F150A20';
		$palettegrid['RAINBOW']['A'] = 'F4E2F4CB77D17E297F200A20';
		$palettegrid['RAINBOW']['B'] = 'F4E2EBD177AA7F2956200A15';
		
		$pallete = '';
		
		$ret_arr = Array();
				
		//pick one of the palettes from above and generate a palette based on it
		$randkey = array_rand($palettegrid);
		if ($randkey != 'GB')
		{
			$randkey2 = array_rand($palettegrid[$randkey]);
			$palette = $palettegrid[$randkey][$randkey2];
		}
		else
		{
			$palette = $palettegrid[$randkey];
		}
		
		for ($colindex = 0; $colindex < 4; $colindex++)
		{
			for ($colpos = 0; $colpos < 3; $colpos++)
			{
				
				
				$tmpnum = round(base_convert(substr($palette, ($colindex)*6+($colpos*2), 2), 16, 10));
				
				switch ($colpos)
				{
					case 0:
					{
						$red = $tmpnum;
						break;
					}
					case 1:
					{
						$green = $tmpnum;
						break;
					}
					case 2:
					{
						$blue = $tmpnum;
						break;
					}
				}
			}
			
			$ret_arr[0][$colindex]['r']		= $red;
			$ret_arr[0][$colindex]['g']		= $green;
			$ret_arr[0][$colindex]['b']		= $blue;
			$ret_arr[0][$colindex]['a']		= 127;
		}
		
		return $ret_arr;
	}

	function load_nova_level()
	{
		//Loads a random level from Nova the Squirrel (1 or 2), converts it into an array
		//of tile indexes, and then returns that array
		
		//Pick a random file in the directory
		$files 				= scandir('nova_levels');
		
		$filepath			= '';
		
		while (strpos($filepath, '.json') === false)
		{
			$filepath			= $files[array_rand($files)];
		}
		
		//Open the level file
		$level_data			= json_decode(file_get_contents('nova_levels/' . $filepath), true);
		
		//How big are tiles for this level? (if tiles are 16x16, then this will be 2x2)
		$tile_w				= floor($level_data['Meta']['TileWidth'] / 8);
		$tile_h				= floor($level_data['Meta']['TileHeight'] / 8);
		
		//The total amount of 8x8 tiles to make a tile for this table
		$tile_total			= $tile_w + $tile_h;
		
		//Figure out how big the level data is supposed to be
		$level_w			= $level_data['Meta']['Width'];
		$level_h			= $level_data['Meta']['Height'];
		
		//Create array for the final level data
		$export_data		= Array();
		
		//Layers to ignore
		$ignore_layer_names	= Array('Control');
		
		//Decipher the code
		foreach ($level_data['Layers'] as $layer)
		{
			if (!in_array($layer['Name'], $ignore_layer_names))
			{
				//Reset the data array for this layer
				$layer_data		= Array();
				
				//Fill it with 0's
				for ($x = 0; $x < $level_w; $x++)
					for ($y = 0; $y < $level_h; $y++)
						$layer_data[$x][$y]		= 0;
					
				//Holds all strings for different element types (with blank entry for no tiles)
				$element_strings		= Array(0 => 'NULL');
				
				//Go through all the tile data and apply it to our layer data
				foreach ($layer['Data'] as $tile_data)
				{
					
					//If this element string isn't in our array, add it
					if (!in_array($tile_data['Id'], $element_strings))
						array_push($element_strings, $tile_data['Id']);
					
					//Get our tile ID, multiplied by however big the tiles are
					$tile_id		= array_search($tile_data['Id'], $element_strings) * $tile_total;
					
					//Put this tile data into the array
					//How this basically works is it composes a tile of the width above and then
					//composes it out of 8x8 tiles, and then repeats that across the entire
					//width and height of however big the element is
					for ($x = $tile_data['X']; $x < $tile_data['X'] + $tile_data['W']; $x+=$tile_w)
					{
						for ($y = $tile_data['Y']; $y < $tile_data['Y'] + $tile_data['H']; $y+=$tile_h)
						{
							//Reset the tile count
							$tile_count		= $tile_id;
							
							//Build this out of smaller tiles
							for ($micro_x = 0; $micro_x < $tile_w; $micro_x++)
							{
								for ($micro_y = 0; $micro_y < $tile_h; $micro_y++)
								{
									$layer_data[$x + $micro_x][$y + $micro_y] = $tile_count;
									$tile_count++;
								}
							}
						}
					}
				}
				
				//file_put_contents($layer['Name'] . '.json', json_encode($layer_data));
				
				//Push our layer data onto the export data array
				$export_data[count($export_data)] = $layer_data;
			}
		}
		
				
		//file_put_contents('data.json', json_encode($export_data));
				
		//Return the level data
		return $export_data;
	}
	
	
	function spriteTableOpt($sourcetable, $desttable, $trimbott = true, $tablecols = 32)
	{
		//get unoptimized sprite table
		$img = imagecreatefrompng($sourcetable);
		
		$w = imagesx($img);
		$h = imagesy($img);
		
		
		//create array of sprites
		$imgarr = Array();
		
		
		//traverse in chunks of 8
		for ($y = 0; $y < $h; $y += 8)
		{
			for ($x = 0; $x < $w; $x += 8)
			{
				//read 8x8 chunk into array
				$workstr = '';
				for ($spry = 0; $spry < 8; $spry++)
				{
					for ($sprx = 0; $sprx < 8; $sprx++)
					{
						$workstr .= imagecolorat($img, $x + $sprx, $y + $spry);
					}
				}
				
				//push index data onto the array
				$imgarr[] = $workstr;
			}
		}
		
		//make new array with no dupes
		$imgoptarr = array_keys(array_flip($imgarr));
		unset($imgarr);
		
		$arrpos = 0;
		$arrsize = count($imgoptarr);
		$strpos = 0;
		
		//create new image to hold the new sprites
		$optimg = imagecreate($tablecols * 8, ($trimbott === true ?  floor($arrsize / $tablecols) * 8 :  ceil($arrsize / $tablecols) * 8));
		$optw = imagesx($optimg);
		$opth = imagesy($optimg);
		
		//assign colors
		imagecolorallocate($optimg, 255, 255, 255);
		imagecolorallocate($optimg, 169, 169, 169);
		imagecolorallocate($optimg, 84, 84, 84);
		imagecolorallocate($optimg, 0, 0, 0);
		
		//draw new image
		for ($y = 0; $y < $opth; $y += 8)
		{
			for ($x = 0; $x < $optw; $x += 8)
			{
				//dont draw any more if we're out of array entries
				if ($arrpos < $arrsize)
				{
					for ($spry = 0; $spry < 8; $spry++)
					{
						for ($sprx = 0; $sprx < 8; $sprx++)
						{
							imagesetpixel($optimg, $x + $sprx, $y + $spry, substr($imgoptarr[$arrpos], $strpos, 1));
							$strpos++;
						}
					}
					$arrpos++;
					$strpos = 0;
				}
			}
		}
		
		
		
		
		//write the new image
		imagepng($optimg, $desttable);
		
		//clean up images
		imagedestroy($img);
		imagedestroy($optimg);
	}
?>