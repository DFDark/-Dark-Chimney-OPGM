<?php
	/* Important Libraries */
	require("/classes/database.class.php");
	
	/* Action Constants */
	define( "ACTION_REGISTER_PLAYER", 1 );
	define( "ACTION_LOGIN_PLAYER", 2 );
	//define( "ACTION__", 3 );
	//define( "ACTION__", 4 );
	define( "ACTION_MOVE_ARMY", 5 );
	define( "ACTION_MOVE_BUILDER", 6 );
	define( "ACTION_BUILD_AGGLOMERATION", 7 );
	define( "ACTION_BUILD_HOUSE", 8 );
	define( "ACTION_BUILD_MINE", 9 );
	//define( "ACTION__", 3 );
	
	/* Table Constants */
	define( "TABLE_PLAYERS", "players" );
?>