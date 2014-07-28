<?php
	/**
	* Controler
	*
	* @author   Hamid Khairy <hamid.khairy@webconsulting.cz>
	* @version  $Revision: 1.0.0.0 $
	* @access   public
	*/
	class Controler
	{
		public $content;
		public $subcontent;
		
		public function Process()
		{
			$type	= $_POST['type'];
			
			switch ( $type )
			{
				case 1 : $this->RegisterPlayer();	break;
				case 2 : $this->LoginPlayer();		break;
			}
		}
		
		private function GetPath()
		{
			$subcontent = "";
			if ( strlen($this->subcontent) > 0 )
				$subcontent = $this->subcontent . "/";
			
			return ROOT_DIR . "/{$this->content}/{$subcontent}";
		}
		
		private function RegisterPlayer()
		{
			try
			{
				if ( empty( $_POST['email'] ) )
					throw new Exception("");
				else if ( empty( $_POST['password'] ) )
					throw new Exception("");
				
				$email		= $_POST['email'];
				$password	= $_POST['password'];
				
				$user		= new User();
				$user->Set( 'nickname', $_POST['nickname'] );
				$user->Set( 'email', $email );
				$user->CreatePasswordHash( $password );
				$user->Save();
			}
			catch ( Exception $e )
			{
			}
			
			CommonLib::Redirect( $this->GetPath() );
		}
		
		private function LoginPlayer()
		{
			
		}
	}
?>