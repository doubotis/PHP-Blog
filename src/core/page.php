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

abstract class Page
{
    function __construct()
    {
        
    }
    
    /** Gets the name of the current page, based on the class name. */
    function getName()
    {
        return get_class($this);
    }
    
    abstract function onCreate();
    
    function process($tpl)
    {
        $this->build($tpl);
    }
    
    /** Builds the page with the specified template var parameter. */
    abstract function build($tpl);
    
    /** Returns true or false, depending on the access restrictions you want
     *   for this page. A basic implementation is implemented that tells to 
     * allow authorizations for everybody. */
    function hasPermissions($userPermissions)
    {
        return true;
    }
}

?>