<?php 
	require("functions.php");
	
	require("Helper.class.php");
	
	$Helper = new Helper($mysqli);
	
	require("Nature.class.php");
	$nature = new nature($mysqli);
	
	
	$contentError = "*";
		
	if (isset ($_POST["content"])) {
			if (empty ($_POST["content"])) {
				$contentError = "*Sisesta laulu märksõnad!";
			} else {
				$content = $_POST["content"];
		}
		
	} 
	
	$noteError = "*";
	
	if (isset ($_POST["note"])) {
			if (empty ($_POST["note"])) {
				$noteError = "*Sisesta laulu pealkiri!";
			} else {
				$note = $_POST["note"];
		}
		
	} 
	
	$mainError = "*";
	
	if (isset ($_POST["main"])) {
			if (empty ($_POST["main"])) {
				$mainError = "*Sisesta laulu sõnad!";
			} else {
				$main = $_POST["main"];
		}
		
	} 
	
	
		// kui ei ole sisseloginud, suunan login lehele
		if(!isset($_SESSION["userId"])) {
			header("Location: login.php");
		}
	
		//kas aadressi real on logout
	if (isset($_GET["logout"])) {
		session_destroy();
		
		header("Location: login.php");
		
	}
	if ( isset($_POST["content"]) &&
	     isset($_POST["note"]) &&
		 isset($_POST["main"]) &&
		 !empty($_POST["content"]) &&
		 !empty($_POST["note"])&&
		 !empty($_POST["main"])
		 ) {
			 $nature->saveNature($Helper->cleanInput($_POST["content"]), $Helper->cleanInput($_POST["note"]), $Helper->cleanInput($_POST["main"]));
			 
			 header("Location: data.php");
			 
			 }
			 
		
	if (isset($_GET["q"])) {
		
		$q = $_GET["q"];
	
	} else {
		$q = "";
		}
		$sort = "id";
	$order = "ASC";
	
	if(isset($_GET["sort"]) && (isset($_GET["order"]))) {
		$sort = $_GET["sort"];
		$order = $_GET["order"];
	}
		
		
	
	
	
	$nature = $nature->getAllNature($q, $sort, $order);
	
		
?>

<h1>Laulude andmebaas</h1>

<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>! <br><br>
	<a href="?logout=1">logi välja</a>
	
</p>
<br><br>
<body>
	
		<h1>Salvesta Laulu andmed</h1>
		
		<form method="POST">
	<input name="content" placeholder="Laulu Pealkiri" type="text"> <br><br>
	<input name="note" placeholder=" Laulu Sõnad" type="text"> <br><br>
	<input name="main" placeholder="märksõnad" type="text"> <br><br>
	<input type="submit" value="Sisesta andmed">
</form>
<br><br>
		
		<h2>Laulude Arhiiv</h2>
		
		<form>
	<input type="search" name="q" value="<?=$q;?>">
	<input type="submit" value="Otsi">
</form>
<br><br>
<br><br>
<?php
	$html = "<table>";
		
		$html .= "<tr>";
		
			$orderId = "ASC";
			
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "id" ) {
					
				$orderId = "DESC";
				
			}
			
			$orderContent = "ASC";
        if (isset($_GET["order"]) &&
            $_GET["order"] == "ASC" &&
            $_GET["sort"] == "content" ) {
            $orderContent = "DESC";
        }
		
			$orderNote = "ASC";
        if (isset($_GET["order"]) &&
            $_GET["order"] == "ASC" &&
            $_GET["sort"] == "note" ) {
            $orderNote = "DESC";
        }
		
			$orderMain = "ASC";
        if (isset($_GET["order"]) &&
            $_GET["order"] == "ASC" &&
            $_GET["sort"] == "main" ) {
            $orderMain = "DESC";
        }
		
			$html .= "<th>
						<a href='?q=".$q."&sort=id&order=".$orderId."'>
							ID 
						</a>
					 </th>";
			$html .= "<th>
						<a href='?q=".$q."&sort=content&order=".$orderContent."'>
							Laulu Pealkiri
						</a>
					 </th>";
			$html .= "<th>
						<a href='?q=".$q."&sort=note&order=".$orderNote."'>
							Laulu Sõnad
						</a>
					 </th>";
			$html .= "<th>
						<a href='?q=".$q."&sort=main&order=".$orderMain."'>
							märksõnad
						</a>
					 </th>";
					 
					 $html .= "</tr>";
		
		foreach ($nature as $n) {
		$html .= "<tr>";
			$html .= "<td>".$n->id."</td>";
			
			$html .= "<td>".$n->content."</td>";
			
			$html .= "<td>".$n->note."</td>";
			
			
			$html .= "<td>".$n->main."</td>";
			
			 $html .= "<td><a href='edit.php?id=".$n->id."'>Muuda</a></td>";
			$html .= "</tr>";
		
	}
	$html .= "</table>";
	echo $html;
?>
</body>	
</html>