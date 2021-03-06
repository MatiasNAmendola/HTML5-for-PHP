<?php
	
namespace HTML5\Components
{
	use HTML5\Elements\NodeContainer;
	
	/**
	*  Special node type representing an html comment
	*  @author Matt Moore <matt@cloudkid.com>
	*/
	class Comment extends NodeContainer 
	{
		public function __construct($text)
		{
			parent::__construct($text);
		}
		
		public function __toString()
		{
			return '<!-- '.$this->_tag.' -->';
		}
	}
}

?>