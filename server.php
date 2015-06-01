<?php
	include 'player.class.php';

	$list = array();

	//get the list of player from a json file.
	//return array.
	function getListFromJsonFile(){
		$fileHandle = fopen("data.json", 'r')
			or die("Error Opening data file.");
		$data = json_decode(file_get_contents('data.json'),true);
		foreach ($data as $key => $value) {
			$player = new Player($key,$value);
			$list[$key] = $player;
		}
		fclose($fileHandle);
		return $list;
	}
	
	//save the player name and point to json file
	function saveListToJsonFile($list){
		$fileHandle = fopen("data.json", 'w')
			or die("Error Opening data file.");
		fwrite($fileHandle, json_encode($list));
		fclose($fileHandle);
	}

	//when get $_POST from index page, check the $_POST content 
	//if the post to give the point then set the player point +5, and return point value 
	//to index to update the html.
	//if the post to save the data, then save the data in to array and call the function to 
	//save in json file.
	if($_POST){
		if(isset($_POST['name'])){
			$list = getListFromJsonFile();
			$player = $list[$_POST['name']];
			$point = $player->getPoint()+5;
			$player->setPoint($point);
			$result = array();
			$result['name'] = $player->getName();
			$result['point']= $player->getPoint();
			echo json_encode($result);
		}else{
			for($i=0;$i<sizeof($_POST['nameArray']);$i++){
				$list[$_POST['nameArray'][$i]] = $_POST['scoreArray'][$i];
			}
			saveListToJsonFile($list);
		}
	}

?>