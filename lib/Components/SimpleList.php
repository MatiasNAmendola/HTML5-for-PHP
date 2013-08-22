<?php
	
namespace HTML5\Components
{	
	use HTML5\Elements\NodeContainer;
	
	/**
	*  Create a order or un-ordered list
	*  @author Matt Moore <matt@cloudkid.com>
	*/
	class SimpleList extends NodeContainer
	{
		/**
		*  Create a simple list of html elements
		*  @param The array of children elements
		*  @param The optional attributes
		*  @param The type of list, either ul or ol (defaults to ul)
		*/
		public function __construct($elements, $attributes=null, $type='ul')
		{
			parent::__construct($type, null, $attributes, 
				$type == 'ol' ? 'reversed,start,type' : null);
			
			assert(is_array($elements));
			
			foreach($elements as $child)
			{
				$this->addChild(html('li', $child));
			}
		}
	}
}

?>