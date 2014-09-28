<?php
	class PlayerCards extends DatabaseObject
	{
		public $table	= "player_cards";
		
		public function __construct()
		{
		}
		
		public function GetPlayerCardsID($player_id)
		{
			if ( !is_numeric( $player_id ) )
				throw new Exception("");
			
			$database	= Database::Get();
			$sql		= $database->prepare( "SELECT * FROM `{$this->table}` WHERE `player_id` = ?" );
			$sql->bind_param( "i", $player_id );
			if ( $sql->execute() === false )
				throw new Exception("execution error");
			
			$row;
			$result = $sql->get_result();
			if ( $database->affected_rows < 1 )
				throw new Exception("player has no cards");
			
			$card_ids = array();
			while ( $row = $result->fetch_assoc() )
			{
				$card_ids[] = array( "card_id" => $row["card_id"], "ammount" => $row["ammount"] );
			}
			
			$result->free();
			$sql->close();
			
			return $card_ids;
		}
		
		public function GetPlayerCardsCount($player_id)
		{
			if ( !is_numeric( $player_id ) )
				throw new Exception("");
			
			$database	= Database::Get();
			$sql		= $database->prepare( "SELECT COUNT(*) FROM `{$this->table}` WHERE `player_id` = ?" );
			$sql->bind_param( "i", $player_id );
			if ( $sql->execute() === false )
				throw new Exception("execution error");
			
			$row;
			$count = 0;
			$result = $sql->get_result();
			if ( $row = $result->fetch_row() )
				$count = (int)$row[0];
			
			
			$result->free();
			$sql->close();
			
			return $count;
		}
	}
?>