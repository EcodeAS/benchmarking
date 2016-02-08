<?php
	ini_set('display_errors', 1);
	
	require 'vendor/autoload.php'; //Require AWS PHP SDK
	require_once 'functions.php';
	use Aws\S3\S3Client;
	
	$s3 = new S3Client(array(
		'version' => 'latest',
		'region' => 'eu-west-1',
		'credentials' => array(
			'key' => [YOUR-AWS-S3-KEY],
			'secret' => [YOUR-AWS-S3-SECRET]
		)
	));
	
	$accountUrl = [YOUR-AWS-S3-ENDPOINT]; //Example 'https://s3-eu-west-1.amazonaws.com'
	$accountCode = [YOUR-AWS-S3-BUCKET];
	
	$s3->registerStreamWrapper();
	
	$s3_context_read = stream_context_create(array(
		's3' => array(
			'ACL' => 'public-read'
		)
	));
	
	
	
	for ($i = 1; $i <= 1; $i++) {
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		
		//Delete all blob container before start
		//Commented for your safety...
		/*
			$dir = 's3://'.$accountCode.'/';
			$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
			
			foreach ($iterator as $file_path => $file_data) {
				try {
					unlink($file_path);
				}
				catch (Exception $error) {
					echo '<pre>';
					print_r($error);
					echo '</pre>';
				}
			}
		*/
		
		//Output page render time
			$time = microtime();
			$time = explode(' ', $time);
			$time = $time[1] + $time[0];
			$finish = $time;
			$total_time = round(($finish - $start), 4);
			echo '<br><br>Deleted all files in:<br><h1 style="line-height: 1;">'.$total_time.' seconds</h1>';
		
		
		
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		
		
		//Web image files looped while reading binary data, then copied to blob storage, then read again by image cruncher, then store the returned image binary to blob storage.
			$filesArray = array(
				[FIRST IMAGE HOSTED ONLINE],
				[SECOND IMAGE HOSTED ONLINE],
				[ETC...]
			);
			
			$counter = 0;
			
			foreach($filesArray as $imagefile_input) {
				$counter++;
				
				echo '<div style="background: #eee; margin: 30px; padding: 30px;">';
					$time_level_1 = microtime();
					$time_level_1 = explode(' ', $time_level_1);
					$time_level_1 = $time_level_1[1] + $time_level_1[0];
					$time_level_1_start = $time_level_1;
					
						
						
						$time_level_5 = microtime();
						$time_level_5 = explode(' ', $time_level_5);
						$time_level_5 = $time_level_5[1] + $time_level_5[0];
						$time_level_5_start = $time_level_5;
						
						$image_content = file_get_contents($imagefile_input.'?cachebuster='.time());
						$imagefile_output = 'webfiles/'.$counter.'.png';
						
						$time_level_5 = microtime();
						$time_level_5 = explode(' ', $time_level_5);
						$time_level_5 = $time_level_5[1] + $time_level_5[0];
						$time_level_5_finish = $time_level_5;
						$time_level_5_total = round(($time_level_5_finish - $time_level_5_start), 4);
						echo '<br><strong>Read image from web and stored binary into memory<br>'.$time_level_5_total.' seconds.</strong><br><hr><br>';
						
						//Upload image from local memory to s3 storage
						echo 'Upload to s3 storage: '.$imagefile_input.'...<br>';
						
						$time_level_4 = microtime();
						$time_level_4 = explode(' ', $time_level_4);
						$time_level_4 = $time_level_4[1] + $time_level_4[0];
						$time_level_4_start = $time_level_4;
						
						if (file_put_contents('s3://'.$accountCode.'/'.$imagefile_output, $image_content, 0, $s3_context_read)){
							echo '<a target="blank" href="'.$accountUrl.'/'.$accountCode.'/'.$imagefile_output.'?cachebuster='.time().'">'.$accountUrl.'/'.$accountCode.'/'.$imagefile_output.'</a><br><br>';
						}
						else {
							echo 'Failed to upload imaget to s3.<br>';
						}
						
						$time_level_4 = microtime();
						$time_level_4 = explode(' ', $time_level_4);
						$time_level_4 = $time_level_4[1] + $time_level_4[0];
						$time_level_4_finish = $time_level_4;
						$time_level_4_total = round(($time_level_4_finish - $time_level_4_start), 4);
						
						echo '<br><strong>Uploaded image from memory to s3 storage<br>'.$time_level_4_total.' seconds.</strong><br><hr><br>';
						echo 'Done!<br>';
						
						//Resize image
						echo 'Starting image rescaling...<br>';
						$time_level_3 = microtime();
						$time_level_3 = explode(' ', $time_level_3);
						$time_level_3 = $time_level_3[1] + $time_level_3[0];
						$time_level_3_start = $time_level_3;
						
						$image_content_resized = smart_resize_image($imagefile_input.'?cachebuster='.time(), 200, 200, true, '', 1);
						
						$time_level_3 = microtime();
						$time_level_3 = explode(' ', $time_level_3);
						$time_level_3 = $time_level_3[1] + $time_level_3[0];
						$time_level_3_finish = $time_level_3;
						$time_level_3_total = round(($time_level_3_finish - $time_level_3_start), 4);
						echo '<br><strong>Resize image<br>'.$time_level_3_total.' seconds.</strong><br><hr><br>';
						
						//Upload resized image from memory to blob storage
						if ($image_content_resized != ''){
							$time_level_2 = microtime();
							$time_level_2 = explode(' ', $time_level_2);
							$time_level_2 = $time_level_2[1] + $time_level_2[0];
							$time_level_2_start = $time_level_2;
							
							if (file_put_contents('s3://'.$accountCode.'/resized_'.$imagefile_output, $image_content_resized, 0, $s3_context_read)){
								echo 'Done!<br>';
								echo '<a target="blank" href="'.$accountUrl.'/'.$accountCode.'/resized_'.$imagefile_output.'?cachebuster='.time().'">'.$accountUrl.'/'.$accountCode.'/resized_'.$imagefile_output.'</a><br><br>';
								echo '<img src="'.$accountUrl.'/'.$accountCode.'/resized_'.$imagefile_output.'?cachebuster='.time().'"><br><br>';
							}
							else {
								echo 'Failed to upload resized s3 image.<br>';
							}
							
							$time_level_2 = microtime();
							$time_level_2 = explode(' ', $time_level_2);
							$time_level_2 = $time_level_2[1] + $time_level_2[0];
							$time_level_2_finish = $time_level_2;
							$time_level_2_total = round(($time_level_2_finish - $time_level_2_start), 4);
							echo '<br><strong>Upload resized image from memory to s3 storage<br>'.$time_level_2_total.' seconds.</strong><br><hr><br>';
						}
					
					$time_level_1 = microtime();
					$time_level_1 = explode(' ', $time_level_1);
					$time_level_1 = $time_level_1[1] + $time_level_1[0];
					$time_level_1_finish = $time_level_1;
					$time_level_1_total = round(($time_level_1_finish - $time_level_1_start), 4);
					echo '<br><strong>Total image jobs<br><h3>'.$time_level_1_total.' seconds</h3></strong><br>';
					
				echo '</div>';
			}
			
		
		//Output page render time
			$time = microtime();
			$time = explode(' ', $time);
			$time = $time[1] + $time[0];
			$finish = $time;
			$total_time = round(($finish - $start), 4);
			echo '<br><br>Total page generated in:<br><h1 style="line-height: 1;">'.$total_time.' seconds</h1>';
		
		
		
		echo '<br><br><br><br><hr><br><br><br><br>';
	}
?>
