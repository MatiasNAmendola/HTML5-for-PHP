<?php
	
	namespace HTML5\Components;
	
	use HTML5\Elements\NodeContainer;
	
	/**
	*  Convenience class for building a Table using the HTML5Builder
	*  @author Matt Moore <matt@cloudkid.com>
	*/
	class Table extends NodeContainer
	{		
		/**
		*  Build the table and return the table object
		*  @param The data (associative array)
		*  @param An optional collection of header labels for each value
		*  @param If we should add a checkbox to each row, this is the name 
		*         of the attribute to use a value
		*/
		public function __construct($data, $headers=null, $checkbox=null)
		{
			parent::__construct('table', null, null, 'border');
			
			if ($headers != null && is_array($headers))
			{
				$head = html('thead');
				$this->addChild($head);
				
				$row = html('tr');
				
				if ($checkbox != null)
				{
					$row->addChild(html('th', html('span', $checkbox)));
				}
				
				foreach($headers as $header)
				{
					$row->addChild(html('th', $header));
				}
				$head->addChild($row);
			}
			
			$body = html('tbody');
			
			foreach($data as $d)
			{
				$row = html('tr');
				
				if ($checkbox != null)
				{
					$td = html('td', 
						html(
							'input', 
							'type=checkbox name='.$checkbox.'[] value='.$d[$checkbox]
						),
						'class='.$checkbox
					);
					$row->addChild($td);
				}
				foreach($d as $name=>$value)
				{
					if ($name == $checkbox) continue;
					$td = html('td', $value, 'class='.$name);
					$row->addChild($td);
				}
				$body->addChild($row);
			}
			$this->addChild($body);
		}
	}

?>