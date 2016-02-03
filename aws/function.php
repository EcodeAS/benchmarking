<?php
function smart_resize_image($file, $width = 0, $height = 0, $proportional = false, $output, $quality = 75, $format = 'png', $canvas = false) {
	$info = getimagesize($file);
	
	$image = '';
	$final_width = 0;
	$final_height = 0;
	list($width_old, $height_old) = $info;
	
	if ($proportional) {
		if ($width == 0)
			$factor = $height / $height_old;
		elseif ($height == 0)
			$factor = $width / $width_old;
		else
			$factor = min($width / $width_old, $height / $height_old);

		$final_width = round($width_old * $factor);
		$final_height = round($height_old * $factor);
	}
	else {
		$final_width = ($width <= 0) ? $width_old : $width;
		$final_height = ($height <= 0) ? $height_old : $height;
	}
	
	if ($canvas){
		if ($final_width >= $final_height){
			$canvas_width = $final_width;
			$canvas_height = $final_width;
		}
		else {
			$canvas_width = $final_height;
			$canvas_height = $final_height;
		}
	}
	
	switch ( $info[2] ) {
		case IMAGETYPE_GIF :
			$image = imagecreatefromgif($file);
			break;
		case IMAGETYPE_JPEG :
			$image = imagecreatefromjpeg($file);
			break;
		case IMAGETYPE_PNG :
			$image = imagecreatefrompng($file);
			break;
		default :
			return false;
	}
	
	if ($canvas){
		$image_resized = imagecreatetruecolor($canvas_width, $canvas_height);
	}
	else {
		$image_resized = imagecreatetruecolor($final_width, $final_height);
	}

	if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
		$trnprt_indx = imagecolortransparent($image);
		
		if ($trnprt_indx >= 0) {
			$trnprt_color = imagecolorsforindex($image, $trnprt_indx);
			$trnprt_indx = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
			imagefill($image_resized, 0, 0, $trnprt_indx);
			imagecolortransparent($image_resized, $trnprt_indx);
		}
		elseif ($info[2] == IMAGETYPE_PNG) {
			if ($format == 'jpg'){
				$color = imagecolorallocate($image_resized, 255, 255, 255);
				imagefill($image_resized, 0, 0, $color);
			}
			elseif ($format == 'png'){
				imagealphablending($image_resized, false);
				$color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
				imagefill($image_resized, 0, 0, $color);
				imagesavealpha($image_resized, true);
			}
		}
	}
	else {
		$backgroundColor = imagecolorallocate($image_resized, 255, 255, 255);
		imagefill($image_resized, 0, 0, $backgroundColor);
	}
	
	
	
	if ($canvas){
		imagecopyresampled($image_resized, $image, ceil(($canvas_width-$final_width)/2), ceil(($canvas_height-$final_height)/2), 0, 0, $final_width, $final_height, $width_old, $height_old);
	}
	else {
		imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
	}
	
	
	
	if ($output != '' || !isset($output)){
		if ($format == 'jpg'){
			imagejpeg($image_resized, $output, $quality);
		}
		elseif ($format == 'png'){
			imagepng($image_resized, $output);
		}
		
		imagedestroy($image);
		ImageDestroy($image_resized);
		return true;
	}
	else {
		if ($format == 'jpg'){
		    ob_start();
			imagejpeg($image_resized, null, $quality);
		    $final_image = ob_get_contents();
			imagedestroy($image);
			ImageDestroy($image_resized);
		    ob_end_clean();
		}
		elseif ($format == 'png'){
		    ob_start();
			imagepng($image_resized);
		    $final_image = ob_get_contents();
			imagedestroy($image);
			ImageDestroy($image_resized);
		    ob_end_clean();
		}
		
		return $final_image;
	}
	
	//return true;
}
?>