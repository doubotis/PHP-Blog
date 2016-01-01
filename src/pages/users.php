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

class UsersPage extends AuthenticationPage {
    
    function build($tpl)
    {
        $hasID = isset($_REQUEST["name"]);
        if ($hasID)
        {
            // View specific article.
            require_once 'users-view.php';
            $subPage = new UsersViewSubPage($this);
            $subPage->build($tpl);
        }
        else
        {
            // View list.
            require_once 'users-list.php';
            $subPage = new UsersListSubPage($this);
            $subPage->build($tpl);
        }
    }
}

?>