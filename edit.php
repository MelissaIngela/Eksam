<?php
	
	require("functions.php");
	
	require("Helper.class.php");
	$Helper = new Helper();
	
	require("Nature.class.php");
	$Nature = new Nature($mysqli);
	
	if(isset($_GET["delete"]) && isset($_GET["id"])){
		
		$Nature->deleteNature($Helper->cleanInput($_GET["id"]));
		header("Location: data.php");
        exit();	
		
	}
	
	
	if(isset($_POST["update"])){
		
		$Nature->updateNature($Helper->cleanInput($_POST["id"]), $Helper->cleanInput($_POST["content"]), $Helper->cleanInput($_POST["note"]), $Helper->cleanInput($_POST["main"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
		
	}
	
	
	$p = $Nature->getSinglePerosonData($_GET["id"]);
	var_dump($p);

	
?>
<br><br>
<a href="data.php"> tagasi </a>

<h2>Muuda Laulu andmeid</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
  	<label for="content" >Pealkiri</label><br>
	<input id="content" name="content" type="text" value="<?php echo $p->content;?>" ><br><br>
  	<label for="note" >Laulusõnad</label><br>
	<input id="note" name="note" type="note" value="<?=$p->note;?>"><br><br>
	<label for="main" >märksõnad</label><br>
	<input id="main" name="main" type="note" value="<?php echo $p->main;?>" ><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
  </form>
  
  <a href="?id=<?=$_GET["id"];?>&delete=true">kustuta</a> 