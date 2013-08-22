<?php
	
namespace HTML5\Elements
{		
	/**
	*  An HTML attribute used on the node
	*  @author Matt Moore <matt@cloudkid.com>
	*/
	class Attribute extends HTML5
	{
		/** The name of the attribute */
		private $_name;
		
		/** The value of the attribute */
		private $_value;

		/**
		*  Create a new attribute
		*  @param The name of the attribute
		*  @param The value of the attribute
		*/
		public function __construct($name = null, $value = null) 
		{
			$this->name = $name;
			$this->value = $value;
		}

		/**
		*  Convert the attribute to an HTML tag attribute string
		*  @return String representation of attribute
		*/
		public function __toString() 
		{
			return " " . $this->_name . "=\"" . $this->_value . "\"";
		}

		/**
		*  Get the name of this attribute
		*  @return The attribute's name
		*/
		public function getName() 
		{
			return $this->_name;
		}

		/**
		*  Set the name of this attribute, cannot be empty
		*  @param The name of the value
		*/
		public function setName($name = null)
		{
			if ($this->isEmpty($name))
			{
				throw new HTML5Error(HTML5Error::EMPTY_ATTRIBUTE_NAME);
			}
			$this->_name = $name;
		}
		
		/**
		*  Get the value of this attribute
		*  @return The value of attribute
		*/
		protected function getValue() 
		{
			return $this->_value;
		}

		/**
		*  Set the value of this attribute, this cannot be empty
		*  @param The value to set
		*/
		protected function setValue($value) 
		{
			$this->_value = $value;
		}
		
		/**
		*  Convert a string into an associative array
		*  @param The string, delineated by semicolons, and colons for attributes:values
		*  @return The array of properties or attributes
		*/
		static public function shorthand($str)
		{
			$res = array();
			
			// Match the name=value in the attributes string
			preg_match_all('/([a-z]+[a-z\-]*)\=("[^\"]*"|\'[^\']*\'|[^\s\"\']*)/',$str, $arr);
			
			foreach($arr[1] as $i=>$name)
			{
				$value = $arr[2][$i];
				
				// Remove containing quotes if present
				if (preg_match('/^[\'\"][^\n]*[\'\"]$/', $value))
				{
					$value = substr($value, 1, -1);
				}
				$res[$name] = $value;
			}
			return $res;
		}
		
		/**
		*  General purpose getter
		*  @param The name of the property
		*/
		public function __get($name) 
		{
			if (method_exists($this , $method =('get' . ucfirst($name))))
				return $this->$method();
			else
				throw new HTML5Error(HTML5Error::INVALID_GETTER, $name);
		}

		/**
		*  General purpose setter
		*  @param The name of the property
		*  @param The value
		*/
		public function __set($name, $value) 
		{
			if (method_exists($this , $method =('set' . ucfirst($name))))
				return $this->$method($value);
			else
				throw new HTML5Error(HTML5Error::INVALID_SETTER, $name);
		}

		/**
		*  See if a property exists
		*  @param The name of the property
		*/
		public function __isset($name)
		{
			return method_exists($this , 'get' . ucfirst($name)) 
				|| method_exists($this , 'set' . ucfirst($name));
		}
	}
}

?>