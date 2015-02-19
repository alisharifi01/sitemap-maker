<?php
// =======================================================================// 
//                        @author Ali Sharifi                             //
//                       alisharifi01@gmail.com                           //        
// =======================================================================//
// =======================================================================// 
//                        HOW TO USE SiteMap Class                        //        
// =======================================================================//
include  'mySimpleXmlElement.class.php';
include  'siteMap.class.php'; 
// ***************** Make instance from SiteMap class ********************//    
    //SiteMap class need one parameter as sitemap path 
    //Dont use relative address for path 
    //I use __DIR__ for local testing 
    //You should call SiteMap without parameter
        //$sitemap_obj = new SiteMap();
        //By deafult the path is /sitemap.xml in the root directory. for example: www.your-website.com/sitemap.xml
    //$sitemap_obj = new SiteMap();    
    $sitemap_obj = new SiteMap(__DIR__.'/sitemap.xml');
// *************************** addPage method ****************************//    
    //You can add page to sitemap via addPage method
    //addPage gets an array as a parameter
    //Set loc in array for location <loc>
    //Set changefreq in array for <changefreq>
        //Valid values for changereq are : always , hourly , daily , weekly , monthly , yearly , never
        //I set default monthly
    //Set perioroty in array for <periority>
        //Valid values range from 0.0 to 1.0
        //I set default 0.5
    $sitemap_obj->addPage(array('loc' => 'http://www.your-website.com?p=1' ,
                                'changefreq' => 'weekly' ,
                                'periority' => '0.7'));
    //changefreq and periority are optional for setting in array
    $sitemap_obj->addPage(array('loc' => 'http://www.your-website.com?p=2'));
// *************************** addPages method ****************************//
    //You can also add multi pages to sitemap via addPages method 
    $pages = array(
        array('loc' => 'http://www.your-website.com?p=3' , 'changefreq' => 'weekly' , 'periority' => '1.00'),
        array('loc' => 'http://www.your-website.com?p=4'),
        array('loc' => 'http://www.your-website.com?p=5' , 'changefreq' => 'year' , 'periority' => '0.8'),
        array('loc' => 'http://www.your-website.com?p=6'),
        array('loc' => 'http://www.your-website.com?p=7'),
    );
   $sitemap_obj->addPages($pages);
// *************************** deletePage method ****************************//    
   //you can delete one url from sitemap by using deletePage method
    $sitemap_obj->deletePage('http://www.your-website.com?p=5');
// *************************** deletePages method ***************************//
    //you can also delete multi pages from sitemap by pasing array of pages locations to deletePages method
    $pagesToDelete=array('http://www.your-website.com?p=6',
                        'http://www.your-website.com?p=7');
    $sitemap_obj->deletePages($pagesToDelete);
// ************************* updateLastMod method ***************************//
    //You can just update <lastmod> of any url in sitemap via updateLastMod method
    $sitemap_obj->updateLastMod('http://www.your-website.com?p=4');
// ************************* updateLastMod method ***************************//
    //You can just update <periority> of any url in sitemap via updatePeriority method
    $sitemap_obj->updatePeriority('http://www.your-website.com?p=4','0.2');
// ************************* updateLastMod method ***************************//
    //You can just update <changefreq> of any url in sitemap via updateChangeFreq method
    $sitemap_obj->updateChangeFreq('http://www.your-website.com?p=4','daily');
