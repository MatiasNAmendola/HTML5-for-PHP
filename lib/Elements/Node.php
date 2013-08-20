<?php
	
	namespace HTML5\Elements;
	
	/**
	*  A generic html tag w/o children
	*  @author Matt Moore <matt@cloudkid.com>
	*/
	class Node extends HTML5
	{
		/** The string name of the tag */
		protected $_tag;
		
		/** The array of attributes */
		protected $_attributes;
		
		/** The parent node, if any */
		protected $_parent;
		
		/** The collection of valid attributes for given tag */
		protected $_validAttrs;
		
		/** The default valid attributes */
		const GLOBAL_ATTRS = 'accesskey,class,contenteditable,contextmenu,dir,draggable,dropzone,hidden,id,lang,spellcheck,style,tabindex,title,translate';
		
		/**
		 * This Node constructor can only be called from
		 * classes that extend Node.
		 */
		public function __construct($tag = null, $attributes = null, $validAttrs = null) 
		{
			if ($this->isEmpty($tag))
			{
				throw new HTML5Error(HTML5Error::EMPTY_NODE_TAG);
			}
			$this->_parent = null;
			$this->_tag = $tag;
			$this->_attributes = array();
			
			$validAttrs = is_string($validAttrs) ? explode(',', $validAttrs) : $validAttrs;
			$this->_validAttrs = explode(',', self::GLOBAL_ATTRS);
			
			if ($validAttrs !== null)
			{
				$this->_validAttrs  = array_merge($this->_validAttrs, $validAttrs);
			}
			
			if ($attributes !== null)
			{
				if (is_string($attributes))
				{
					$attributes = Attribute::shorthand($attributes);
				}
				
				if (is_array($attributes))
				{
					$this->setAttributes($attributes);
				}
			}
		}
		
		/**
		* Returns the parent node of this node, if
		* a parent exists.  If no parent exists,
		* this function returns null.
		*/
		private function getParent()
		{
			return $this->_parent;
		}
		
		/**
		 * Sets the parent of this Node.  Note that this
		 * function is protected and can only be called by
		 * classes that extend Node.  The parent cannot
		 * be null; this function will throw an Exception
		 * if the parent node is empty.
		 */
		protected function setParent($parent = null) 
		{
			if ($this->isEmpty($parent))
			{
				throw new HTML5Error(HTML5Error::EMPTY_PARENT);
			}
			$this->_parent = $parent;
		}
		
		/**
		 * Given a name and value pair, sets an attribute on this Node.
		 * The name and value cannot be empty; if so, this function
		 * will throw an Exception.  Note if the attribute already exists
		 * and the caller wants to set an attribute of the same name,
		 * this function will not create a new Attribute, but rather
		 * update the value of the existing named attribute.
		 */
		public function setAttribute($name = null, $value = null)
		{			
			if ($this->isEmpty($name))
			{
				throw new HTML5Error(HTML5Error::EMPTY_ATTRIBUTE_NAME);
			}
			foreach($this->_attributes as $i=>$attribute) 
			{
				if ($attribute->name === $name)
				{
					if (!$this->isEmpty($value))
						$attribute->value = $value;
					else
						unset($this->_attributes[$i]);
					return;
				}
			}
			$this->_attributes[] = new Attribute($name, $value);
			return $this;
		}
		
		/**
		* Fetch and attribute by name from this Node.  The attribute
		* name cannot be null; if so, this function will throw an
		* Exception.
		*/
		protected function getAttribute($name = null) 
		{
			$returnAttr = null;

			if ($this->isEmpty($name))
			{
				throw new HTML5Error(HTML5Error::EMPTY_ATTRIBUTE_NAME);
			}
			foreach($this->_attributes as $attribute) 
			{
				if ($attribute->name === $name)
				{
					$returnAttr = $attribute->value;
					break;
				}
			}
			return $returnAttr;
		}
		
		/**
		*  Set the list of all attributes
		*  @param An attributes array(name=>value, name=>value)
		*/
		public function setAttributes($values)
		{
			if (is_array($values))
			{
				foreach($values as $name=>$value)
				{
					$this->setAttribute($name, $value);
				}
				return $this;
			}
		}
		
		/**
		*  Set the data attribute
		*  @param The name of the data, for instance "id" is an attribute "data-id"
		*  @param The value of the attribute
		*  @return The instance of this node
		*/
		public function setData($name, $value)
		{
			return $this->setAttribute('data-'.$name, $value);	
		}
		
		/**
		*  Add this child to a node container at the end
		*  @param The node container to add to
		*/
		public function appendTo(NodeContainer $container)
		{
			$container->addChild($this);
		}
		
		/**
		*  Add this child to the beginning of a node container
		*  @param The node container to prepend to to
		*/
		public function prependTo(NodeContainer $container)
		{
			$container->addChildAt($this, 0);
		}
		
		/**
		*  Get the data value
		*  @param The name of the data attribute
		*  @return The value of the data
		*/
		public function getData($name)
		{
			return $this->getAttribute('data-'.$name);	
		}
		
		/**
		*  Write the HTML
		*/
		public function __toString() 
		{
			return $this->writeOpen();
		}
		
		/**
		*  Start the writing
		*/
		protected function writeOpen() 
		{
			$buffer = "<";
			$buffer .= $this->_tag;
			foreach($this->_attributes as $attribute) 
			{
				$buffer .= (string)$attribute; 
			}
			$buffer .= ">";
			return $buffer;
		}
		
		/**
		*  Close the writing
		*/
		protected function writeClose() 
		{
			return "</" . $this->_tag . ">";
		}
		
		/**
		*  General purpose getter
		*  @param The name of the property
		*/
		public function __get($name) 
		{
			if (in_array($name, $this->_validAttrs) || strpos($name, 'data-') === 0)
			{
				return $this->getAttribute($name);
			}
			return parent::__get($name);
		}

		/**
		*  General purpose setter
		*  @param The name of the property
		*  @param The value
		*/
		public function __set($name, $value) 
		{
			if (in_array($name, $this->_validAttrs) || strpos($name, 'data-') === 0)
			{
				return $this->setAttribute($name, $value);
			}
			return parent::__set($name);
		}

		/**
		*  See if a property exists
		*  @param The name of the property
		*/
		public function __isset($name)
		{
			return in_array($name, $this->_validAttrs) || parent::__isset($name);
		}
	}

?>