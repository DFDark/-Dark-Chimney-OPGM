<?php
	class CommonLib
	{
		public static function Encode($value)
		{
			$value = addslashes($value);
			$value = htmlspecialchars($value);
			return $value;
		}
		
		public static function Decode($value)
		{
			$value = htmlspecialchars_decode($value);
			$value = addslashes($value);
			return $value;
		}
		
		public static function Redirect($target)
		{
			header("Location: {$target}");
			exit;
		}
	}
?>