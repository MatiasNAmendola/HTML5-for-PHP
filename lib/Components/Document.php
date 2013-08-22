<?php
	
namespace HTML5\Components
{	
	use HTML5\Elements\NodeContainer;
	
	/**
	*  Create an HTML document
	*  @author Matt Moore <matt@cloudkid.com>
	*/
	class Document extends NodeContainer
	{
		/** The document type */
		private $docType;

		/** The head node */
		public $head;
		
		/** The body node */
		public $body;
		
		/** The title node */
		public $title;
		
		/**
		*  Create a new html5 document
		*/
		public function __construct($title='', $charset='utf-8')
		{
			parent::__construct('html', null, null, 'manifest');
			
			$this->docType = html('doctype');
			$this->head = html('head');
			$this->body = html('body');
			$this->title = html('title', $title);
			
			$this->head->addChild(html('meta', 'charset='.$charset));
			$this->head->addChild($this->title);
			
			$this->addChild($this->head);
			$this->addChild($this->body);
		}
		
		/**
		*  Represent the document
		*/
		public function __toString()
		{
			return $this->docType . parent::__toString();		
		}
	}
}

?>