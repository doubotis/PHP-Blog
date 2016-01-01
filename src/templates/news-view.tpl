{{include file="content_header.tpl" title="{{$article.title}}"}}
{{include file="content_navbar.tpl" title="{{$article.title}}"}}


<div class="blog">
    <div class="blog-header">
        <h1>{{$article.title}}</h1>
        <div class="blog-header-subtitle"><a href="javascript:void(0)">{{strftime("%A %d %B %Y", strtotime($article.date))}}</a> par 
            <a href="{{$WEBAPP_WEBSITE_URL}}users/{{$article.author.username}}">{{$article.author.username}}</a> - 
            <a href="{{$WEBAPP_WEBSITE_URL}}news/{{$article.id}}#comments">{{$article.comments}} commentaire(s)</a>
            {{if $user->hasPermission("perm.news.moderate") eq true}}
                &nbsp;&nbsp;<a href="{{$WEBAPP_WEBSITE_URL}}admin?sub=articles_edit&id={{$article.id}}"><i class="fa fa-pencil-square"></i></a>
            {{/if}}<br/>
            {{foreach from=$article.categories item="c"}}
            <span class="label label-primary"><a style="color: white;" href="{{$WEBAPP_WEBSITE_URL}}news?category={{$c.label}}"><i class="fa fa-tag"></i> {{$c.friendlyName}}</a></span>&nbsp;
            {{/foreach}}
            
            <!-- Buttons start here. Copy this ul to your document. -->
            <div class="social-block" style="text-align: center; margin-top: 10px; margin-bottom: 10px; display: none;">
                <div class="fb-share-button" data-href="{{$article.pageLink}}" data-layout="button" style="position: relative; top: -6px;"></div>
                <a href="https://twitter.com/share" class="twitter-share-button"{count} data-via="doubotis">Tweet</a>
            </div>
        </div>
    </div>
    <div class="blog-content">
        {{$article.summary}}
        <!--<img src="http://demo.yoarts.com/flatblog/wp-content/uploads/2013/04/square-ui-1.jpg" class="big-picture" />
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ex sapien, venenatis eget laoreet ornare, porta rutrum justo. Proin quis ante sed diam sollicitudin facilisis ut eget risus. Nunc ornare vestibulum dapibus. Nullam nec justo et augue consectetur lacinia sed quis tellus. Etiam laoreet pellentesque nibh vel suscipit. Integer nec maximus justo, ac tempor quam. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque sed lorem eu nisi consectetur viverra vitae in urna. Suspendisse magna neque, pretium sed nibh ultrices, lacinia interdum elit. Nunc nec neque ullamcorper, lobortis turpis quis, sodales ante. Quisque sed faucibus metus. Cras vestibulum libero massa, a tincidunt dui bibendum lacinia. Ut tincidunt interdum porta. Nam volutpat varius ante, nec faucibus tortor tincidunt molestie. Mauris porta, lectus a condimentum auctor, purus orci feugiat ipsum, pellentesque feugiat risus augue id risus.
        </p>
        <pre class="prettyprint">class Voila {
            public:
              // Voila
              static const string VOILA = "Voila";

              // will not interfere with embedded <a href="#voila2">tags</a>.
            }</pre>
        <pre class="prettyprint">[HelloWorld setStaticValue:@"HelloWorld"];</pre>
        <p>
            Nunc tellus neque, vestibulum non cursus et, tempor in ipsum. Curabitur accumsan sollicitudin justo ac lacinia. Donec rutrum arcu in euismod auctor. Nunc ex lectus, condimentum nec purus sit amet, gravida gravida urna. Maecenas ut enim quis tortor consectetur tempus scelerisque non tellus. Maecenas tempor justo et mi tincidunt, ut pharetra augue egestas. Duis sed viverra justo. Sed eget eros eget dui viverra malesuada. Phasellus ligula nunc, tempor in ullamcorper at, placerat eu augue. Nullam et elit in lectus efficitur scelerisque. Pellentesque ut leo auctor, iaculis odio nec, posuere augue. Suspendisse nec libero nulla. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla auctor facilisis leo, ut mollis ipsum consectetur eget. Mauris quis urna in nunc dapibus pulvinar.
        </p>-->
        {{if $article.content neq null}}
            <hr/>
            {{$article.content}}
        {{/if}}
        <div class="last-modified-block">
            <i class="fa fa-angle-right"></i> Dernière modification de l'article le {{$article.last_modified_date}}
        </div>
    </div>
</div>
    
<div class="blog-comments">
    <h2>Commentaires</h2>
    <a name="comments"></a>
    
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.5";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    
    <div class="fb-comments" data-href="{{$article.comment_fb_link}}" data-width="100%" data-numposts="15"></div>
    
</div>
    
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".social-block").css("display","block");
            }, 1500);
            
        });
    </script>    
    
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