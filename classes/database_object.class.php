<?php
	class DatabaseObject
	{
		public			$table	= "";
		protected		$data	= array();
		
		public function __construct()
		{
			$arg_num = func_num_args();
			if ($arg_num > 0)
			{
				switch ($arg_num)
				{
					case 1 : $this->LoadByID( func_get_arg(0) ); break;
				}
			}
		}
		
		protected function LoadByID( $id )
		{
			if ( !is_numeric($id) || is_null($id) || $id <= 0 )
				throw new Exception( get_class($this) . " ID invalid!");
			
			$database	= Database::Get();
			$sql		= $database->prepare( "SELECT * FROM `{$this->table}` WHERE `id` = ?" );
			
			if ( $sql === false )
				throw new Exception( "Prepare statement error" );
			
			$sql->bind_param( "i", $id );
			if ( $sql->execute() === false )
				throw new Exception("SQL Execution error");
			
			if ( $sql->affected_rows != 1 )
				throw new Exception( "" );
			
			$row;
			$result = $sql->get_result();
			
			if ( $result === false )
				throw new Exception( "" );
			
			if ( $row = $result->fetch_assoc() )
			{
				foreach ( $row as $column_name => $column_value )
					$this->data[$column_name] = $column_value;
			}
			$result->free();
			$sql->close();
		}
		
		public function Get( $column )
		{
			if ( isset( $this->data[$column] ) )
				return $this->data[$column];
			
			return null;
		}
		
		public function Set( $column, $value )
		{
			$this->data[$column] = $value;
		}
		
		protected function Insert()
		{
			if ( empty( $this->data ) )
				throw new Exception("Empty insert");
		
			$database	= Database::Get();
			$sql		= "INSERT INTO `{$this->table}` ";
			$sql		.= "(`" . implode("`,`", array_keys($this->data)) . "`) ";
			$sql		.= "VALUES ";
			
			$values = array();
			foreach ($this->data as $value)
			{
				if (is_null($value))
					$values[] = "NULL";
				else
					$values[] = "'{$value}'";
			}
			
			$sql		.= "(" . implode(",", $values) . ")";
			$sql		= $database->prepare( $sql );
			
			if ($sql === false)
				throw new Exception("Prepare statement error");
			
			if ($sql->execute() === false)
				throw new Exception("SQL Execution failed");
			
			$sql->close();
		}
		
		protected function Update()
		{
			if (empty($this->data))
				throw new Exception("Empty update");
			
			$database	= Database::Get();
			$sql		= "UPDATE `{$this->table}` SET ";
			
			$values = array();
			foreach ( $this->data as $key => $value )
			{
				if ( is_null($value) )
					$values[] = "`{$key}` = NULL";
				else
					$values[] = "`{$key}` = '{$value}'";
			}
			
			$sql .= implode( ",", $values ) . " WHERE `id` = '{$this->data['id']}'";
			$sql = $database->prepare( $sql );
			
			if ($sql === false)
				throw new Exception("Prepare statement error");
			
			if ($sql->execute() === false)
				throw new Exception("SQL Execution failed");
			
			$sql->close();
		}
		
		public function Save()
		{
			if ( !empty( $this->data['id'] ) && is_numeric( $this->data['id'] ) )
			{
				$database	= Database::Get();
				$sql		= "SELECT COUNT(*) AS 'count' FROM `{$this->table}` WHERE `id` = ?";
				$sql		= $database->prepare( $sql );
				
				if ( $sql === false )
					throw new Exception("Prepare statement error");
				
				$sql->bind_param( "i", $this->data['id'] );
				
				if ( $sql->execute() === false )
					throw new Exception("SQL Execution failed");
				
				try
				{
					$result = $sql->get_result();
					if ( $result === false )
						throw new Exception();
					
					$data = $result->fetch_assoc();
					if ( is_null( $data ) )
						throw new Exception();
					
					if ( $data['count'] <= 0 )
						throw new Exception();
					
					$this->Update();
				}
				catch ( Exception $e )
				{
					$this->Insert();
				}
				
			}
			else
				$this->Insert();
		}
	}
?>