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
class User {
    
    const ANONYMOUS = 'ANONYMOUS';
    
    private $_id;
    private $_username;
    private $_last_logon_date;
    private $_register_date;
    private $_role;
    private $_description;
    private $_permissions = array();
    
    public static function fromID($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->bindParam(1, $id);
        $sth->execute();
        $res = $sth->fetch(PDO::FETCH_ASSOC);
        
        $instance = new User($res["id"], $res["username"], $res["content"], null);
        $instance->_register_date = $res["register_date"];
        $instance->_last_logon_date = $res["last_logon_date"];
        $instance->_role = $res["roles"];
        $instance->_description = $res["description"];
        $instance->_permissions = array();
        
        $sql = "SELECT * FROM permissions INNER JOIN users_permissions ON (users_permissions.permission_id = permissions.id) WHERE user_id = ?";
        $sth = DatabaseHelper::getInstance()->prepare($sql);
        $sth->bindParam(1, $id);
        $sth->execute();
        $res = $sth->fetchAll();
        
        for ($i=0; $i < count($res);$i++)
        {
            array_push($instance->_permissions, $res[$i]["label"]);
        }
        
        return $instance;
    }
    
    public function __construct($id, $username, $permissions)
    {
        $this->_id = $id;
        $this->_username = $username;
        $this->_permissions = $permissions;
    }
    
    public function getProperties()
    {
        return array(
            "id" => $this->_id, 
            "username" => $this->_username, 
            "role" => $this->_role, 
            "permissions" => $this->_permissions,
            "register_date" => $this->_register_date, 
            "last_logon_date" => $this->_last_logon_date);
    }
    
    public function hasPermission($perm)
    {
        $needle = array_search($perm, $this->_permissions);
        if ($needle == false)
            return false;
        return true;
    }
    
    public function getUsername() { return $this->_username; }
    
    public function getPermissions() { return $this->_permissions; }
}
