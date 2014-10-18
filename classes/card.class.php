<?php
	class Card extends DatabaseObject
	{
		public $table	= "card";
		
		public function __construct()
		{
			$arg_num = func_num_args();
			
			switch ($arg_num)
			{
				case 1 : $this->LoadById( func_get_arg(0) ); break;
			}
		}
		
		
		/**
		*/
		public function GetCardsByLevel( $level )
		{
			if ( !is_numeric( $level ) )
				throw new Exception("Card level invalid");

			$database	= Database::Get();
			$sql		= $database->prepare( "SELECT * FROM `{$this->table}` WHERE `level` = ?" );
			$sql->bind_param( "i", $level );
			if ( $sql->execute() === false )
				throw new Exception("execution error");
			
			$row;
			$result = $sql->get_result();
			if ( $database->affected_rows < 1 )
				throw new Exception("no cards");
			
			$card_list = array();
			while ( $row = $result->fetch_assoc() )
			{
				$card = new Card();
				foreach ( $row as $column_name => $column_value )
					$card->Set($column_name, $column_value);
				$card_list[] = $card;
			}
			$result->free();
			$sql->close();
			
			return $card_list;
		}
	}
?>