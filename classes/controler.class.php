<?php
	/**
	* Controler
	*
	* @author   Hamid Khairy <hamidkhairy@seznam.cz>
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
				case 3 : $this->LogoutPlayer();		break;
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
				if ( empty( $_POST['nickname'] ) )
					throw new Exception("Nickname cannot be empty");
				if ( empty( $_POST['email'] ) )
					throw new Exception("Email cannot be empty");
				else if ( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) )
					throw new Exception("Email is invalid");
				else if ( strcmp( $_POST['email'], $_POST['email_verification'] ) !== 0 )
					throw new Exception("Email does not match verification");
				else if ( empty( $_POST['password'] ) )
					throw new Exception("Password has to have at least 6 characters!");
				else if ( strcmp( $_POST['password'], $_POST['password_verification'] ) !== 0 )
					throw new Exception("Password does not match verification");
				
				$player		= new Player();
				$player->Set( 'nickname', $_POST['nickname'] );
				$player->Set( 'email', $_POST['email'] );
				$player->CreatePasswordHash( $_POST['password'] );
				$player->Set( 'created', time() );
				$player->Set( 'last_active', time() );
				$player->Set( 'game_points', 30 );
				$player->Save();
			}
			catch ( Exception $e )
			{
				CommonLib::DisplayMessage( $e->GetMessage() );
			}
			
			CommonLib::Redirect( $this->GetPath() );
		}
		
		private function LoginPlayer()
		{
			try
			{
				if ( empty( $_POST['email'] ) )
					throw new Exception("Email cannot be empty");
				else if ( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) )
					throw new Exception("Email is invalid");
				else if ( empty( $_POST['password'] ) )
					throw new Exception("Password cannot be empty");
				
				$player = new Player();
				$player->Login( $_POST['email'], $_POST['password'] );
				
				$_SESSION['player'] = $player->Get('id');
				CommonLib::DisplayMessage( "Login was successfull", 1 );
				CommonLib::Redirect( ROOT_DIR . "/lobby/" );
			}
			catch ( Exception $e )
			{
				CommonLib::DisplayMessage( $e->GetMessage() );
			}
			
			CommonLib::Redirect( $this->GetPath() );
		}
		
		private function LogoutPlayer()
		{
			if ( !empty( $_SESSION['player'] ) )
				unset( $_SESSION['player'] );
			
			CommonLib::DisplayMessage( "Player was signed off successfully", 1 );
			CommonLib::Redirect( $this->GetPath() );
		}
	}
?>