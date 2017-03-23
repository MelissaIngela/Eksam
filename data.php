<?php 
	require("functions.php");
	
	require("Helper.class.php");
	
	$Helper = new Helper($mysqli);
	
	require("Nature.class.php");
	$nature = new nature($mysqli);
	
	
	$descriptionError = "*";
		
	if (isset ($_POST["content"])) {
			if (empty ($_POST["content"])) {
				$descriptionError = "*Sisesta laulu märksõnad!";
			} else {
				$description = $_POST["content"];
		}
		
	} 
	
	$dateError = "*";
	
	if (isset ($_POST["note"])) {
			if (empty ($_POST["note"])) {
				$dateError = "*Sisesta laulu pealkiri!";
			} else {
				$date = $_POST["note"];
		}
		
	} 
	
	$urlError = "*";
	
	if (isset ($_POST["main"])) {
			if (empty ($_POST["main"])) {
				$urlError = "*Sisesta laulu sõnad!";
			} else {
				$url = $_POST["main"];
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

<h1>Data</h1>

<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?></a>!
	<a href="?logout=1">logi välja</a>
	
</p>
<body>
	
		<h1>Salvesta andmed</h1>
		
		<form method="POST">
	<input name="content" placeholder="Märksõna" type="text"> <br><br>
	<input name="note" placeholder="Sõnad" type="text"> <br><br>
	<input name="main" placeholder="Pealkiri" type="text"> <br><br>
	<input type="submit" value="Sisesta andmed">
</form>
		
		<h2>Arhiiv</h2>
		
		<form>
	<input type="search" name="q" value="<?=$q;?>">
	<input type="submit" value="Otsi">
</form>

<?php
	$html = "<table>";
		
		$html .= "<tr>";
		
			$orderId = "ASC";
			
			if (isset($_GET["order"]) && 
				$_GET["order"] == "ASC" &&
				$_GET["sort"] == "id" ) {
					
				$orderId = "DESC";
				
			}
			
			$orderDescription = "ASC";
        if (isset($_GET["order"]) &&
            $_GET["order"] == "ASC" &&
            $_GET["sort"] == "content" ) {
            $orderDescription = "DESC";
        }
		
			$orderDate = "ASC";
        if (isset($_GET["order"]) &&
            $_GET["order"] == "ASC" &&
            $_GET["sort"] == "note" ) {
            $orderDate = "DESC";
        }
		
			$orderUrl = "ASC";
        if (isset($_GET["order"]) &&
            $_GET["order"] == "ASC" &&
            $_GET["sort"] == "main" ) {
            $orderUrl = "DESC";
        }
		
			$html .= "<th>
						<a href='?q=".$q."&sort=id&order=".$orderId."'>
							ID 
						</a>
					 </th>";
			$html .= "<th>
						<a href='?q=".$q."&sort=description&order=".$orderContent."'>
							Märksõna
						</a>
					 </th>";
			$html .= "<th>
						<a href='?q=".$q."&sort=date&order=".$orderNote."'>
							Sõnad
						</a>
					 </th>";
			$html .= "<th>
						<a href='?q=".$q."&sort=url&order=".$orderMain."'>
							Pealkiri
						</a>
					 </th>";
					 
					 $html .= "</tr>";
		
		foreach ($nature as $n) {
		$html .= "<tr>";
			$html .= "<td>".$n->id."</td>";
			
			$html .= "<td>".$n->content."</td>";
			
			$html .= "<td>".$n->note."</td>";
			$html .= "<td><img width='150' src=' ".$n->main." '></td>";
			 $html .= "<td><a href='edit.php?id=".$n->id."'>Muuda</a></td>";
			$html .= "</tr>";
		
	}
	$html .= "</table>";
	echo $html;
?>
</body>	
</html>