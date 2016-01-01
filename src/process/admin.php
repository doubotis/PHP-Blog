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

class AdminProcess extends Process
{
    function __construct()
    {
        
    }
    
    /** Gets the name of the current page, based on the class name. */
    function getName()
    {
        return get_class($this);
    }
    
    function editArticle($array)
    {
        if (!$this->getUserContext()->hasPermission("perm.news.manage"))
            throw new Exception("Vous n'avez pas les droits pour faire cela.", 403);
        
        if ($array["id"] == 0)
        {
            $authorInfo = $this->getUserContext()->getProperties();
            
            // New Article.
            DatabaseHelper::getInstance()->beginTransaction();
            $sql = "INSERT INTO articles(id,title,summary,content,published,author_id,release_date,created_date,last_modified_date) VALUES(NULL, :title, :summary, :content, :published, :author_id, :release_date, now(), now())";
            $sth = DatabaseHelper::getInstance()->prepare($sql);
            $sth->bindParam(":title", $array["title"], PDO::PARAM_STR);
            $sth->bindParam(":summary", $array["summary"], PDO::PARAM_STR);
            $sth->bindParam(":content", $array["content"], PDO::PARAM_STR);
            $sth->bindParam(":published", $array["published"], PDO::PARAM_INT);
            $sth->bindParam(":author_id", $authorInfo["id"], PDO::PARAM_INT);
            $sth->bindParam(":release_date", $array["release_date"], PDO::PARAM_INT);
            $res = $sth->execute();
            
            // Loop into categories.
            $lastID = DatabaseHelper::getInstance()->lastInsertId();
            $sql = "SELECT * FROM categories";
            $sth = DatabaseHelper::getInstance()->prepare($sql);
            $sth->execute();
            $categories = $sth->fetchAll();
            for ($i=0; $i < count($categories); $i++)
            {
                $categories[$i]["before"] = 0;
                $categories[$i]["after"] = isset($_POST["category_" . $categories["id"]]) ? 1 : 0;
            }
            
            $this->updateTags(true, $categories, $lastID);
            
            DatabaseHelper::getInstance()->commit();
        }
        else
        {
            // Edit Article.
            DatabaseHelper::getInstance()->beginTransaction();
            $sql = "UPDATE articles SET title = :title, summary = :summary, content = :content, published = :published, release_date = :release_date, last_modified_date = now() WHERE id = :id";
            $sth = DatabaseHelper::getInstance()->prepare($sql);
            $sth->bindParam(":id", $array["id"], PDO::PARAM_INT);
            $sth->bindParam(":title", $array["title"], PDO::PARAM_STR);
            $sth->bindParam(":summary", $array["summary"], PDO::PARAM_STR);
            $sth->bindParam(":content", $array["content"], PDO::PARAM_STR);
            $sth->bindParam(":published", $array["published"], PDO::PARAM_INT);
            $sth->bindParam(":release_date", $array["release_date"], PDO::PARAM_INT);
            $res = $sth->execute();
            
            // Loop into categories
            $sql = "SELECT *, (SELECT COUNT(*) FROM articles_categories AS b WHERE b.category_id = a.id AND b.article_id = ?) AS \"before\" FROM categories a";
            $sth = DatabaseHelper::getInstance()->prepare($sql);
            $sth->bindParam(1, $array["id"]);
            $sth->execute();
            $categories = $sth->fetchAll();
            for ($i=0; $i < count($categories); $i++)
            {
                $identifier = "category_" . $categories[$i]["id"];
                $isDefined = isset($_POST[$identifier]);
                $categories[$i]["after"] = ($isDefined) ? 1 : 0;
            }
            
            $this->updateTags(true, $categories, $array["id"]);
            
            DatabaseHelper::getInstance()->commit();
        }

        // Redirect.
        header('Location: ?v=admin&sub=articles');
    }
    
    function deleteArticle($array)
    {
        if (!$this->getUserContext()->hasPermission("perm.news.manage"))
            throw new Exception("Vous n'avez pas les droits pour faire cela.", 403);
        
        DatabaseHelper::getInstance()->beginTransaction();
        $sql = "DELETE FROM articles WHERE id = ?";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->bindParam(1, $array["id"]);
        $sth->execute();
        
        $sql = "DELETE FROM comments WHERE article_id = ?";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->bindParam(1, $array["id"]);
        $sth->execute();
        
        $sql = "DELETE FROM articles_categories WHERE article_id = ?";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->bindParam(1, $array["id"]);
        $sth->execute();
        DatabaseHelper::getInstance()->commit();
            
            // Redirect.
        header('Location: ?v=admin&sub=articles');
    }
    
    function updateTags($withinTransaction, $categories, $articleID)
    {
        if (!$withinTransaction) DatabaseHelper::getInstance()->beginTransaction();
        
        for ($i=0; $i < count($categories); $i++)
        {
            //print_r($categories[$i]);
            if ($categories[$i]["before"] == 0 && $categories[$i]["after"] == 1)
            {
                // We must insert the row.
                $sql = "INSERT INTO articles_categories (article_id, category_id) VALUES (?,?)";
                $sth = DatabaseHelper::getInstance()->prepare($sql);
                $sth->bindParam(1, $articleID);
                $sth->bindParam(2, $categories[$i]["id"]);
                $sth->execute();
            }
            else if ($categories[$i]["before"] == 1 && $categories[$i]["after"] == 0)
            {
                // We must delete the row.
                $sql = "DELETE FROM articles_categories WHERE article_id = ? AND category_id = ?";
                $sth = DatabaseHelper::getInstance()->prepare($sql);
                $sth->bindParam(1, $articleID);
                $sth->bindParam(2, $categories[$i]["id"]);
                $sth->execute();
            }
        }
        
        if (!$withinTransaction) DatabaseHelper::getInstance()->commit();
    }
}

?>