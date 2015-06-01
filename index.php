<?php
	include 'server.php';
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/styles.css">

  <title>Leaderboard-Dingding Pan</title>

  <script type="text/javascript" src="js/jquery.js"></script>

  <script>
 
  $( document ).ready(function() {

  	$(".none").show();
  	$(".details").hide();

  	//function to highlight the section, show the details and hide none class 
  	$(".player").click(function() {
  		var name = $(this).find( ".name" ).text();
		$(".player").each(function() {
			$(".player").removeClass( "selected" );
		});
		$(this).addClass("selected");
		$(".none").hide();
  		$(".details").show();
		$(".details").find(".name").html(name);
	});

  	//function to give point to player, update the point, swap the div postion, save the data and player order to server file.
  	$( ".inc" ).click(function() {
  		var name = $(".selected").find('.name').text();
  		$.ajax({
			type: "POST",
			url: "server.php",
			dataType: "json",
			data: { name : name},
			success: function(data) {
				$(".selected").find('.score').html(data['point']);
				compareScore();	
				saveList();	
			}
	    });
	});

  	//Comparing the point to change the div position after player gain score. 
	function compareScore(){
		var score = parseInt($(".selected").find('.score').text());
		var prevScore = parseInt($(".selected").prev().find('.score').text());
		if(score > prevScore){
			$(".selected").insertBefore($(".selected").prev('.player'));
			compareScore();
		}
		if(score == prevScore){
			compareName();
		}
	}

	//Comparing the name when multiple players have same point.
	function compareName(){
		var name = $(".selected").find('.name').text();
		var prevName = $(".selected").prev().find('.name').text();
		if(name < prevName){
			$(".selected").insertBefore($(".selected").prev('.player'));
			compareScore();
		}
	}

	//Ajax function to save the players and point by order to json file.
	function saveList(){
		var nameArray = new Array();
		var scoreArray = new Array();
		$( ".player" ).each(function() {
			var name = $(this).find('.name').text();
			var score = $(this).find('.score').text();
			nameArray.push(name);
			scoreArray.push (score);
		});
		$.ajax({
			type: "POST",
			url: "server.php",
			dataType: "json",
			data: { nameArray : nameArray,scoreArray:scoreArray },
			success: function() {     
			}
		}); 
	}



  });
 
  </script>

</head>

<body>
<div id="outer">
	<div class="leaderboard">
		<?php
			$playersList = getListFromJsonFile();
			foreach($playersList as  $player){
				echo '<div class="player">';
				echo '<span class="name">'.$player->getName().'</span>';
				echo '<span class="score">'.$player->getPoint().'</span>';
				echo '</div>';
			}
		?>
	</div>
	<div class="none">Click a player to select</div>
	<div class="details">
		<div class="name"></div>
		<input type="button" value="Give 5 points" class="inc">
	</div>
</div>

</body>
</html>