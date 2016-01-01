{{include file="content_header.tpl" title="{{$article.title}}"}}
{{include file="content_navbar.tpl" title="{{$article.title}}"}}

<div class="blog">
    <div class="blog-header">
        <h1>Utilisateurs</h1>
    </div>
    <div class="blog-content">
        <p>
            Voici la liste des utilisateurs de ce blog :
        </p>
        <table class="table table-striped">
            <thead>
                
            </thead>
            <tbody>
                {{foreach from=$users item="u"}}
                <tr>
                    <td style="width: 48px;"><img src="{{$u.icon}}" style="width: 32px; height: 32px; border-radius: 16px; border: 2px solid #ddd;" /></td>
                    <td style="vertical-align: middle;"><a href="{{$WEBAPP_WEBSITE_URL}}users/{{$u.username}}">{{$u.username}}</a></td>
                    <td style="width: 120px; text-align: right; vertical-align: middle;"><span class="user-details">{{$u.articles_count}} article(s)</span></td>
                </tr>
                {{/foreach}}
            </tbody>
        </table>
        
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