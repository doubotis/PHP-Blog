<?php

/* 
 * Copyright (C) 2014 Christophe
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of User
 *
 * @author Christophe
 */
class Article {
    
    private $_id;
    private $_title;
    private $_summary;
    private $_content;
    private $_author;
    private $_date;
    private $_last_modified_date;
    private $_published;
    private $_comments;
    private $_comment_fb_url;
    private $_categories = array();
    
    public static function fromID($id)
    {
        $sql = "SELECT *, COALESCE(release_date, created_date) AS \"date\" FROM articles WHERE id = ?";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->bindParam(1, $id);
        $sth->execute();
        $res = $sth->fetch(PDO::FETCH_ASSOC);
        if ($res == false)
            throw new Exception ("Impossible de trouver cet article", 404);
        
        $instance = new Article($res["id"], $res["title"], $res["summary"], $res["content"], null, null);
        $instance->_author = User::fromID($res["author_id"]);
        $instance->_categories = array();
        $instance->_date = $res["date"];
        $instance->_published = $res["published"];
        $instance->_last_modified_date = $res["last_modified_date"];
        $instance->_comment_fb_url = DOMAIN_NAME . WEBAPP_WEBSITE_URL . "news/" . $instance->_id;
        $instance->_comments = $instance->queryCommentsCount();
        
        // Get the count of articles.
        
        
        $sql = "SELECT * FROM categories INNER JOIN articles_categories ON (articles_categories.category_id = categories.id) WHERE article_id = ?";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->bindParam(1, $id);
        $sth->execute();
        while ($row = $sth->fetch()) {
            array_push($instance->_categories, $row);
        }
        return $instance;
    }
    
    public static function fromCategories($categories)
    {
        
    }
    
    public function __construct($id, $title, $summary, $content, $author, $categories)
    {
        $this->_id = $id;
        $this->_title = $title;
        $this->_summary = $summary;
        $this->_content = $content;
        $this->_author = $author;
        $this->_categories = $categories;
    }
    
    public function queryCommentsCount()
    {
        $url = $this->_comment_fb_url;
        $url = "https://graph.facebook.com/v2.4/?fields=share{comment_count}&id=" . $url;
        $jsonResponse = file_get_contents(
                $url);
        $json = json_decode($jsonResponse, true);
        $cc = $json["share"]["comment_count"];
        
        return $cc;
    }
    
    public function getProperties()
    {
        return array("id" => $this->_id, 
            "title" => $this->_title, 
            "summary" => $this->_summary,
            "content" => $this->_content,
            "author" => $this->_author->getProperties(),
            "date" => $this->_date,
            "last_modified_date" => $this->_last_modified_date,
            "categories" => $this->_categories,
            "comments" => $this->_comments,
            "comment_fb_link" => $this->_comment_fb_url,
            "published" => $this->_published);
    }
    
    public function getCategories() { return $this->_categories; }
}
