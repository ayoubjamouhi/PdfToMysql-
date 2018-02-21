<?php

namespace App\Core;


class App

{

	protected static $regstry = [];

	public static function bind($key,$value)
		
	{
			
		static::$regstry[$key] = $value;		
	}

	public static function get($key)
		
		{
			
			if(!array_key_exists($key, static::$regstry))
			
			{

				throw new Exception("key non exist");
				
			}
			return static::$regstry[$key];
		}	
}