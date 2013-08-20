HTML5-for-PHP
=============

Create dynamic, well-formatted HTML5 markup with a simple an intuitive PHP API. This is a fork/rewrite of the [Gagawa](https://code.google.com/p/gagawa/) project. 

Examples
----------

To create an HTML node, simply call the html function, passing in the tag name and then any attributes. This example would work for any closed tag such as **img** or **br**.

```php
echo html('img#home src=home.jpg');
```

Outputs:

```html
<img src="home.jpg" id="home">
```

HTML nodes are objects which you can add properties to dynamically. Only valid HTML5 attributes are acceptable. Invalid attributes will throw an Exception.


```php
$img = html('img');
$img->src = 'home.jpg';
$img->class = 'example';
$img->width = 100;
$img->height = 200;
echo $img;
```

Outputs:

```html
<img src="home.jpg" class="home" width="100" height="200">
```

Create any HTML5 container tags (such as **p**, **span**, or **div**) and you can add child nodes. 

```php
$label = html('span', 'Website!');
$link = html('a.button', $label);
$link->href = 'http://example.com';
echo $link;    
```
Alternatively, use the *addChild* method for any container tag.
```php
$link = html('a.button');
$link->href = 'http://example.com';
$link->addChild(html('span', 'Website!'));
echo $link;    
```
Both examples would outputs:
```html
<a href="http://example.com" class="button"><span>Website!</span></a>
```
