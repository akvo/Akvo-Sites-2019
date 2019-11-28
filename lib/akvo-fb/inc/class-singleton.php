<?php

class SINGLETON{
	
	private static $instance = null;
	
	// SINGLETON DESIGN PATTERN - NEEDS TO BE IMPLEMENTED IN EACH CHILD
	public static function getInstance(){
		
		if( self::$instance == null ){
			self::$instance = array();
		}
		
		$class = get_called_class();
		
		if( !isset( self::$instance[ $class ] ) ){
            // new $class() will work too
            self::$instance[ $class ] = new static();
        }
		
		return self::$instance[ $class ];
	}
	
	
}