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

abstract class Process
{
    var $_userContext;
    
    public static function buildFromName($processName, $userContext)
    {
        $className = $processName . 'Process';
        $phpFile = WEBAPP_DIR . 'process/' . $processName . '.php';
        
        if (!file_exists($phpFile))
                throw new Exception("Page file doesn't exists!", 404);
            
            require_once WEBAPP_DIR . 'process/' . $processName . '.php';
            
            if (!class_exists($className))
                throw new Exception("Class '" . $className . "' doesn't exists!", 500);
            
            $o = new $className();
            $o->onCreate($userContext);
            return $o;
    }
    
    function __construct()
    {
        
    }
    
    /** Gets the name of the current page, based on the class name. */
    function getName()
    {
        return get_class($this);
    }
    
    function onCreate($fromUser)
    {
        $this->_userContext = $fromUser;
    }
    
    function getUserContext()
    {
        return $this->_userContext;
    }
}

?>