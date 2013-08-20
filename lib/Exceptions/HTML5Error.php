<?php

	namespace HTML5\Exceptions;
	
	/**
	*  Errors with using the HTML5 interface
	*  @author Matt Moore <matt@cloudkid.com>
	*/
	class HTML5Error extends \Exception
	{
		/** The database connection failed */
	 	const EMPTY_ATTRIBUTE_NAME = 500;
	
		/** The alias for a database is invalid */
		const EMPTY_ATTRIBUTE_VALUE = 501;
		
		/** The database name we're trying to switch to is invalid */
		const INVALID_SETTER = 502;
		
		/** The mysql where trying to execute was a problem */
		const INVALID_GETTER = 503;
		
		/** The html tag name is invalid */
		const INVALID_TAG = 504;
		
		/** When trying to create a node, the name is empty */
		const EMPTY_NODE_TAG = 505;
		
		/** The parent cannot be empty */
		const EMPTY_PARENT = 506;
		
		/** THe addChildAt is out of bounds */
		const OUT_OF_BOUNDS = 507;
		
		/** The child node is empty */
		const EMPTY_CHILD = 508;
		
		/** The node is not of instance type Node */
		const INVALID_NODE = 509;
		
		/**
		*   Look-up for error messages
		*/
		private static $messages = array(
			self::EMPTY_ATTRIBUTE_NAME => 'Attribute names cannot be empty',
			self::EMPTY_ATTRIBUTE_VALUE => 'Attribute values cannot be empty',
			self::INVALID_SETTER => 'Cannot set the property because name is invalid',
			self::INVALID_GETTER => 'Cannot get the property because name is invalid',
			self::INVALID_TAG => 'Not a valid HTML5 tag name',
			self::EMPTY_NODE_TAG => 'Node tag is empty',
			self::EMPTY_PARENT => 'The parent cannot be empty',
			self::OUT_OF_BOUNDS => 'The index is out of bounds',
			self::EMPTY_CHILD => 'Cannot addChild an empty child node',
			self::INVALID_NODE => 'Child node must be a valid tag'
		);
		
		/** The label for an error that is unknown or unfound in messages */
		const UNKNOWN = 'Unknown error';
		
		/**
		*  Create the html5 error
		*  @param the code of the error
		*  @param optional extra data
		*/
		public function __construct($code, $data='')
		{
			$message = (isset(self::$messages[$code]) ? self::$messages[$code]: self::UNKNOWN)
				. ($data ? ' : ' . $data : $data);	
			parent::__construct($message, $code);
		}
	}

?>