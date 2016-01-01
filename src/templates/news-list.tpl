{{include file="content_header.tpl" title="Articles"}}
{{include file="content_navbar.tpl" title="Articles"}}

{{foreach from=$articles item=a}}
<div class="blog">
    <div class="blog-header">
        <h1>{{$a.title}}</h1>
        <div class="blog-header-subtitle"><a href="javascript:void(0)">{{strftime("%A %d %B %Y", strtotime($a.date))}}</a> par 
            <a href="{{$WEBAPP_WEBSITE_URL}}users/{{$a.author.username}}">{{$a.author.username}}</a> - 
            <a href="{{$WEBAPP_WEBSITE_URL}}news/{{$a.id}}#comments">{{$a.comments}} commentaire(s)</a>
            {{if $user->hasPermission("perm.news.moderate") eq true}}
                &nbsp;&nbsp;<a href="{{$WEBAPP_WEBSITE_URL}}admin?sub=articles_edit&id={{$a.id}}"><i class="fa fa-pencil-square"></i></a>
            {{/if}}<br/>
            {{foreach from=$a.categories item="c"}}
            <span class="label label-primary"><a style="color: white;" href="{{$WEBAPP_WEBSITE_URL}}news?category={{$c.label}}"><i class="fa fa-tag"></i> {{$c.friendlyName}}</a></span>&nbsp;
            {{/foreach}}
            </div>
    </div>
    <div class="blog-content">
        {{$a.summary}}
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
        {{if $a.content neq null}}
        <div class="blog-read-more">
            <a class="btn btn-default" href="{{$WEBAPP_WEBSITE_URL}}news/{{$a.id}}">Lire l'article complet <i class="fa fa-angle-double-right"></i></a>
        </div>
        {{/if}}
    </div>
</div>
{{/foreach}}

<nav class="navigation pagination" role="navigation">
    <ul class="pagination">
        {{if ($pageIndex+2) gte $pageCount+1 and ($pageIndex-4 gt 0)}}
            {{if ($pageIndex-4) lt $pageCount}}<li><a href="{{$pageLink}}page={{$pageIndex-4}}">{{$pageIndex-4}}</a></li>{{/if}}
        {{/if}}
        {{if ($pageIndex+1) gte $pageCount+1 and ($pageIndex-3 gt 0)}}
            {{if ($pageIndex-3) lt $pageCount-1}}<li><a href="{{$pageLink}}page={{$pageIndex-3}}">{{$pageIndex-3}}</a></li>{{/if}}
        {{/if}}
        {{if ($pageIndex-2) gt 0}}<li><a href="{{$pageLink}}page={{$pageIndex-2}}">{{$pageIndex-2}}</a></li>{{/if}}
        {{if ($pageIndex-1) gt 0}}<li><a href="{{$pageLink}}page={{$pageIndex-1}}">{{$pageIndex-1}}</a></li>{{/if}}
        <li class="active"><a href="{{$pageLink}}page={{$pageIndex}}">{{$pageIndex}}</a></li>
        {{if ($pageIndex+1) lt $pageCount+1}}<li><a href="{{$pageLink}}page={{$pageIndex+1}}">{{$pageIndex+1}}</a></li>{{/if}}
        {{if ($pageIndex+2) lt $pageCount+1}}<li><a href="{{$pageLink}}page={{$pageIndex+2}}">{{$pageIndex+2}}</a></li>{{/if}}
        {{if ($pageIndex-1) lte 0}}
            {{if ($pageIndex+3) lt $pageCount+1}}<li><a href="{{$pageLink}}page={{$pageIndex+3}}">{{$pageIndex+3}}</a></li>{{/if}}
        {{/if}}
        {{if ($pageIndex-2) lte 0}}
            {{if ($pageIndex+4) lt $pageCount+1}}<li><a href="{{$pageLink}}page={{$pageIndex+4}}">{{$pageIndex+4}}</a></li>{{/if}}
        {{/if}}
  </ul>
</nav>

{{include file="content_footer.tpl" view="home"}}