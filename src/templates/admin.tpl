{{include file="content_header.tpl" title="Panneau d'administration"}}
{{include file="content_navbar.tpl" title="Panneau d'administration"}}

<div class="admin">
    
    <ul class="nav nav-pills">
        <li role="dashboard" {{if $section eq "dashboard"}}class="active"{{/if}}>
            <a href="{{$WEBAPP_WEBSITE_URL}}admin?sub=dashboard" style="text-align: center; width: 100px;"><i class="fa fa-th-large"></i><br/>Dashboard</a>
        </li>
        <li role="articles" {{if $section eq "articles"}}class="active"{{/if}}>
            <a href="{{$WEBAPP_WEBSITE_URL}}admin?sub=articles" style="text-align: center; width: 100px;"><i class="fa fa-pencil"></i><br/>Articles</a>
        </li>
        <li role="moderation" {{if $section eq "moderation"}}class="active"{{/if}}>
            <a href="{{$WEBAPP_WEBSITE_URL}}admin?sub=moderation" style="text-align: center; width: 100px;"><i class="fa fa-certificate"></i><br/>Modération</a>
        </li>
        <li role="phpmyadmin" >
            <a href="http://doubotis.be:8084/phpmyadmin/" target="_blank" style="text-align: center; width: 100px;"><i class="fa fa-database"></i><br/>Database</a>
        </li>
        <li role="analytics" >
            <a href="https://www.google.com/analytics/web/?authuser=1#report/defaultid/a48805204w109370676p114043232/" target="_blank" style="text-align: center; width: 100px;"><i class="fa fa-bar-chart"></i><br/>Analytics</a>
        </li>
    </ul>
            
    <hr/>
    
    {{include file="{{$adminPage}}"}}
    
</div>

{{include file="content_footer.tpl" view="home"}}