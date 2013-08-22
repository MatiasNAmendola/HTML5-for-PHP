<?php

namespace HTML5\Elements
{	
	/**
	*  Special node representing plain text
	*  @author Matt Moore <matt@cloudkid.com>
	*/
	class Text extends Node 
	{
		public function __construct($text)
		{
			parent::__construct($text);
		}
		
		public function __toString()
		{
			return $this->_tag;
		}
	}
}

?>