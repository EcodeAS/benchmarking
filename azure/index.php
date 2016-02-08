<?php
	ini_set('display_errors', 1);
	
	require_once 'vendor/autoload.php'; //Require Azure PHP SDK
	require_once 'functions.php';
	
	$accountName 	= [YOUR-BLOB-STORAGE-ACCOUNT];
	$accountKey 	= [YOUR-BLOB-STORAGE-KEY];
	$accountUrl 	= [YOUR-BLOB-STORAGE-ENDPOINT]; //example 'https://[YOUR-BLOB-STORAGE-ACCOUNT].blob.core.windows.net'
	$accountCode 	= [YOUR-BLOB-STORAGE-CONTAINER];
	
	use WindowsAzure\Common\ServicesBuilder;
	use WindowsAzure\Common\ServiceException;
	use WindowsAzure\Blob\Models\CreateContainerOptions;
	use WindowsAzure\Blob\Models\PublicAccessType;
	use WindowsAzure\Blob\Models\ListBlobsOptions;
	
	$connectionString = 'DefaultEndpointsProtocol=https;AccountName='.$accountName.';AccountKey='.$accountKey;
	$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
	
	for ($i = 1; $i <= 1; $i++) {
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		
		//Delete all blob container before start
		//Commented for your safety...
		/*
			$prefix = '';
			$blobListOptions = new ListBlobsOptions();
			$blobListOptions->setPrefix($prefix);
			$blob_list = $blobRestProxy->listBlobs($accountCode, $blobListOptions);
			$productionFiles = $blob_list->getBlobs();
			
			foreach($productionFiles as $productionFile) {
				try {
					$blobRestProxy->deleteBlob($accountCode, $productionFile->getName() );
				}
				catch (ServiceException $error){
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
						//$image_content = fopen($imagefile_input, 'r');
						$imagefile_output = 'webfiles/'.$counter.'.png';
						
						$time_level_5 = microtime();
						$time_level_5 = explode(' ', $time_level_5);
						$time_level_5 = $time_level_5[1] + $time_level_5[0];
						$time_level_5_finish = $time_level_5;
						$time_level_5_total = round(($time_level_5_finish - $time_level_5_start), 4);
						echo '<br><strong>Read image from web and stored binary into memory<br>'.$time_level_5_total.' seconds.</strong><br><hr><br>';
						
						//Upload image from local memory to blob storage
						echo 'Upload to blob storage: '.$imagefile_input.'...<br>';
						
						try {
							$time_level_4 = microtime();
							$time_level_4 = explode(' ', $time_level_4);
							$time_level_4 = $time_level_4[1] + $time_level_4[0];
							$time_level_4_start = $time_level_4;
							
							try {
								$blobRestProxy->createBlockBlob($accountCode, $imagefile_output, $image_content);
								echo '<a target="blank" href="'.$accountUrl.'/'.$accountCode.'/'.$imagefile_output.'">'.$accountUrl.'/'.$accountCode.'/'.$imagefile_output.'</a><br><br>';
							}
							catch (ServiceException $error){
								echo '<pre>';
								print_r($error);
								echo '</pre>';
							}
							
							$time_level_4 = microtime();
							$time_level_4 = explode(' ', $time_level_4);
							$time_level_4 = $time_level_4[1] + $time_level_4[0];
							$time_level_4_finish = $time_level_4;
							$time_level_4_total = round(($time_level_4_finish - $time_level_4_start), 4);
							
							echo '<br><strong>Uploaded image from memory to blob storage<br>'.$time_level_4_total.' seconds.</strong><br><hr><br>';
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
								
								try {
									$blobRestProxy->createBlockBlob($accountCode, 'resized_'.$imagefile_output, $image_content_resized); 
									echo 'Done!<br>';
									echo '<a target="blank" href="'.$accountUrl.'/'.$accountCode.'/resized_'.$imagefile_output.'">'.$accountUrl.'/'.$accountCode.'/resized_'.$imagefile_output.'</a><br><br>';
									echo '<img src="'.$accountUrl.'/'.$accountCode.'/resized_'.$imagefile_output.'?cachebuster='.time().'"><br><br>';
								}
								catch (ServiceException $error){
									echo '<pre>';
									print_r($error);
									echo '</pre>';
								}
								
								$time_level_2 = microtime();
								$time_level_2 = explode(' ', $time_level_2);
								$time_level_2 = $time_level_2[1] + $time_level_2[0];
								$time_level_2_finish = $time_level_2;
								$time_level_2_total = round(($time_level_2_finish - $time_level_2_start), 4);
								echo '<br><strong>Upload resized image from memory to blob storage<br>'.$time_level_2_total.' seconds.</strong><br><hr><br>';
								
							}
						}
						catch (ServiceException $error){
							$somethingWentWrong = true;
							echo '<pre>';
							print_r($error);
							echo '</pre>';
						}
						
						//fclose($image_content);
						
					
					
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
	
	
	
	
	
	
	//Blob storage API snippets for convenience
	
	//List 
	/*
	$prefix = 'files/';
	$blobListOptions = new ListBlobsOptions();
	$blobListOptions->setPrefix($prefix);
	$blob_list = $blobRestProxy->listBlobs($accountCode, $blobListOptions);
	$blobs = $blob_list->getBlobs();
	
	try {
		foreach($blobs as $blob) {
			echo '<pre>';
			print_r($blob);
			echo '</pre>';
		}
	}
	catch(ServiceException $e){
	    echo '<h1>Some error or no files...</h1>';
		echo '<pre style="background: #eee; padding: 10px;">';
		    $code = $e->getCode();
		    $error_message = $e->getMessage();
		    echo $code.": ".$error_message."<br />";
		echo '</pre>';
	}
	*/
	
	
	
	//Delete
	/*
	$prefix = $productionFolder.'/preview/';
	$blobListOptions = new ListBlobsOptions();
	$blobListOptions->setPrefix($prefix);
	$blob_list = $blobRestProxy->listBlobs($_SESSION['account_code'], $blobListOptions);
	$productionFiles = $blob_list->getBlobs();
	
	foreach($productionFiles as $productionFile) {
		$blobRestProxy->deleteBlob($_SESSION['account_code'], $productionFile->getName());
	}
	*/
	
	
	
	//Copy
	/*
	$prefix = 'template/'.$page['template_id'];
	$blobListOptions = new ListBlobsOptions();
	$blobListOptions->setPrefix($prefix);
	$blob_list = $blobRestProxy->listBlobs($_SESSION['account_code'], $blobListOptions);
	
	$templateFiles = $blob_list->getBlobs();
	
	foreach($templateFiles as $templateFile) {
		$templateFile_filename = str_replace('template/'.$page['template_id'].'/', '', $templateFile->getName());
		//if ($templateFile_filename != 'ignore' && $templateFile && $templateFile != '..' && $templateFile != '.'){ //copy only this }
		$templateFile_content = file_get_contents($templateFile->getUrl());
		$blobRestProxy->createBlockBlob($_SESSION['account_code'], $productionFolder.'/preview/'.$templateFile_filename, $templateFile_content); 
	}
	*/
?>
