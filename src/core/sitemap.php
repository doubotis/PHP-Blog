<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RSSWriter
 *
 * @author Christophe
 */
class SitemapWriter {
    
    var $_articles;
    
    function __construct()
    {
        $sql = "SELECT *, COALESCE(release_date, created_date) AS \"date\" FROM published_articles";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->execute();
        
        $this->_articles = array();
        
        while($row = $sth->fetch())
        {
            array_push($this->_articles, $row);
        }
    }
    
    function writeSitemap()
    {
        header("Content-type: application/xml");
        
        $rss = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'; 
        $rss = $rss . '<url>';
        $rss = $rss . '<loc>http://www.doubotis.be/</loc>';
        $rss = $rss . '<changefreq>daily</changefreq>';
        $rss = $rss . '</url>';
        $rss = $rss . '<url>';
        $rss = $rss . '<loc>http://www.doubotis.be/news?category=developer</loc>';
        $rss = $rss . '<changefreq>daily</changefreq>';
        $rss = $rss . '</url>';
        $rss = $rss . '<url>';
        $rss = $rss . '<loc>http://www.doubotis.be/news?category=gaming</loc>';
        $rss = $rss . '<changefreq>daily</changefreq>';
        $rss = $rss . '</url>';
        $rss = $rss . '<url>';
        $rss = $rss . '<loc>http://www.doubotis.be/contact</loc>';
        $rss = $rss . '<changefreq>daily</changefreq>';
        $rss = $rss . '</url>';
        
        for ($i=0; $i < count($this->_articles); $i++)
        {
            $article = $this->_articles[$i];
            $rss = $rss . '<url>';
            $rss = $rss . '<loc>http://www.doubotis.be/news/' . $article["id"] . '</loc>';
            $rss = $rss . '<changefreq>daily</changefreq>';
            $rss = $rss . '</url>';
        }
        $rss = $rss . '</urlset>';
        
        printf($rss);
    }
}
