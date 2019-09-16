<?php
	include 'requests/champs.php';
    $server = strtolower($_POST['server']);
    $summoner = $_POST['summoner'];
    $api = "";
    $summoner = str_replace(" ","%20",$summoner);
    $url = "https://". $server . ".api.riotgames.com/lol/summoner/v4/summoners/by-name/" . $summoner . "?api_key=" . $api;

    if($server == "br1" || $server == "ru" || $server == "kr" || $server == "oc1" || $server == "jp1" || $server == "na1" || $server == "eun1" || $server == "euw1" || $server == "tr1" || $server == "la1" || $server == "la2"){
    	
    } else {
    	header("Location: index.html");
    }

    $ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	curl_close($ch);
	$result = json_decode($result, true);

	$name = $result['name'];
	$level = $result['summonerLevel'];
	// Profile Icon
	$imgs = "https://static.teemo.gg/league-of-legends/9.17/profile-icons/";
	$profileIcon = (string) $result['profileIconId'];
	$imgSrc = $imgs . $profileIcon . ".jpg";
	// Summoner Id
	$summonerId = $result['id'];
	
	$urlRank = "https://" . $server . ".api.riotgames.com/lol/league/v4/entries/by-summoner/" . $summonerId . "?api_key=" . $api;

    $ch1 = curl_init();
	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch1, CURLOPT_URL, $urlRank);
	$result = curl_exec($ch1);
	curl_close($ch1);
	$resultR = json_decode($result, true);

	$resultRank = $resultR[0];

	$tier = $resultRank['tier'];
	$rank = $resultRank['rank'];
	$wins = $resultRank['wins'];
	$losses = $resultRank['losses'];
	if($tier == "" || $tier == null && $rank == "" || $rank == null) {
		$tier = "UNRANKED";
		$rank = "";
		$wins = 0;
		$losses = 0;
	}
	$rankToImg = str_replace(" ","_",$tier);
	$rankToImg = strtolower($rankToImg);
	
	//Champions Maestry
	$urlMaestry = "https://" . $server . ".api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/" . $summonerId . "?api_key=" . $api;
	
	$ch2 = curl_init();
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch2, CURLOPT_URL, $urlMaestry);
	$result = curl_exec($ch2);
	curl_close($ch2);
	$resultM = json_decode($result, true);

?>

<!DOCTYPE html>
<html>
<head>
	<title>TitaniumGG</title>
	<link rel="stylesheet" href="css/summoner.css" type="text/css"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Noto+Sans+HK&display=swap" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<style>
		body {
                background-color:#D3D3D3;
            }
	</style>
</head>
<body>
	<div id="main">
		<div id="summonerInfos" align="center">
				<p id="summonerName" style="font-family: 'Noto Sans HK', sans-serif; font-weight: bold;"><?php echo $name; ?></p>
				<img src="<?php echo $imgSrc; ?>" id="summonerIcon" style="width: 150px; height: 150px; border-radius: 50%;"/><br>		
				<p id="summonerLevel" style="font-family: 'Noto Sans HK', sans-serif; font-weight: bold;"><?php echo $level; ?></p>
				<label>RANK:</label><label id="summonerRank" style="font-weight: bold;"><?php echo $tier . " " . $rank; ?></label><br>
				<?php 
				echo "<img src='imgs/tier-icons/".$rankToImg.".png'/><br/>";
				?>
				<button type="button" class="btn btn-success"><?php echo $wins . ' vitórias';?></button><label class="x">X</label><button type="button" class="btn btn-danger"><?php echo $losses . ' derrotas';?></button><br>
			</div>
		<div id="result" style="margin-top: 4em;">
			<div id="maestrys" style="position:absolute;" align="center">
			<?php 
					foreach ($resultM as $champ) {
						$icon = ucfirst(strtolower(str_replace("'","",str_replace(" ","",ChIDToName($champ['championId'])))));
						if($icon == "Kogmaw"){
							$icon = "KogMaw";
						} elseif ($icon == "Twistedfate") {
							$icon = "TwistedFate";
						} elseif ($icon == "Masteryi") {
							$icon = "MasterYi";
						} elseif ($icon == "Missfortune") {
							$icon = "MissFortune";
						} elseif ($icon == "Xinzhao") {
							$icon = "XinZhao";
						} elseif ($icon == "Dr.mundo") {
							$icon = "DrMundo";
						} elseif ($icon == "Wukong") {
							$icon = "MonkeyKing";
						} elseif ($icon == "Aurelionsol") {
							$icon = "AurelionSol";
						} elseif ($icon == "Jarvaniv") {
							$icon = "JarvanIV";
						} elseif ($icon == "Tahmkench") {
							$icon = "TahmKench";
						} elseif ($icon == "Leesin") {
							$icon = "LeeSin";
						} elseif($icon == "Reksai"){
							$icon = "RekSai";
						}
						$score = $champ['championPoints'];
						$maestryLevel = $champ['championLevel'];
						if($maestryLevel == 1){
							$iconMaestry = "https://vignette.wikia.nocookie.net/leagueoflegends/images/d/d8/Champion_Mastery_Level_1_Flair.png/revision/latest?cb=20150312005229&format=original";
						} elseif($maestryLevel == 2){
							$iconMaestry = "https://vignette.wikia.nocookie.net/leagueoflegends/images/4/4d/Champion_Mastery_Level_2_Flair.png/revision/latest?cb=20150312005244&format=original";
						} elseif ($maestryLevel == 3) {
							$iconMaestry = "https://vignette.wikia.nocookie.net/leagueoflegends/images/e/e5/Champion_Mastery_Level_3_Flair.png/revision/latest?cb=20150312005319&format=original";
						} elseif ($maestryLevel == 4) {
							$iconMaestry = "https://vignette.wikia.nocookie.net/leagueoflegends/images/b/b6/Champion_Mastery_Level_4_Flair.png/revision/latest?cb=20150312005332&format=original";
						} elseif ($maestryLevel == 5){
							$iconMaestry = "https://vignette.wikia.nocookie.net/leagueoflegends/images/9/96/Champion_Mastery_Level_5_Flair.png/revision/latest?cb=20150312005344&format=original";
						} elseif ($maestryLevel == 6) {
							$iconMaestry = "http://3.bp.blogspot.com/-7w7NStt6ZKU/VdDTcuDov8I/AAAAAAAAAEg/ECHPzWw_GrU/s1600/image%2B183.png";
						} elseif ($maestryLevel == 7){
							$iconMaestry = "https://4.bp.blogspot.com/-QbNqC_3bGZQ/VypfhMBS2OI/AAAAAAAABjs/BYfPxW9J0IwcZDTxzQ5azlTQYYTvDIo0wCLcB/s1600/maestri%2B7.png";
						}
						echo "<div id='".ChIDToName($champ['championId']). "' style='margin-left:20px;display:inline-block;'><label id='champName' style='text-transform: uppercase; font-weight: bold;'>".ChIDToName($champ['championId'])."</label>";
						$iconChamp = "https://ddragon.leagueoflegends.com/cdn/9.15.1/img/champion/".$icon.".png";
						echo "<br><img class='iconChampion' src='https://ddragon.leagueoflegends.com/cdn/9.16.1/img/champion/".$icon.".png' id='".ChIDToName($champ['championId'])."' onmouseover=\"this.src='".$iconMaestry."'\" onmouseout=\"this.src='".$iconChamp."'\" style='border-radius:60%;'/><br>";
						#echo "<img src='".$iconMaestry."' id='".ChIDToName($champ['championId'])."' style='position:relative;'/>";
						echo "<label id='score' style=''>".$score."</label></div>";
					} ?>
			</div>
		</div>
	</div>
</body>
</html>
