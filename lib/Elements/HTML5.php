<?php

namespace HTML5\Elements
{	
	use HTML5\Exceptions\HTML5Error;
	use \SimpleXMLElement;
	
	/**
	*  The HTML5 Builder is used for building HTML5 markup dynamically
	*  this is a modified and completed version of gagawa
	*  @author Matt Moore <matt@cloudkid.com>
	*  @version 1.0.0
	*/
	abstract class HTML5 
	{		
		/**
		*  This is the function for building dynamic HTML
		*  @param The name of the tag as a string for example 'tr', 'table', can be followed 
		*		 by CSS selector, e.g. 'a#backButton' or 'a.button'
		*  @param If the tag is a NodeContainer, this can be an array of attributes, another html node
		* 		  or some text. If the tag is a single node, this can be an array or chain of attributes
		*  @param The attributes list for container tags (e.g., 'class:selected')
		*  @return Return the html node
		*/
		public static function build($tag, $childrenOrAttributes=null, $attributes=null)
		{
			// Get the tag ID from the tag string
			// for instance 'a.button rel=external', a.button is the tagId, the rest are the attributes
			$endPos = strpos(trim($tag), ' ');
			
			// The tag attributes
			$tagAttributes = array();
			
			// If the tag also has some attributes
			if ($endPos !== false)
			{
				$tagOriginal = $tag;
				$tag = substr($tag, 0, $endPos);
				$tagAttributes = Attribute::shorthand(substr($tagOriginal, $endPos + 1));
			}
			
			// Match the tag name without the CSS selectors
			preg_match('/^([a-z1-6]{1,10})(.*)/', $tag, $tagParts);
			
			// Valid class ane id names must begin with a -, _, or a-z letter
			preg_match_all('/(\.|\#)\-?[\_a-zA-Z]+[\_a-zA-Z0-9\-]*/', $tagParts[2], $selectors);
			
			$s = false; // if the html is a single tag like <br>
			$tag = strtolower($tagParts[1]); // the name of the tag
			$a = ''; // Valid extra attributes for tags
			switch($tag)
			{
				case 'a':			$a = 'href,hreflang,media,rel,target,type'; break;
				case 'abbr':		break;
				case 'address':		break;
				case 'area':		$s = true; $a = 'alt,coords,href,hreflang,media,rel,shape,target,type'; break;
				case 'article':		break;
				case 'aside':		break;
				case 'audio':		$a = 'autoplay,controls,loop,muted,preload,src'; break;
				case 'b':			break;
				case 'base':		$s = true; $a = 'href,target'; break;
				case 'bdo':			break;
				case 'blockquote':	$a = 'cite'; break;
				case 'body':		break;
				case 'br':			$s = true; break;
				case 'button':		$a = 'autofocus,disabled,form,formaction,formenctype,formmethod,formnovalidate,formtarget,name,type,value'; break;
				case 'canvas':		$a = 'height,width'; break;
				case 'caption':		break;
				case 'cite':		break;
				case 'code':		break;
				case 'col':			$s = true; break;
				case 'colgroup':	$a = 'span'; break;
				case 'command':		$s = true; $a = 'checked,disabled,icon,label,radiogroup,type'; break;
				case 'comment':		return new Comment($childrenOrAttributes);
				case 'doctype':		return '<!DOCTYPE html>';
				case 'datalist':	break;
				case 'dd':			break;
				case 'del':			$a = 'cite,datetime'; break;
				case 'dfn':			break;
				case 'div':			break;
				case 'dl':			break;
				case 'dt':			break;
				case 'em':			break;
				case 'embed':		$s = true; $a = 'height,src,type,width'; break;
				case 'fieldset':	$a = 'disabled,form_id,text'; break;
				case 'figcaption':	break;
				case 'figure':		break;
				case 'footer':		break;
				case 'form':		$a = 'accept,accept-charset,action,autocomplete,enctype,method,name,novalidate,target'; break;
				case 'h1':			break;
				case 'h2':			break;
				case 'h3':			break;
				case 'h4':			break;
				case 'h5':			break;
				case 'h6':			break;
				case 'head':		break;
				case 'header':		break;
				case 'hgroup':		break;
				case 'hr':			$s = true; break;
				case 'html':		$a = 'manifest'; break;
				case 'img':			$s = true; $a = 'alt,crossorigin,height,src,usemap,width'; break;
				case 'i':			break;
				case 'input':		$s = true; $a = 'accept,alt,autocomplete,autofocus,checked,disabled,form,formaction,formenctype,formmethod,formnovalidate,formtarget,height,list,max,maxlength,min,multiple,name,pattern,placeholder,readonly,required,size,src,step,type,value,width'; break;
				case 'keygen': 		$s = true; $a = 'autofocus,challenge,disabled,form,keytype,name'; break;
				case 'label':		$a = 'for,form'; break;
				case 'legend':		break;
				case 'li':			break;
				case 'link':		$s = true; $a = 'href,hreflang,media,rel,sizes,type'; break;
				case 'map':			$a = 'name'; break;
				case 'mark':		break;
				case 'menu':		break;
				case 'meta':		$s = true; $a = 'charset,content,http-equiv,name'; break;
				case 'meter':		$a = 'form,heigh,low,max,min,optimum,value'; break;
				case 'nav':			break;
				case 'noscript':	break;
				case 'object':		$a = 'data,form,height,name,type,usemap,width'; break;
				case 'ol':			$a = 'reversed,start,type'; break;
				case 'optgroup':	$a = 'disabled,label'; break;
				case 'option':		$a = 'disabled,label,selected,value'; break;
				case 'output':		$a = 'for,form,name'; break;
				case 'p':			break;
				case 'param':		$s = true; $a = 'name,value'; break;
				case 'pre':			break;
				case 'progress':	$a = 'max,value'; break;
				case 'q':			$a = 'cite'; break;
				case 'rp':			break;
				case 'rt':			break;
				case 'ruby':		break;
				case 's':			break;
				case 'sample':		break;
				case 'script':		$a = 'async,charset,defer,src,type'; break;
				case 'section':		break;
				case 'select':		$a = 'autofocus,disabled,form,multiple,name,required,size'; break;
				case 'small':		break; 
				case 'source':		$s = true; $a = 'media,src,type'; break;
				case 'span':		break; 
				case 'strong':		break;
				case 'style':		$a = 'media,scoped,type'; break;
				case 'sub':			break; 
				case 'table':		$a = 'border'; break;
				case 'tbody':		break;
				case 'td':			$a = 'colspan,headers,scope'; break;
				case 'text':		return new Text($childrenOrAttributes);
				case 'textarea':	$a = 'autofocus,cols,disabled,form,maxlength,name,placeholder,readonly,required,row,wrap'; break;
				case 'tfoot':		break;
				case 'th':			$a = 'colspan,headers,rowspan,scope'; break;
				case 'thead':		break;
				case 'time':		$a = 'datetime'; break;
				case 'title':		break;
				case 'tr':			break;
				case 'track':		$s = true; $a = 'default,kind,label,src,srclang'; break;
				case 'u':			break;
				case 'ul':			break;
				case 'var':			break;
				case 'video':		$a = 'autoplay,controls,height,loop,muted,poster,preload,src,width'; break;
				case 'wbr': 		$s = true; break;
				default:
					throw new HTML5Error(HTML5Error::INVALID_TAG, $tag);
					break;
			}
			
			// Create the attributes collection, either string or array
			$attributes = $s ? $childrenOrAttributes : $attributes;
			
			// If there are attributes and they are in a string format
			// convert to an attributes array
			if ($attributes !== null && is_string($attributes))
			{
				$attributes = Attribute::shorthand($attributes);
			}
			
			// Combine the attributes and the tags
			if (is_array($attributes))
			{
				$attributes = array_merge($tagAttributes, $attributes);
			}
			// Or just add any tag attributes
			else if (count($tagAttributes))
			{
				$attributes = $tagAttributes;
			}
			
			// Create the node or container
			$node = ($s) ?
				new Node($tag, $attributes, $a) :
				new NodeContainer($tag, $childrenOrAttributes, $attributes, $a);
			
			// Take the selectors convert them into id or class
			foreach($selectors[0] as $selector)
			{
				switch($selector[0])
				{
					case '#' : 
						$node->id = substr($selector, 1); 
						break;
					case '.' : 
						if ($node->class) $node->class .= ' ';
						$node->class .= substr($selector, 1); 
						break;
				}
			}
			
			return $node;
		}
		
		/** 
		* Prettifies an HTML string into a human-readable and indented work of art 
		* @param string $html The XML-compatible HTML as a string 
		* @return string The formatted string
		*/
		public static function format($html)
		{
			// Conver the HTML -> SimpleXML -> DOMDocument
			$dom = dom_import_simplexml(new SimpleXMLElement($html))->ownerDocument;
			
			// Format the DOMDocument 
			$dom->formatOutput = true;
			
			// Save the output as XML
			$buffer = $dom->saveXML();
			
			// Remove the first line which has the XML declaration
			return substr($buffer, strpos($buffer, "\n")+1); 
		}
		
		/**
		 * Checks if a variable is really "empty".  Code borrowed from PHP.net at
		 * http://us3.php.net/manual/en/function.empty.php#90767 because we were
		 * previously using empty() to see if a variable is empty or not.  But
		 * empty() dosen't work for attributes that have a value of "0", so we need
		 * something more robust here.
		 *
		 *   an unset variable -> empty
		 *   null -> empty
		 *   0 -> NOT empty
		 *   "0" -> NOT empty
		 *   false -> empty
		 *   true -> NOT empty
		 *   'string value' -> NOT empty
		 *   "	"(white space) -> empty
		 *   array()(empty array) -> empty
		 *
		 * There are two optional parameters:
		 *
		 *   allow_false: setting this to true will make the function consider a
		 *   boolean value of false as NOT empty. This parameter is false by default.
		 *
		 *   allow_ws: setting this to true will make the function consider a string
		 *   with nothing but white space as NOT empty. This parameter is false by
		 *   default.
		 */
		protected function isEmpty($var, $allow_false = false, $allow_ws = false) 
		{
			return (!isset($var) || is_null($var) ||
				($allow_ws == false && !is_object($var) && is_string($var) && trim($var) == '' && !is_bool($var)) ||
				($allow_false === false && is_bool($var) && $var === false) ||
				(is_array($var) && empty($var)));
	 	}
	}
}
	
?>