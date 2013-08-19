<?php
	
	/**
	*  Convenience function for building dynamic HTML
	*  @param The name of the tag as a string for example 'tr', 'table', etc
	*  @param If the tag is a NodeContainer, this can be an array of attributes, another html node
	* 		  or some text. If the tag is a single node, this can be an array or chain of attributes
	*  @param The attributes list for container tags (e.g., 'class:selected')
	*  @return Return the html node
	*/
	function html($tag, $childrenOrAttributes=null, $attributes=null)
	{
		return HTML5::build($tag, $childrenOrAttributes, $attributes);
	}

?>