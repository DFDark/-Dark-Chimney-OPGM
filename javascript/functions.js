function SystemMessages( messages )
{
	"use strict";
	
	if ( messages !== undefined && messages !== null )
	{
		var div = document.getElementById('system_messages'),
			message_div,
			i;
		
		if ( div === undefined || div === null )
			return;
		
		for ( i = 0; i < messages.length; i++ )
		{
			message_div = document.createElement('div');
			
			message_div.id = "system_message_" + i;
			message_div.className = "system_message_" + messages[i][1];
			message_div.innerHTML = messages[i][0];
			
			div.appendChild( message_div );
		}
	}
}