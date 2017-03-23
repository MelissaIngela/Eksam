<?php
class nature {
	
	private $connection;
	

	function __construct($mysqli){
		
		$this->connection = $mysqli;
		
	}
	
		function saveNature($content, $note, $main) {
			
			$stmt = $this->connection->prepare("INSERT INTO colorNotes (content, note, main ) VALUE (?, ?, ?)");
			echo $this->connection->error;
			
			$stmt->bind_param("sss", $content, $note, $main);
			
			if ($stmt->execute() ){
				echo "õnnestus";
			} else {
				echo "ERROR".$stmt->error;
			}
		}
		
		function getAllNature ($q, $sort, $order){
			
			$allowedSort = ["id", "content", "note", "main"];
			
			if(!in_array($sort, $allowedSort)){
            $sort = "id";
        }
        $orderBy = "ASC";
        if($order == "DESC") {
            $orderBy = "DESC";
        }
        echo "Sorteerin: ".$sort." ".$orderBy." ";
			
			if ($q != "") {
			
			echo "otsin: ".$q;
			
				$stmt = $this->connection->prepare("SELECT id, content, note, main FROM colorNotes WHERE deleted IS NULL AND ( description LIKE ? OR date LIKE ? OR url like ? ) ORDER BY $sort $orderBy");
				$searchWord = "%".$q."%";
				$stmt->bind_param("sss", $searchWord, $searchWord, $searchWord);
				
			} else {
				
				$stmt = $this->connection->prepare("SELECT id, content, note, main FROM colorNotes WHERE deleted IS NULL ORDER BY $sort $orderBy");
					}
			$stmt->bind_result($id, $content, $note, $main);
			$stmt->execute();
			
			$results = array();
			// Tsükli sisu tehake nii mitu korda, mitu rida SQL lausega tuleb
			while($stmt->fetch()) {
				//echo $color."<br>";
				$nature2= new StdClass();
				$nature2->id = $id;
				$nature2->content = $content;
				$nature2->note = $note;
				$nature2->main = $main;
				
				array_push($results, $nature2);
			}
			
			return $results;
		}
		
		function getSinglePerosonData($edit_id){
		
		$stmt = $this->connection->prepare("SELECT content, note, main FROM colorNotes WHERE id=? AND deleted IS NULL");

		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($content, $note, $main);
		$stmt->execute();
		
		
		$p = new Stdclass();
		
		
		if($stmt->fetch()){
			
			$p->content = $content;
			$p->note = $note;
			$p->main = $main;
			
			
		}else{
			
			header("Location: data.php");
			exit();
		}
		
		$stmt->close();
		
		
		return $p;
		
	}
		
	function updateNature($id, $content, $note, $main){
    	
		
		$stmt = $this->connection->prepare("UPDATE colorNotes SET content=?, note=?, main=? WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("sssi",$content, $note, $main, $id);
		
		
		if($stmt->execute()){
			
			echo "salvestus õnnestus!";
		}
		
		$stmt->close();
		
		
	}
	function deleteNature($id){
    	
		$stmt = $this->connection->prepare("UPDATE colorNotes SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$id);
		
		
		if($stmt->execute()){
			
			echo "kustutamine õnnestus!";
		}
		
		$stmt->close();
		
		
	}
		
	
	
}