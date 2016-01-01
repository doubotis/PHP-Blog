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
class RSSWriter {
    
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
    
    function writeRSS()
    {
        $rss = '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
        $rss = $rss . '<channel>';
        $rss = $rss . '<atom:link href="http://www.doubotis.be:8084/blog/rss.php" rel="self" type="application/rss+xml" />';
        $rss = $rss . '<title>' . "doubotis.be" . '</title>';
        $rss = $rss . '<link>' . 'http://www.doubotis.be:8084/blog/index.php' . '</link>';
        $rss = $rss . '<description>Blog de Doubotis</description>';
        
        for ($i=0; $i < count($this->_articles); $i++)
        {
            $article = $this->_articles[$i];
            $rss = $rss . '<item>';
            $rss = $rss . '<pubDate>' . date("D, d M Y G:i:s O", strtotime($article["date"])) . '</pubDate>';
            $rss = $rss . '<guid><![CDATA[' . 'http://www.doubotis.be' . WEBAPP_WEBSITE_URL . 'news/' . $article["id"] . ']]></guid>';
            $rss = $rss . '<title><![CDATA[' . utf8_decode(strip_tags($article["title"])) . ']]></title>';
            $rss = $rss . '<link><![CDATA[' . 'http://www.doubotis.be' . WEBAPP_WEBSITE_URL . 'news/' . $article["id"] . ']]></link>';
            $rss = $rss . '<description><![CDATA[' . html_entity_decode(strip_tags($article["summary"])) . ']]></description>';
            $rss = $rss . '</item>';
        }
        $rss = $rss . '</channel>'; 
        $rss = $rss . '</rss>';
        
        header("Content-type: application/rss+xml");
        printf($rss);
    }
}
