function SystemMessages( messages )
{
	"use strict";
	
	if ( messages !== undefined && messages !== null )
	{
		for ( var i = 0; i < messages.length; i++ )
		{
			alert(messages[i][0]);
		}
	}
}