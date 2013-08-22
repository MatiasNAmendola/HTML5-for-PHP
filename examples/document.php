<?php

	include '../lib/html.php';
	
	use HTML5\Components\Document;
	use HTML5\Components\SimpleList;
	use HTML5\Components\Table;
	
	// Create a new document
	$doc = new Document('Test Document');
	
	// Add a link to the page
	$link = html('a#google.external rel=external', 'Link', 'class="test something" target=blank rel=test');
	$link->href = 'http://google.com';
	$link->appendTo($doc->body);
	
	// Create an unordered list for an array of items
	// the array can be other html elements or text
	$list = new SimpleList(
		array(
			html('b', 'first'),
			'second', 
			'third'
		)
	);
	$list->appendTo($doc->body);
	
	// Create a sample table with some rows of dummy data
	$table = new Table(
		array(
			array('id'=>1, 'first'=>'James', 'last'=>'Smith'),
			array('id'=>2, 'first'=>'Mary', 'last'=>'Denver'),
			array('id'=>3, 'first'=>'Charlie', 'last'=>'Rose')
		),
		array('ID', 'First Name', 'Last Name')
	);
	
	// We'll set some of the table properties
	$table->style = 'border:1px solid black';
	$table->border = 0;
	$table->id = 'people';
	$table->appendTo($doc->body);
		
	// Output the result formatted nice with indents
	echo HTML5\Elements\HTML5::format($doc);

?>