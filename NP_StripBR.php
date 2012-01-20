<?php 
 
// plugin needs to work on Nucleus versions <=2.0 as well
if (!function_exists('sql_table')) {
	function sql_table($name) {
		return 'nucleus_' . $name;
	}
}
 
class NP_StripBR extends NucleusPlugin { 
    function getName() {    return 'StripBR'; } 
    function getAuthor() {  return 'IWAMA Kazuhiko'; } 
    function getURL() {     return 'http://www.sera.desuyo.net/'; } 
    function getVersion() { return '0.01'; } 
    function getDescription() { 
        return 'Remove linebreaks'; 
    } 
    function getEventList() { 
        return array('PreItem'); 
    } 
	function supportsFeature($what) {
		switch($what) {
			case 'SqlTablePrefix':
				return 1;
			default:
				return 0;
		}
	}
 
    function replaceCallback($matches) { 
        return removeBreaks($matches[1]); 
    } 
 
    function event_PreItem($data) { 
        $this->currentItem = &$data["item"]; 
        $this->currentItem->body = preg_replace_callback( 
                '#<%nobr%>(.*?)<%/nobr%>#s', 
                array(&$this, 'replaceCallback'), 
                $this->currentItem->body 
            ); 
        $this->currentItem->more = preg_replace_callback( 
                '#<%nobr%>(.*?)<%/nobr%>#s', 
                array(&$this, 'replaceCallback'), 
                $this->currentItem->more 
            ); 
    } 
 
} 
?>