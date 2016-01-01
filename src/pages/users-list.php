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

class UsersListSubPage extends SubPage {
    
    function build($tpl)
    {
        $sql = "SELECT a.id, (SELECT COUNT(*) FROM published_articles WHERE author_id = a.id) AS articles_count FROM users a";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->execute();
        
        $users = array();
        while ($row = $sth->fetch())
        {
            $user = User::fromID($row["id"]);
            $data = $user->getProperties();
            $data["icon"] = WEBAPP_WEBSITE_URL . "upload/bc6cea68f3a413d20d17202cb67b03d2.jpg";
            $data["articles_count"] = $row["articles_count"];
            array_push($users, $data);
        }
        
        $tpl->assign("users", $users);
        $tpl->display('users-list.tpl');
    }
}

?>