<?php
	/*
		NES/SNES/GB Glitched Image generator
		
		glitchedImgGen()
			Arguments:
				$spritetablepath		= Path to the sprite table we'll be using, SHOULD be 8x8 (if not maybe you'll get cool glitches)
				$outputpath				= Path we'll save the image to
				$upscalemult			= OPTIONAL How much we'll upscale the image (defaults to 3)
				$gphxmode				= OPTIONAL Graphics mode we'll use, or it just picks one
				$alphaborder			= Put a transparent border around it (useful for Twitter, defaults to True
			Returns:
				nothing
	*/
	
	function glitchedImgGen($spritetablepath, $outputpath, $upscalemult = 3, $gphxmode = 'DEFAULT', $alphaborder = true)
	{
		//mode switch
		$modes = Array('NES', 'SNES', 'GB');
		
		//check if the graphics mode is in our supported modes and if not just pick one
		if (in_array($gphxmode, $modes))
		{
			$mode = $gphxmode;
		}
		else
		{
			$mode = $modes[mt_rand(0,2)];
		}
		
		//store NES color palette, stored in RGB hex (later converted to 0-255, for PHP color args)
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
		
		//rgb used to have r g b for each array, hex stores the hex code picked that time
		$rgb = Array('r','g','b');
		$hex = '';
		
		switch ($mode)
		{
			case 'NES':
			{
				//figure out our NES Palette count for the image
				$nescolsize = count($nescol) - 1;
				
				//palette index, NES can have 4
				$nespal = Array();
				for ($i = 0; $i < 4; $i ++)
				{
					$nespal[$i] = Array();
					
					//subpal index (each one can have 3 colors + BG)
					for ($j = 0; $j < 3; $j++)
					{
						$hex = $nescol[mt_rand(0, $nescolsize)];
						//color for this index
						for ($k = 0; $k < 3; $k++)
						{
							$nespal[$i][$j][$rgb[$k]] = round(base_convert(substr($hex, $k * 2, 2), 16, 10));
						}
					}
				}
				$nesbgcol = Array();
				
				$hex = $nescol[mt_rand(0, $nescolsize)];
				
				for ($j = 0; $j < 3; $j++)
				{
					$nesbgcol[$rgb[$j]] = round(base_convert(substr($hex, $j * 2, 2), 16, 10));
				}
				
				//create initial image
				//NES resolution is 256x240, we create an image that's 16x16 bigger so that we can scroll it a bit
				$img = imagecreate(256+16, 240+16);
				$imgw = imagesx($img);
				$imgh = imagesy($img);
				
				//allocate the background color FIRST, automatically fills the image with this color
				//it is an indexed image so dont have to worry about storing the color identifier, as we know it already
				imagecolorallocate($img, $nesbgcol['r'], $nesbgcol['g'], $nesbgcol['b']);
				
				//allocate each color
				for ($i = 0; $i < 4; $i++)
				{
					for ($j = 0; $j < 3; $j++)
					{
						imagecolorallocate($img, $nespal[$i][$j]['r'], $nespal[$i][$j]['g'], $nespal[$i][$j]['b']);
					}
				}
				
				break;
			}
			case 'SNES':
			{
				//palette index. Using MODE 1 of the SNES with 2 BGs of 16 colors and 1BG of 4 colors (only using the 2BGs in this case)
				$snespal = Array();
				for ($i = 0; $i < 2; $i ++)
				{
					$snespal[$i] = Array();
					
					//subpal index. SNES uses 15bit INTs with 5bits per color, for 32 possible values on each of the R G B
					//we multiply by 8 to get a range of 256, and then take one off if it's greater than 255
					//each palette can have 16 colors
					for ($j = 0; $j < 16; $j++)
					{
						//color for this index
						for ($k = 0; $k < 3; $k++)
						{
							$snestmpcol = mt_rand(0, 32) * 8;
							if ($snestmpcol >=256)
							{
								$snestmpcol = 255;
							}
							$snespal[$i][$j][$rgb[$k]] = $snestmpcol;
						}
					}
				}
				$snesbgcol = Array();
				for ($j = 0; $j < 3; $j++)
				{
					$snesbgcol[$rgb[$j]] = mt_rand(0, 255);
				}
				
				//create initial image
				//SNES resolution is also 256x240, we create an image that's 16x16 bigger so that we can scroll it a bit
				$img = imagecreate(256+16, 240+16);
				$imgw = imagesx($img);
				$imgh = imagesy($img);
				
				//allocate each color
				for ($i = 0; $i < 2; $i++)
				{
					for ($j = 0; $j < 16; $j++)
					{
						imagecolorallocate($img, $snespal[$i][$j]['r'], $snespal[$i][$j]['g'], $snespal[$i][$j]['b']);
					}
				}
				break;
			}
			case 'GB':
			{
				//create initial image
				//SNES resolution is also 256x240, we create an image that's 16x16 bigger so that we can scroll it a bit
				$img = imagecreate(160+16, 144+16);
				$imgw = imagesx($img);
				$imgh = imagesy($img);
				
				$pallete = '';
				
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
				
				for ($colindex = 1; $colindex < 5; $colindex++)
				{
					for ($colpos = 0; $colpos < 3; $colpos++)
					{
						
						
						$tmpnum = round(base_convert(substr($palette, ($colindex-1)*6+($colpos*2), 2), 16, 10));
						
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
					
					
					imagecolorallocate($img, $red, $green, $blue);
				}
				
				
				
				break;
			}
		}
		
		
		
		
		//get our sprite table
		$spritetable = imagecreatefrompng($spritetablepath);
		$sprw = imagesx($spritetable);
		$sprh = imagesy($spritetable);
		//the amount of sprites rows and columns
		$sprrows = ceil($sprh / 8);
		$sprcols = ceil($sprw / 8);
		
		//current sprite that we'll work with on each draw
		$sprite = imagecreate(8, 8);
		
		//copy palette from the sprite table to the sprite for ease
		imagepalettecopy($sprite, $spritetable);
		
		//flip modes, offset by 1 for ease of use by the script later
		$flipmodes = Array(
						1 => IMG_FLIP_HORIZONTAL,
						2 => IMG_FLIP_VERTICAL,
						3 => IMG_FLIP_BOTH
						);
		
		
		//begin the obtuse process of drawing the image
		//draw it in 16 by 16 chunks, assigning one of the palettes to each
		for ($imgy = 0; $imgy < $imgh; $imgy+=16)
		{
			for ($imgx = 0; $imgx < $imgw; $imgx+=16)
			{
				//for this chunk, figure out 4 sprites to draw to it
				
				//what palette will we use
				switch ($mode)
				{
					case 'NES':
					{
						//NES has 4 palettes we can use
						$ourpal = mt_rand(0, 3);
						break;
					}
					case 'SNES':
					{
						//SNES background has only two palettes one for each
						$ourpal = mt_rand(0, 1);
						break;
					}
					case 'GB':
					{
						//Gameboy only has one palette
						$ourpal = 0;
						break;
					}
				}
				
				
				//chance for it to be offset
				$chance = mt_rand(4, 9);
				
				for ($drawx = 0; $drawx < 16; $drawx+=8)
				{
					for ($drawy = 0; $drawy < 16; $drawy+=8)
					{
						//fetch a sprite
						imagecopy(
								/* dest image */				$sprite,
								/* source (sprite table) */		$spritetable,
								/* destination x and y */		0, 0,
								/* source x */					mt_rand(0, $sprcols) * 8 + ($chance == 9 ? mt_rand(0, 7) : 0),
								/* source y */					mt_rand(0, $sprrows) * 8 + ($chance == 9 ? mt_rand(0, 7) : 0),
								/* size */						8, 8);
						
						//will we flip it?
						$toflip = mt_rand(0, 3);
						if ($toflip > 0)
						{
							imageflip($sprite, $flipmodes[$toflip]);
						}
						
						//rotate it (maybe) third argument is the background color which is index 0
						imagerotate($sprite, mt_rand(0, 3) * 90, 0);
						
						//convert image back to palette based since these functions change it
						//this will mess up the indexes but that's ok
						imagetruecolortopalette($sprite, false, 4);
						imagepalettecopy($sprite, $spritetable);
						
						//figure out which palette entries we're gonna be drawing
						//we do this by creating an array, shuffling it, and then popping off one entry
						switch ($mode)
						{
							case 'NES':
							{
								//array representing which palette to use
								$todraw = Array(0, 1, 2, 3);
								//figure out the transparent color
								shuffle($todraw);
								array_pop($todraw);
								break;
							}
							case 'SNES':
							{
								//offset for this sprite
								$offset = mt_rand(0, 12);
								break;
							}
							case 'GB':
							{
								//array representing which palette to use
								$todraw = Array(0, 1, 2, 3);
								break;
							}
						}
						
						//give it a 1 in 10 chance of being just garbled 
						$chance = mt_rand(0, 9);
				
						//now that we've messed with it, draw it
						for ($sprdrawy = 0; $sprdrawy < 8; $sprdrawy++)
						{
							for ($sprdrawx = 0; $sprdrawx < 8; $sprdrawx++)
							{
								//get the index
								if ($chance == 9)
								{
									$colind = mt_rand(0,3);
								}
								else
								{
									$colind = imagecolorat($sprite, $sprdrawx, $sprdrawy);
								}
								
								//draw it onto the image
								switch ($mode)
								{
									case 'NES':
									{
										//check if we're drawing this index
										if (in_array($colind, $todraw))
										{
											imagesetpixel(
												/* dest image */			$img,
												/* x coord */				$imgx + $drawx + $sprdrawx,
												/* y coord */				$imgy + $drawy + $sprdrawy,
												/* color palette index */	1 + ($ourpal * 3) + array_search($colind, $todraw)
												/* relative to dest pal*/
												);
										}
										break;
									}
									case 'SNES':
									{
										imagesetpixel(
											/* dest image */			$img,
											/* x coord */				$imgx + $drawx + $sprdrawx,
											/* y coord */				$imgy + $drawy + $sprdrawy,
											/* color palette index */	($ourpal * 16) + ($colind + $offset)
											/* relative to dest pal*/
											);
										break;
									}
									case 'GB':
									{
										imagesetpixel(
											/* dest image */			$img,
											/* x coord */				$imgx + $drawx + $sprdrawx,
											/* y coord */				$imgy + $drawy + $sprdrawy,
											/* color palette index */	$colind
											/* relative to dest pal*/
											);
									}
								}
								
							
								
							}
						}
					}
				}
			}
		}
		
		//which way are we gonna scroll and by how much
		switch ($mode)
		{
			case 'NES':
			case 'GB':
			{
				$scroll = mt_rand(0, 16);
				$scrolldir = mt_rand(0, 1);
				$x = 0;
				$y = 0;
				
				if ($scrolldir == 1)
				{
					//horizontal scroll
					$x = $scroll;
					$y = mt_rand(0, 2) * 8;
				}
				else
				{
					
					//vertical scroll
					$x = mt_rand(0, 2) * 8;
					$y = $scroll;
				}
				
				
				
				break;
			}
			case 'SNES':
			{
				//snes can scroll any direction so dont worry about it
				$x = mt_rand(0, 16);
				$y = mt_rand(0, 16);
			}
		}
		
		
		$cropped = imagecrop($img, Array(
											'x' => $x, 
											'y' => $y, 
											'width' => $imgw - 16, 
											'height' => $imgh - 16
										)
									);
		
		//do math on size if we're to create an alpha border or not
		if ($alphaborder === true)
		{
			$upsizedw = ($imgw-16) * $upscalemult+2;
			$upsizedh = ($imgh-16) * $upscalemult+2;
			//top left offset
			$bordoffset = 1;
			//bottom right offset
			$shrinksize = 2;
		}
		else
		{
			$upsizedw = ($imgw-16) * $upscalemult;
			$upsizedh = ($imgh-16) * $upscalemult;
			$bordoffset = 0;
			$shrinksize = 0;
		}
		
		//create new image to hold upscaled image
		$upsized = imagecreate($upsizedw, $upsizedh);
		imagepalettecopy($upsized, $img);
		
		if ($alphaborder === true)
		{
			//put a transparent border around it 
			$transcol = imagecolorallocatealpha($upsized, 255, 0, 255, 127);
			
			//use image set pixel instead of drawing a rectangle to guarantee transparency
			imagerectangle($upsized, 0, 0, $upsizedw-1, $upsizedh-1, $transcol);
		}
		
		//copy image to upsize it
		imagecopyresized(
					/* source */				$upsized,
					/* dest */					$cropped,
					/* dest coords */			$bordoffset, $bordoffset,
					/* source coords */			0, 0,
					/* dest widthheight */		$upsizedw - $shrinksize, $upsizedh - $shrinksize,
					/* source widthheight */	$imgw - 16, $imgh - 16
						);
		
		//imagepng($upsized, './tmp/glitched.png');
		imagepng($upsized, $outputpath);
		
		imagedestroy($img);
		imagedestroy($spritetable);
		imagedestroy($sprite);
		imagedestroy($cropped);
	}
	
	/*
		Sprite Table Optimizer
		Optimizes the sprite table and removes duplicate entries
		
		spriteTableOpt()
			Arguments:
				$sourcetable			= Path to the sprite table we'll be optimizing (MUST be 8x8 4 color, see included example)
				$desttable				= Where we'll save the optimized table to
				$trimbott				= OPTIONAL trims the last row as it may be full of blank tiles except a couple filled out ones
				$tablecols				= OPTIONAL specifies how many columns the optimized sprite table will have
			Returns:
				nothing
	*/
	
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