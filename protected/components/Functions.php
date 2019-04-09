<?php
/*
 * Creating function that will be usefull for future using
 */
class Functions {
    
	public static function shortDescription($fullDescription) {
		$shortDescription = '';

		$fullDescription = trim(strip_tags($fullDescription));

		if ($fullDescription) {
			$initialCount = 125;
			if (strlen($fullDescription) > $initialCount) {
				//$shortDescription = substr(strip_tags($fullDescription),0,$initialCount).”…”;
				$shortDescription = substr($fullDescription,0,$initialCount)."…";
			}
			else {
				return $fullDescription;
			}
		}

		return $shortDescription;
	}//End of function shortDescription
	
	public static function colorPalette($imageFile, $numColors, $granularity = 5) 
{ 
   $granularity = max(1, abs((int)$granularity)); 
   $colors = array(); 
   $size = @getimagesize($imageFile); 
   if($size === false) 
   { 
      user_error("Unable to get image size data: ".$imageFile); 
      return false; 
   } 
   
   //$img = @imagecreatefromjpeg($imageFile);
   // Andres mentioned in the comments the above line only loads jpegs, 
   // and suggests that to load any file type you can use this:
    $img = @imagecreatefromstring(file_get_contents($imageFile)); 

   if(!$img) 
   { 
      user_error("Unable to open image file: ".$imageFile); 
      return false; 
   } 
   for($x = 0; $x < $size[0]; $x += $granularity) 
   { 
      for($y = 0; $y < $size[1]; $y += $granularity) 
      { 
         $thisColor = imagecolorat($img, $x, $y); 
         $rgb = imagecolorsforindex($img, $thisColor); 
         $red = round(round(($rgb['red'] / 0x33)) * 0x33); 
         $green = round(round(($rgb['green'] / 0x33)) * 0x33); 
         $blue = round(round(($rgb['blue'] / 0x33)) * 0x33); 
         $thisRGB = sprintf('%02X%02X%02X', $red, $green, $blue); 
         if(array_key_exists($thisRGB, $colors)) 
         { 
            $colors[$thisRGB]++; 
         } 
         else 
         { 
            $colors[$thisRGB] = 1; 
         } 
      } 
   } 
   arsort($colors); 
   return array_slice(array_keys($colors), 0, $numColors); 

	}//End of function colorPallete
	
	
	public static function get_avg_luminance($filename, $num_samples=10) {
        $img = imagecreatefromstring(file_get_contents($filename));
        $width = imagesx($img);
        $height = imagesy($img);

        $x_step = intval($width/$num_samples);
        $y_step = intval($height/$num_samples);

        $total_lum = 0;

        $sample_no = 1;

        for ($x=0; $x<$width; $x+=$x_step) {
            for ($y=0; $y<$height; $y+=$y_step) {

                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                // choose a simple luminance formula from here
                // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
                $lum = ($r+$r+$b+$g+$g+$g)/6;

                $total_lum += $lum;

                // debugging code
     //           echo "$sample_no - XY: $x,$y = $r, $g, $b = $lum<br />";
                $sample_no++;
            }
        }

        // work out the average
        $avg_lum  = $total_lum/$sample_no;

        return $avg_lum;
    }
	
 
}