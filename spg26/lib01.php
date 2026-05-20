<?php

	function drawTrapezoid($top, $bottom, $symbol){
		for($row=$top-1; $row<$bottom; $row++){
			for($col=0; $col<($row+1); $col++){
				echo $symbol;
			}
			echo "<br>";
		}
	}

	function showMessage(){
		echo "Hello World!";
		echo "<br>";
	}
	
	function showImage($weather){
		echo "It is ".$weather."! <br>";
		$image="";
		if($weather=="Freezing") {
			$image="https://upload.wikimedia.org/wikipedia/commons/b/bf/Ch%C3%A2teau_Frontenac_after_a_freezing_rain_day_in_Quebec_city.jpg";
		} else if($weather=="Cold") {
			$image="https://upload.wikimedia.org/wikipedia/commons/5/57/Cold%2C_wet%2C_gloomy.jpg";
		} else if($weather=="Warm") {
			$image="/image/warmSpring.jpg";
		} else { //hot
			$image="https://upload.wikimedia.org/wikipedia/commons/5/5e/Heat_wave_refresh_it_with_water.jpg";
		}
		
		echo "<img src='".$image."' width='400px'>";
	}
	
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		
		return $data;
	}
	
	//add export function

	function uploadFile($tagName, $fileAllowed, $sizeAllowed, $overwriteAllowed){
		$uploadOK=1; 
		$dir = __DIR__ . "/uploaded/";
		$relativeDir = "uploaded/";
		if(!file_exists($dir)){
			mkdir($dir, 0777, true);
		}
		$baseName = basename($_FILES[$tagName]["name"]);
		$file = $dir . $baseName;
		$relativeFile = $relativeDir . $baseName;
		$fileType=pathinfo($file, PATHINFO_EXTENSION);
		$fileSize=$_FILES[$tagName]["size"];
		
		if($fileSize>$sizeAllowed){
			echo "File size is too big. Maximum is 9MB allowed.";
			$uploadOK=0;
		}
		
		if(!stristr($fileAllowed, $fileType)){
			echo "Sorry, this file type is NOT allowed.";
			$uploadOK=0;
		}
		
		if(file_exists($file) && !$overwriteAllowed){
			echo "File already exists in server. Please upload a different file.";
			$uploadOK=0;
		}
		
		if($uploadOK==1){
			if(!move_uploaded_file($_FILES[$tagName]["tmp_name"], $file)){
				echo "Sorry, uploading failed in the process.";
				$uploadOK=0;
			}
		}
		
		if($uploadOK==1){
			return $relativeFile;
		} else {
			return false;
		}
	}

function exportUsersToCSV(){
	
}
?>
