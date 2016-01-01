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

abstract class AuthenticationPage extends Page
{
    private $_user;
    private $_lastArticles;
    
    function __construct()
    {

    }
    
    function onCreate()
    {
        session_start();
        
        // Check for any POST login/logout request.
        $action = isset($_POST["action"]) ? $_POST["action"] : "";
        if ($action == "auth")
        {
            // Yes, this is an auth request.
            $username = $_POST["username"];
            $password = $_POST["password"];
            
            // Check with DB.
            $sql = "SELECT id FROM users WHERE username LIKE ? AND password LIKE sha1(?)";;
            $sth = DatabaseHelper::getInstance()->prepare($sql);
            $sth->bindParam(1, $username);
            $sth->bindParam(2, $password);
            $sth->execute();
            $res = $sth->fetch(PDO::FETCH_ASSOC);
            if ($res != false)
            {
                // ID found. Parse it.
                $id = $res["id"];
                $user = User::fromID($id);
                $_SESSION["user_id"] = $id;
                $_SESSION["username"] = $user->getUsername();
            }
        }
        else if ($action == "logout")
        {
            // This is a logout request.
            session_destroy();
            session_start();
        }
        
        $this->prepareUser();
        
        $this->prepareDataForLeftPanel();
    }
    
    function process($tpl)
    {
        $tpl->assign("user", $this->_user);
        $tpl->assign("lastArticles", $this->_lastArticles);
        $tpl->assign("WEBAPP_WEBSITE_URL", WEBAPP_WEBSITE_URL);
        
        parent::process($tpl);
    }
    
    function prepareUser()
    {
        $id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : -1;
        if ($id != -1)
        {
            $this->_user = User::fromID($id);
            
            // Update last logon date
            $sql = "UPDATE users SET last_logon_date = now() WHERE id = ?";
            $sth = DatabaseHelper::getInstance()->prepare($sql);
            $sth->bindParam($id);
            $sth->execute();
        }
        else
        {
            $this->_user = new User(-1, User::ANONYMOUS, array());
        }
    }
    
    function prepareDataForLeftPanel()
    {
        $sql = "SELECT * FROM published_articles ORDER BY published_date DESC LIMIT 5";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->execute();
        
        $lastArticles = array();
        while($row = $sth->fetch())
        {
            $row["title"] = strlen($row["title"]) > 40 ? substr($row["title"],0,40)."..." : $row["title"];
            array_push($lastArticles, $row);
        }
        $this->_lastArticles = $lastArticles;
    }
    
    function getUserSession() { return $this->_user; }
}

?>