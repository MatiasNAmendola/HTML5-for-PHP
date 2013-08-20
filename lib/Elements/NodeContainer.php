<?php

	namespace HTML5\Elements;
	
	use HTML5\Exceptions\HTML5Error;
	
	/**
	*  Represents an HTML that that can contain other tags <b><p><div>
	*  @author Matt Moore <matt@cloudkid.com>
	*/
	class NodeContainer extends Node 
	{
		/** The collection of children nodes */
		private $_children;

		/**
		 * Create a new Node Container with the given tag.  The
		 * tag cannot be null.
		 */
		public function __construct($tag = null, $children = null, $attributes = null, $validAttrs=null)
		{
			if ($this->isEmpty($tag))
			{
				throw new HTML5Error(HTML5Error::EMPTY_NODE_TAG);
			}
			parent::__construct($tag, $attributes, $validAttrs);
			
			$this->_children = array();
			
			if (!$this->isEmpty($children))
			{
				if (!is_array($children))
				{
					$children = array($children);
				}
				if (is_array($children))
				{
					foreach($children as $child)
					{
						$this->addChild($child);
					}
				}
			}
		}

		/**
		 * Add's a child to this FertileNode.  The child to
		 * add cannot be null.
		 */	
		public function addChild($childNode)
		{
			array_push($this->_children, $this->prepareChild($childNode));
			return $this;
		}
		
		/**
		*  Add a child at a specific index
		*  @param The child node to add
		*  @param The index number
		*/
		public function addChildAt($childNode, $index)
		{
			if ($index < 0)
			{
				throw new HTML5Error(HTML5Error::OUT_OF_BOUNDS, $index);
			}
			$childNode = $this->prepareChild($childNode);
			if ($index == 0)
			{
				array_unshift($this->_children, $childNode);
			}
			else if ($index > $len)
			{
				$this->addChild($childNode);
			}
			else
			{
				array_splice($this->_children, $index , 0, array($childNode)); 
			}
			return $this;
		}
		
		/**
		*  Before adding a child, we should do some checking
		*  @param The child node to add (can also be a string, number or boolean)
		*/
		private function prepareChild($childNode)
		{
			if ($this->isEmpty($childNode))
			{
				throw new HTML5Error(HTML5Error::EMPTY_CHILD);
			}
			if (is_bool($childNode))
			{
				$childNode = new Text($childNode ? 'true' : 'false');
			}
			else if (is_string($childNode) || is_numeric($childNode))
			{
				$childNode = new Text($childNode);
			}
			if (!($childNode instanceof Node))
			{
				throw new HTML5Error(HTML5Error::INVALID_NODE);
			}
			$childNode->setParent($this);
			return $childNode;
		}

		/**
		*  Removes the first instance of child from this.  
		*  Once the first instance of the child
		*  is removed, this function will return.  It returns
		*  true if a child was removed and false if no child
		*  was removed.
		*  @return Boolean if successfullly remove
		*/
		public function removeChild($childNode = null)
		{
			if ($this->isEmpty($childNode))
			{
				throw new HTML5Error(HTML5Error::EMPTY_CHILD);
			}

			for($i = 0; $i < count($this->_children); $i++)
			{
				$child = $this->_children[$i];
				if ($child === $childNode)
				{
					unset($this->_children[$i]);
					return true;
				}
			}
			return false;
		}
		
		/**
		*  Remove a child as a specific index
		*  @param The index to remove child at 
		*  @return The instance of the node
		*/
		public function removeChildAt($index)
		{
			if ($index >= $this->_children || $index < 0)
			{
				throw new HTML5Error(HTML5Error::OUT_OF_BOUNDS, $index);
			}
			array_splice($this->_children, $index, 1);
			return $this;
		}

		/**
		 * Removes all children attached to this FertileNode.
		 */
		public function removeChildren()
		{
			unset($this->_children);
			$this->_children = array();
		}

		/**
		 * Returns an array of all children attached to
		 * this FertileNode.
		 */
		public function getChildren() 
		{
			return $this->_children;
		}

		/**
		 * Gets a child of this FertileNode at given
		 * index.  If no index is passed in, getChild()
		 * will return the child at index zero (0).
		 */
		public function getChildAt($index = 0)
		{
			return $this->_children[$index];
		}

		/* @Override */
		public function __toString() 
		{
			$buffer = $this->writeOpen();		
			foreach($this->_children as $child)
			{
				$buffer .= $child->__toString();		
			}		
			$buffer .= $this->writeClose();

			return $buffer;
		}
	}

?>