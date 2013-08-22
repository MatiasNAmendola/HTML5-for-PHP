<?php	
	
	/**
	*  To use the library, simply include this file
	*  takes care of the autoloading of classes
	*  and create a root-level function called html()
	*  @author Matt Moore <matt@cloudkid.com>
	*  @version 1.0.0
	*/
	
	/**
	*  Auto load the assets in this library
	*  @param The class name to autoload
	*/
	spl_autoload_register(function($name)
	{
		// Ignore class names not in the HTML5 namespace
		if (!preg_match('/^HTML5\\\/', $name)) return;
		
		// Remove the HTML5 namespace
		$name = preg_replace('/^HTML5\\\/', '', $name);
		
		// Convert the rest to directories
		$name = str_replace("\\", '/', $name);
		
		// Include the class relative to here
		include dirname(__FILE__).'/'.$name.'.php';
	});
	
	/**
	*  Convenience function for building dynamic HTML
	*  @param The name of the tag as a string for example 'tr', 'table', etc
	*  @param If the tag is a NodeContainer, this can be an array of attributes, 
	*         another html node or some text. If the tag is a single node, this 
	*         can be an array or chain of attributes
	*  @param The attributes list for container tags (e.g., 'class:selected')
	*  @return Return the html node
	*/
	function html($tag, $childrenOrAttributes=null, $attributes=null)
	{
		return HTML5\Elements\HTML5::build($tag, $childrenOrAttributes, $attributes);
	}

?>