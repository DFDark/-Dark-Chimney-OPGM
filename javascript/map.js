/*******************************************************************
 Copyright (C) 2014 
 TO DO: Description of this class
*******************************************************************/


/*jslint nomen: true, maxlen: 80*/

/**
 * The class representing map object
 *
 * @class MapError
 * @constructor
 *
 * @param {String} message
 */
function MapError(message)
{
	"use strict";

	Error.call(this);
	this.name = "MapError";

	/**
	* An error message.
	*
	* @property message
	* @type {String}
	*/
	this.message = message;
}
MapError.prototype = Object.create(new Error());

/**
 * The class representing map object
 *
 * @class Map
 * @constructor
 *
 * @param {String} map_id
 */
function Map(map_id, map_data)
{
	"use strict";

	if ( map_data === undefined || map_data === null )
		throw new MapError("Map information was not specified");
	
	var wrapper = document.getElementById(map_id);
	
	if ( wrapper === undefined && wrapper === null )
		throw new MapError("Map wrapper not found");
	if ( !map_data.hasOwnProperty("tile_count") )
		throw new MapError("Map tile count was not specified!");

	this.wrapper = wrapper;
	this.TILE_COUNT = map_data.tile_count;
	this.tiles = [[]];
	this.object_list = [];
	
	if ( !map_data.hasOwnProperty("width") )
		throw new MapError("Map width was not specified!");
	if ( !map_data.hasOwnProperty("height") )
		throw new MapError("Map height was not specified!");
	
	// Building HTML5 canvas
	this.canvas = document.createElement('canvas');
	this.canvas.oncontextmenu = function () { return false; };
	this.canvas.width = map_data.width;
	this.canvas.height = map_data.height;
	this.wrapper.appendChild( this.canvas );
	
	this.ctx = this.canvas.getContext('2d');
}

(function(ctx)
{
	"use strict";

	/**
	* Redraws map and it's objects with respect to current position and status
	*
	* @method Redraw
	*/
	ctx.Redraw = function()
	{
		if ( this.object_list !== undefined &&
			 this.object_list.length > 0 )
		{
			for ( var i = 0; i < this.object_list.length; i++ )
			{
				if ( this.object_list[i].hasOwnProperty("Redraw") )
					this.object_list[i].Redraw();
			}
		}
	}
	
	/**
	* Adds object to be displayed on map
	*
	* @method AddObject
	* @param {---} object
	*/
	ctx.AddObject = function(object)
	{
		if ( this.object_list === undefined )
			this.object_list = [];
		
		this.object_list.push(object);
	}
	
	/**
	* Removes object from map's objects
	*
	* @method RemoveObject
	* @param {---} object
	*/
	ctx.RemoveObject = function(object)
	{
		if ( this.object_list !== undefined &&
			 this.object_list.length > 0 )
		{
			for ( var i = 0; i < this.object_list.length; i++ )
			{
				// To do:
				// comparison of objects and removal of selected object
			}
		}
	}
	
	/**
	* Returns current position of map center
	*
	* @method GetPosition
	* @return {Position}
	*/
	ctx.GetPosition = function()
	{
		if ( this.position !== undefined && this.position !== null )
			return this.position;
		
		return false;
	}
	
	/**
	* Sets current position of map center
	*
	* @method SetPosition
	* @param {Position} position
	*/
	ctx.SetPosition = function(position)
	{
		if ( this.position !== undefined && this.position !== null )
			this.position = position;
	}
	
	/**
	* Sets current position of map center by x,y coordinates
	*
	* @method SetPositionByCoords
	* @param {Int} x
	* @param {Int} y
	*/
	ctx.SetPositionByCoords = function(_x, _y)
	{
		if ( _x !== undefined && !_x.isNaN() &&
			 _y !== undefined && !_y.isNaN() )
		{
			this.position = { x : _x, y : _y };
		}
	}
	
	/**
	* Moves center of the map by given offsets and redraws map
	*
	* @method Move
	* @param {Int} x
	* @param {Int} y
	*/
	ctx.Move = function(_x, _y)
	{
		if ( this.position === undefined )
			this.position = { x : 0, y : 0 };
		
		if ( _x.isNaN() || _y.isNaN() )
			throw new MapError("x or y is not a number!");
		
		this.position.x += _x;
		this.position.y += _y;
		
		if ( this.position.x < 0 )
			this.position.x = 0;
		else if ( this.position.x >= this.TILE_COUNT )
			this.position.x = this.TILE_COUNT - 1;
		
		if ( this.position.y < 0 )
			this.position.y = 0;
		else if ( this.position.y >= this.TILE_COUNT )
			this.position.y = this.TILE_COUNT - 1;
		
		this.Redraw();
	}
}(Map.prototype));