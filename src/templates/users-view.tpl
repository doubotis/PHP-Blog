{{include file="content_header.tpl" title="{{$article.title}}"}}
{{include file="content_navbar.tpl" title="{{$article.title}}"}}

<div class="blog">
    <div class="blog-header">
        <h1>{{$userInfo.username}}</h1>
    </div>
    <div class="blog-content">
        <div style="float: right;">
            <img style="border: 3px solid #ddd; border-radius: 50px; width: 100px; height: 100px;" src="{{$WEBAPP_WEBSITE_URL}}upload/bc6cea68f3a413d20d17202cb67b03d2.jpg" />
            <div style="margin-top: 5px;">
                {{if $userInfo.role eq 'ADMIN'}}
                <span class="label label-primary">Administrateur</span>
                {{elseif $userInfo.role eq 'MODERATOR'}}
                <span class="label label-primary">Modérateur</span>
                {{elseif $userInfo.role eq 'REDACTOR'}}
                <span class="label label-primary">Rédacteur</span>
                {{elseif $userInfo.role eq 'BANNED'}}
                <span class="label label-danger">Banni</span>
                {{/if}}
            </div>
        </div>
        
        <p>
            Cet utilisateur s'est inscrit le {{strftime("%A %d %B %Y", strtotime($userInfo.register_date))}}.<br/>
            Dernière connexion le {{strftime("%A %d %B %Y", strtotime($userInfo.last_logon_date))}}.
        </p>
        <p>
            Nombre d'articles : {{$userInfo.articles_count}}&nbsp;&nbsp;&nbsp;<span class="user-details">(<a href="{{$WEBAPP_WEBSITE_URL}}news?author={{$userInfo.username}}">Voir tous les articles</a>)</span>
        </p>
        {{if $userInfo.description neq ''}}
        <hr/>
        <p>
            {{$userInfo.description}}
        </p>
        {{/if}}
        
    </div>
</div>
    
<!--<div class="blog-relatives">
    <div class="row">
        <div class="col-sm-6">
            <div class="blog-relatives-element">
                <div class="blog-relatives-media">
                    <img src="http://www.doubotis.be:8084/blog/upload/b42e1e2bbd3dd27152b2b801e8fbf774.jpg" />
                </div>
                <div class="blog-relatives-info">
                    <h4>Header Title</h4>
                    <p>Header Summary</p>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="blog-relatives-element">
                <div class="blog-relatives-media">
                    <img src="http://www.doubotis.be:8084/blog/upload/b42e1e2bbd3dd27152b2b801e8fbf774.jpg" />
                </div>
                <div class="blog-relatives-info">
                    <h4>Header Title</h4>
                    <p>Header Summary</p>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>
</div>-->

{{include file="content_footer.tpl" view="home"}}