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

class UsersViewSubPage extends SubPage {
    
    function build($tpl)
    {
        $sql = "SELECT id FROM users WHERE username LIKE ?";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->bindParam(1, $_GET["name"]);
        $sth->execute();
        $res = $sth->fetch(PDO::FETCH_ASSOC);
        
        $user = User::fromID($res["id"]);
        
        $arr = $user->getProperties();
        
        // Query the number of articles.
        $sql = "SELECT COUNT(*) AS count FROM published_articles INNER JOIN users ON (published_articles.author_id = users.id) WHERE published = 1";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->execute();
        $res = $sth->fetch(PDO::FETCH_ASSOC);
        $arr["articles_count"] = $res["count"];
        
        $tpl->assign("userInfo", $arr);
        $tpl->display('users-view.tpl');
    }
}

?>