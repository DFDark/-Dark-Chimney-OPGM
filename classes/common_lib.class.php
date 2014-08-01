<?php
	class CommonLib
	{
		/**
		* Encodes given string
		*
		* @param string $value Text to be encoded
		* @return string Encoded text
		*/
		public static function Encode($value)
		{
			$value = addslashes($value);
			$value = htmlspecialchars($value);
			return $value;
		}
		
		/**
		* Decodes given string
		*
		* @param string $value Text to be decoded
		* @return string Decoded text
		*/
		public static function Decode($value)
		{
			$value = htmlspecialchars_decode($value);
			$value = addslashes($value);
			return $value;
		}
		
		/**
		* Redirect client to $target url and ends PHP execution
		*
		* @param string $target URL for client to be redirected to
		*/
		public static function Redirect($target)
		{
			header("Location: {$target}");
			exit;
		}
		
		/**
		* Adds string to be displayed as system message
		*
		* @param string $message
		* @param int $status optional
		*/
		public static function DisplayMessage( $message, $status = 0 )
		{
			if ( empty( $_SESSION['system_messages'] ) )
				$_SESSION['system_messages'] = array();
			
			$_SESSION['system_messages'][] = array( $message, $status );
		}
	}
?>