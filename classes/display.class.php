<?php
	/**
	* Display
	*
	* @author   Hamid Khairy <hamidkhairy@seznam.cz>
	* @version  $Revision: 1.0.0.0 $
	* @access   public
	*/
	class Display
	{
		public	$content		= "";
		public	$subcontent		= "";
		public	$page			= 0;
		private	$player			= null;
		private	$administrator	= false;
		
		public function __construct()
		{
			if ( !empty($_SESSION['player']) && is_numeric($_SESSION['player']) )
				$this->player = new Player( $_SESSION['player'] );
		}
		
		public function Render()
		{
			echo "<!DOCTYPE html>
				 <html>";
					$this->RenderHead();
					$this->RenderBody();
			echo "</html>";
		}
		
		private function RenderHead( )
		{
			echo "<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
					<meta name='description' content='' />
					<meta name='keywords' content='' />
					<meta name='robots' content='' />
					<meta name='author' content='Hamid \"Dark\" Khairy' />
					<title>Fantasy Wars</title>
					<link rel='stylesheet' type='text/css' href='" . ROOT_DIR . "/css/stylesheet.css' />
					<!--link rel='stylesheet' type='text/css' href='/" . ROOT_DIR . "/css/style.css' />
					<link rel='alternate' type='application/rss+xml' title='Ostrakon Feed'  href='" . ROOT_DIR . "/feed.php'  />
					<link href='/" . ROOT_DIR . "/favicon.ico' rel='shortcut icon' type='image/x-icon' />
					<script type='text/javascript' src='/" . ROOT_DIR . "/javascript/jquery.js'></script-->";
			
			echo "</head>";
		}
		
		private function RenderBody( )
		{
			echo "<body>
					<div>";
						$this->RenderHeader();
						$this->RenderContent();
						$this->RenderFooter();
			echo 	"</div>
				</body>";
		}
		
		private function RenderContent()
		{
			if ( empty( $this->content ) )
			{
				if ( !is_null($this->player) )
					$this->content = "lobby";
				else
					$this->content = "login-form";
			}
			
			echo "<div>";
				echo "<div id='wrapper' >";
					$this->RenderRightColumn();
					echo "<div id='content' >";
						switch( $this->content )
						{
							case "lobby"					: $this->RenderNews();				break;
							case "login-form"				: $this->RenderLogin();				break;
							case "registration-form"		: $this->RenderRegistration();		break;
							default							: $this->RenderError404();			break;
						}
					echo "</div>";
				echo "</div>";
				echo "<div class='clear' ></div>";
			echo "</div>";
			echo "<div class='system_message' id='system_message' ></div>";
			
			if ( isset( $_SESSION['system_message'] ) )
			{
				echo "<script>
						$(document).ready( DisplayMessage('{$_SESSION['system_message'][0]}'," . ( $_SESSION['system_message'][1] ? "true" : "false" ) . ") );
				</script>";
				unset( $_SESSION['system_message'] );
			}
		}
		
		private function RenderError403()
		{
			echo "Access Forbidden";
		}
		
		private function RenderError404()
		{
			echo "<div>
					sdf
				</div>";
		}
		
		private function RenderHeader()
		{
			echo "<div id='banner' >";
			
			echo "</div>";
			$this->RenderMainMenu();
		}
		
		private function RenderMainMenu()
		{
			echo "<div id='main_menu' >
					<table>
						<tr>
							<td><a href='" . ROOT_DIR . "/' title='home' >Home</a></td>
						</tr>
					</table>
				</div>";
		}
		
		private function RenderFooter()
		{
			echo "<div id='footer' >
					<div id='footer_wrap' >
						footer
					</div>
				</div>";
		}
		
		private function RenderRightColumn()
		{
		}
		
		private function RenderRegistration()
		{
			if (!empty($_POST))
			{
				try 
				{
					$player = new Player();//$_POST['username'], $_POST['password'] );
					$player->Set('nickname', "DFDark" );
					$player->CreatePasswordHash("hentai");
					$player->Save();
				}
				catch ( Exception $e )
				{
					echo $e->GetMessage();
				}
			}
			
			echo "<div>
					<form action='" . ROOT_DIR . "/registration-form/' method='post' >
						<input type='hidden' name='vrfctn' />
						<input type='hidden' name='type' value='1' />
						<table>
							<tr>
								<td><label for='username' >Username: </label></td>
								<td><input type='text' id='username' name='username' placeholder='Username' /></td>
							</tr>
							<tr>
								<td><label for='email' >Email: </label></td>
								<td><input type='text' id='email' name='email' placeholder='Email' /></td>
							</tr>
							<tr>
								<td><label for='password' >Username: </label></td>
								<td><input type='password' id='password' name='password' placeholder='Password' /></td>
							</tr>
							<tr>
								<td colspan='2' style='text-align: center;' ><input type='submit' value='submit' /></td>
							</tr>
						</table>
					</form>";
		}
		
		private function RenderNews()
		{
			echo "<a href='" . ROOT_DIR . "/registration-form/' >Register Here!</a>";
		}
		
		private function RenderLogin()
		{
			$email	= "";
			if ( !empty($_POST['email']) )
				$email = $_POST['email'];
			
			echo "<div>
					<form action='" . ROOT_DIR . "/login-form/' method='post' >
						<input type='hidden' name='vrfctn' />
						<input type='hidden' name='operation' value='2' />
						<table>
							<tr>
								<td><label>Email:</label></td>
								<td><input type='text' name='email' value='{$email}' placeholder='Email' /></td>
							</tr>
							<tr>
								<td><label>Password:</label></td>
								<td><input type='password' name='password' placeholder='Password' /></td>
							</tr>
							<tr>
								<td colspan=2><input type='submit' value='Login' /></td>
							</tr>
						</table>
					</form>
				</div>";
		}
	}
?>