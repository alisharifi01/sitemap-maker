<?php
/**
    I extend simpleXmlElement PHP class and add a remove method. 
    This Method is supposed to remove a node.
    I use this additional method to implement my SiteMap class , so you have to include this file too.
**/
class mySimpleXmlElement extends simpleXmlElement{
        public function remove(){
            $dom=dom_import_simplexml($this);
            $dom->parentNode->removeChild($dom);
        }
  }
