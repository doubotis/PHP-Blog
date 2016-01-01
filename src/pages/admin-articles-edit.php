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

class AdminArticlesEditSubPage extends SubPage {
    
    function build($tpl)
    {
        $articleID = $_GET["id"];
        
        $sql = "SELECT * FROM articles WHERE id = ?";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->bindParam(1, $articleID);
        $sth->execute();
        $res = $sth->fetch(PDO::FETCH_ASSOC);
        $res["release_date"] = ($res["release_date"] == NULL) ? NULL : date("Y-m-d\TH:i", strtotime($res["release_date"]));
        
        $sql = "SELECT *, (SELECT COUNT(*) FROM articles_categories AS b WHERE b.category_id = a.id AND b.article_id = ?) AS checked FROM categories a";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->bindParam(1, $articleID);
        $sth->execute();
        $categories = $sth->fetchAll();
        
        $tpl->assign("categories", $categories);
        
        $tpl->assign("article", $res);
    }
}

?>