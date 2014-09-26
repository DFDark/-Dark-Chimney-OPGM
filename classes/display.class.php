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
					<link rel='alternate' type='application/rss+xml' title='Ostrakon Feed'  href='feed.php'  />
					<link href='favicon.ico' rel='shortcut icon' type='image/x-icon' />
					<script type='text/javascript' src='" . ROOT_DIR . "/javascript/jquery.js'></script>
					<script type='text/javascript' src='" . ROOT_DIR . "/javascript/functions.js'></script>
					<script type='text/javascript' src='" . ROOT_DIR . "/javascript/map.js'></script>";
			
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
							case "lobby"					: $this->RenderLobby();				break;
							case "login-form"				: $this->RenderLogin();				break;
							case "register"					: $this->RenderRegistration();		break;
							default							: $this->RenderError404();			break;
						}
					echo "</div>";
				echo "</div>";
				echo "<div class='clear' ></div>";
			echo "</div>";
			echo "<div class='system_messages' id='system_messages' ></div>";
			
			if ( isset( $_SESSION['system_messages'] ) )
			{
				echo "<script>
						$(document).ready( SystemMessages(" . json_encode( $_SESSION['system_messages'] ) . ") );
				</script>";
				unset( $_SESSION['system_messages'] );
			}
		}
		
		private function RenderError403()
		{
			echo "Access Forbidden";
		}
		
		private function RenderError404()
		{
			echo "<div>
					Page not found
				</div>";
		}
		
		private function RenderHeader()
		{
			echo "<div id='banner' >";
			
			if ( !is_null($this->player) )
			{
				echo "<div>
						<form action='" . ROOT_DIR . "/' method='post' >
							<input type='hidden' name='vrfctn' />
							<input type='hidden' name='type' value='3' />
							<input type='submit' value='Log off' />
						</form>
					</div>";
			}
			
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
			$nickname	= "";
			if ( !empty( $_POST['nickname'] ) )
				$nickname	= $_POST['nickname'];
			
			$email		= "";
			if ( !empty( $_POST['email'] ) )
				$email	= $_POST['email'];
			
		
			echo "<div>
					<form action='" . ROOT_DIR . "/{$this->content}/' method='post' >
						<input type='hidden' name='vrfctn' />
						<input type='hidden' name='type' value='1' />
						<table>
							<tr>
								<td><label for='nickname' >Nickname: </label></td>
								<td><input type='text' id='nickname' name='nickname' placeholder='Nickname' value='{$nickname}' /></td>
							</tr>
							<tr>
								<td><label for='email' >Email: </label></td>
								<td><input type='text' id='email' name='email' placeholder='Email' value='{$email}' /></td>
							</tr>
							<tr>
								<td><label for='email' >Email again: </label></td>
								<td><input type='text' id='email_verification' name='email_verification' placeholder='Email' value='{$email}' /></td>
							</tr>
							<tr>
								<td><label for='password' >Password: </label></td>
								<td><input type='password' id='password' name='password' placeholder='Password' /></td>
							</tr>
							<tr>
								<td><label for='password' >Password again: </label></td>
								<td><input type='password' id='password_verification' name='password_verification' placeholder='Password' /></td>
							</tr>
							<tr>
								<td colspan='2' style='text-align: center;' ><input type='submit' value='submit' /></td>
							</tr>
						</table>
					</form>";
		}
		
		private function RenderLobby()
		{
			echo "Lobby";
		}
		
		private function RenderLogin()
		{
			$email	= "";
			if ( !empty($_POST['email']) )
				$email = $_POST['email'];
			
			echo "<div>dfsdfs
					<form action='" . ROOT_DIR . "/login-form/' method='post' >
						<input type='hidden' name='vrfctn' />
						<input type='hidden' name='type' value='2' />
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
								<td colspan='2'><input type='submit' value='Login' /></td>
							</tr>
						</table>
					</form>
					<a href='" . ROOT_DIR . "/register/' >Not registered yet? Register here!</a>
					<a href='" . ROOT_DIR . "/forgotten-password/' >Forgot password?</a>
				</div>";
		}
	}
?>