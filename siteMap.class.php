<?php
// =======================================================================// 
//                        @author Ali Sharifi                             //
//                       alisharifi01@gmail.com                           //
// =======================================================================// 
//                            DESCRIPTION                                 //
// =======================================================================//
/**
*SiteMap Class generates XML Sitemap which is supposed to be processed by search engines like Google, MSN Search and YAHOO
*You can find more information about XML sitemaps on sitemaps.org
*SiteMap Class detect you have sitemap.xml or not
*If you dont, SiteMap Class generates XML sitemap 
*If you have a sitemap.xml, SiteMap Class just edit the existing sitemap
*Through SiteMap Class you can make a new sitemap.xml , add new url(s) to existing sitemap.xml, 
    update <lastmod> of specific <url> in your sitemap,
    update <perioroty> of specific <url> in your sitemap,
    update <changefreq> of specific <url> in your sitemap, 
    or delete url(s) form your sitemap
*/
class SiteMap {
	private $path;
        private $sitemap;
	public function __construct($path = '') {
            if($path == '' OR $path == NULL){
                $this->path=$_SERVER['DOCUMENT_ROOT'].'/sitemap.xml';
            }
            else {
                $this->path =$path;
            }
            if (file_exists($this->path)) {
                    $this->sitemap = simplexml_load_file($this->path,'mySimpleXmlElement');
                }
                else {
                    $this->createNewSiteMap();
                }
	}
        private function createNewSiteMap(){
            $emptySitemap = '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet '
                    . 'type="text/xsl" href="sitemap.xsl"?><urlset '
                    . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '
                    . 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 '
                    . 'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" '
                    . 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
                    . '</urlset>';
            file_put_contents($this->path, $emptySitemap);
            $this->sitemap = simplexml_load_file($this->path,'mySimpleXmlElement');
        }
	public function addPages($pages)
	{
                for($i=0;$i<count($pages);$i++){
                    if($urlToChange = $this->pageIsExist($pages[$i]['loc'],$this->sitemap)){
                       //just update <lastmod>
                       $this->updateLastModUrl($urlToChange);
                    }
                    else {
                        //add new <url> to sitemap
                        $newUrl=$this->sitemap->addChild('url');
                        $newUrl->addChild('loc',$pages[$i]['loc']);
                        if(isset($pages[$i]['changefreq']))
                            $newUrl->addChild('changefreq',$pages[$i]['changefreq']);
                        else 
                            $newUrl->addChild('changefreq','monthly');
                        if(isset($pages[$i]['periority']))
                           $newUrl->addChild('periority',$pages[$i]['periority']); 
                        else
                           $newUrl->addChild('periority','0.5');  
                        $newUrl->addChild('lastmod',date('Y-m-d'));
                        $this->sitemap->asXML($this->path);
                    }
                }
	}
        public function addPage($page)
	{  
            if($urlToChangeMod = $this->pageIsExist($page['loc'],$this->sitemap)){
               //just update <lastmod>
               $this->updateLastModUrl($urlToChangeMod);
            }
            else {
                //add new <url> to sitemap
                $newUrl=$this->sitemap->addChild('url');
                $newUrl->addChild('loc',$page['loc']);
                if(isset($pages['changefreq']))
                    $newUrl->addChild('changefreq',$page['changefreq']);
                else 
                    $newUrl->addChild('changefreq','monthly');
                if(isset($pages['periority']))
                   $newUrl->addChild('periority',$page['periority']); 
                else
                   $newUrl->addChild('periority','0.5');  
                $newUrl->addChild('lastmod',date('Y-m-d'));
                $this->sitemap->asXML($this->path);
            }
                
	}
        public function updateLastMod($page){
            if($urlToChange = $this->pageIsExist($page,$this->sitemap)){
               //just update <lastmod>
               $this->updateLastModUrl($urlToChange);
            }
        }
        public function updateChangeFreq($page,$changeFreq){
            if($urlToChange = $this->pageIsExist($page,$this->sitemap)){
               //just update <changefreq>
               $this->updateChangeFreqUrl($urlToChange,$changeFreq);
            }
        }
        public function UpdatePeriority($page,$periority){
            if($urlToChange = $this->pageIsExist($page,$this->sitemap)){
               //just update <periority>
               $this->updatePeriorityUrl($urlToChange,$periority);
            }
        }
        public function deletePages($pages){
            for($i=0;$i<count($pages);$i++){
               if($url = $this->pageIsExist($pages[$i],$this->sitemap)){
                   //delete <url>
                    $url->remove();
                    $this->sitemap->asXml($this->path);
                } 
            }
        }
        public function deletePage($page){
           if($url = $this->pageIsExist($page,$this->sitemap)){
               //delete <url>
                $url->remove();
                $this->sitemap->asXml($this->path);
            } 
        }
        private function UpdateLastModUrl($urlToChange){
            $urlToChange->lastmod=date("Y-m-d");
            $this->sitemap->asXML($this->path);
        }
        private function UpdatePeriorityUrl($urlToChange,$periority){
            $urlToChange->periority=$periority;
            $this->sitemap->asXML($this->path);
        }
        private function UpdateChangeFreqUrl($urlToChange,$changeFreq){
            $urlToChange->changefreq=$changeFreq;
            $this->sitemap->asXML($this->path);
        }
        private function pageIsExist($page,$xml){
            foreach($xml->url as $url){
                if($page == $url->loc){
                    return $url;
                 }
             }
             return false;
        }
}