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

require_once('include.php');

// Define controllers.
define('CONTROLLER_DASHBOARD', 'dashboard');
define('CONTROLLER_ADMIN', 'admin');
define('CONTROLLER_PROFILE', 'profile');
define('CONTROLLER_HELP', 'help');
define('CONTROLLER_LOGIN', 'login');
define('CONTROLLER_DEFAULT', '');

class Dispatcher {

  // database object
  var $pdo = null;
  // smarty template object
  var $tpl = null;
  // error messages
  var $error = null;
  
  var $connected = false;

    /**
    * class constructor
    */
    function __construct()
    {
        // instantiate the pdo object
        try
        {
            
            
        } catch (PDOException $e)
        {
            
        }
        
        // Check if logged.
        session_start();
        if (isset($_SESSION))
            $connected = true;

        // instantiate the template object
        $this->tpl = new SmartyWebsite();
    }
  
    /** Display the requested page. */
    function displayPage($webPage)
    {
        setcookie("last-page", full_url($_SERVER));
        
        /*if (isset($_SESSION["message"]))
        {
            $message = $_SESSION["message"];
            $this->tpl->assign('message', $message);
            unset($_SESSION["message"]);
        }*/
        
        $userPermissions = array("USER_VIEW");
        
        // Use reflexion to get the web page class.
        $className = $webPage . 'Page';
        $phpFile = WEBAPP_DIR . 'pages/' . $webPage . '.php';
        
        // Try to include (require_once) this PHP file.
        try
        {
            if (!file_exists($phpFile))
                throw new Exception("Page file " . $phpFile . " doesn't exists!", 404);
            
            require_once 'pages/' . $webPage . '.php';
            
            if (!class_exists($className))
                throw new Exception("Class '" . $className . "' doesn't exists!", 500);
            
            $o = new $className();
            $o->onCreate();
            $hasPermissions = $o->hasPermissions($userPermissions);
            if (!$hasPermissions)
                throw new Exception("Vous ne pouvez pas accéder à cette ressource", 403);
            
            $this->tpl->assign("page", $webPage);
            $o->process($this->tpl);
        
        } catch (Exception $ex) {
           
            // Build a basic template.
            $this->tpl->assign("exception", $ex);
            if ($ex->getCode() == 404)
                $this->tpl->display('404.tpl');
            else if ($ex->getCode() == 403)
                $this->tpl->display('404.tpl');
            else
                $this->tpl->display('500.tpl');
        }
    }
}

?>