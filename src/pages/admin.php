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

class AdminPage extends AuthenticationPage {
    
    function build($tpl)
    {
        // Firstly we need to handle any POST requests.
        if (isset($_POST["action"]))
            $this->handlePOST();
        
        $sub = isset($_REQUEST["sub"]) ? $_REQUEST["sub"] : "dashboard_view";
        $subs = split("_", $sub);
        $section = $subs[0];
        $context = isset($subs[1]) ? $subs[1] : "view";
        $tpl->assign("section", $section);
        
        $tpl->assign("adminPage", "admin-sub-" . $section . "-" . $context . ".tpl");
        
        $this->displaySectionWithContext($tpl, $section, $context);
        $tpl->display('admin.tpl');
    }
    
    function displaySectionWithContext($tpl, $section, $context)
    {
        if ($section == "articles" && $context == "view")
        {
            require_once 'admin-articles-view.php';
            $subPage = new AdminArticlesViewSubPage($this);
            $subPage->build($tpl);
            return;
        }
        else if ($section == "articles" && $context == "edit")
        {
            require_once 'admin-articles-edit.php';
            $subPage = new AdminArticlesEditSubPage($this);
            $subPage->build($tpl);
            return;
        }
    }
    
    function handlePOST()
    {
        $action = $_POST["action"];
        if ($action == "edit_article")
        {
            $process = Process::buildFromName("admin", $this->getUserSession());
            $arr = array(
                "id" => isset($_POST["id"]) ? $_POST["id"] : 0,
                "title" => $_POST["title"],
                "published" => isset($_POST["published"]) ? 1 : 0,
                "summary" => $_POST["summary"],
                "content" => $_POST["content"],
                "release_date" => isset($_POST["release_date"]) ? $_POST["release_date"] : NULL
            );
            $process->editArticle($arr);
        }
        else if ($action == "delete_article")
        {
            $process = Process::buildFromName("admin", $this->getUserSession());
            $arr = array(
                "id" => isset($_POST["id"]) ? $_POST["id"] : -1
            );
            $process->deleteArticle($arr);
        }
    }
    
    function hasPermissions($userPermissions) {
        
        if ($this->getUserSession()->hasPermission("perm.admin"))
        {
            // Security Violation!
            return true;
        }
        return false;
    }
}

?>