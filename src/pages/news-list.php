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

class NewsListSubPage extends SubPage {
    
    function build($tpl)
    {
        $page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
        $categ = isset($_REQUEST["category"]) ? $_REQUEST["category"] : "developer|gaming";
        $categories = explode("|", $categ);
        
        $conditions = "";
        
        if (count($categories) > 0)
        {
            $conditions = $conditions . " WHERE (";
        
            for ($i=0; $i < count($categories); $i++)
            {
                $conditions = $conditions . "categories.label LIKE ?";
                
                if ($i < (count($categories) - 1))
                    $conditions = $conditions . " OR ";
            }
            $conditions = $conditions . ")";
        }
        
        if (isset($_REQUEST["author"]))
        {
            if ($conditions != "")
                $conditions = $conditions . " AND username LIKE ?";
            else
                $conditions = $conditions . " WHERE username LIKE ?";
        }
        
        $conditions = $conditions . " GROUP BY published_articles.id ORDER BY published_articles.published_date DESC";
        
        if (isset($_REQUEST["author"]))
            array_push($categories, $_REQUEST["author"]);
        
        // Query the count of elements.
        $sqlCount = "SELECT COUNT(published_articles.id) AS count FROM published_articles "
                . "INNER JOIN articles_categories ON (published_articles.id"
                . " = articles_categories.article_id) INNER JOIN categories "
                . "ON (categories.id = articles_categories.category_id) INNER"
                . " JOIN users ON (users.id = published_articles.author_id)"
                . $conditions;
        $sthCount = DatabaseHelper::getInstance()->prepare($sqlCount);
        
        $sthCount->execute($categories);
        $resCount = $sthCount->fetch(PDO::FETCH_ASSOC);
        $countArticles = $resCount["count"];
        
        // Compute the number of articles.
        $pageCount = intval($countArticles / 5);
        
        // Now query the IDs for the current page only.
        $offset = intval(($page - 1) * 5);
        $sql = "SELECT published_articles.id AS id FROM published_articles "
                . "INNER JOIN articles_categories ON (published_articles.id"
                . " = articles_categories.article_id) INNER JOIN categories "
                . "ON (categories.id = articles_categories.category_id) INNER"
                . " JOIN users ON (users.id = published_articles.author_id)"
                . $conditions
                . " LIMIT 5 OFFSET $offset";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->execute($categories);
        
        $articles = array();
        while ($row = $sth->fetch()) {
            $articleID = $row["id"];
            $articleObj = Article::fromID($articleID);
            
            $data = $articleObj->getProperties();
            if ($data["published"] == 0)
                continue;
            
            array_push($articles, $data);
        }
        
        $pageLink = isset($_REQUEST["category"]) ? "?category=" . $_REQUEST["category"] . "&" : "?";
        
        $tpl->assign("articles", $articles);        
        $tpl->assign("pageLink", $pageLink);
        $tpl->assign("pageCount", $pageCount);
        $tpl->assign("pageIndex", $page);
        
        $tpl->display('news-list.tpl');
    }
}

?>