<body>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-48805204-2', 'auto');
        ga('send', 'pageview');

    </script>
    <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
    </script>
    <div id="page">
        <div class="container">
            <div class="row rowoffcanvas" style="margin-left: 0; margin-right: 0; clear: both;">
            <div id="secondary" class="col-md-3">
                <header class="header">
                    <!-- Header Block -->
                    <div id="header-title-block">
                        <div class="block">
                            <div class="title">doubotis.be</div>
                            <div class="caption">DÉVELOPPEUR SMARTPHONE & WEB<br/>FAN DE JEUX VIDEOS</div>
                        </div>
                        
                    </div>
                    <div>
                        <!-- Menus goes here -->
                        <ul class="menu">
                            <li><a href="{{$WEBAPP_WEBSITE_URL}}"><span class="menu-list-item-icon"><i class="fa fa-home"></i></span>Accueil</a></li>
                            <li><a href="{{$WEBAPP_WEBSITE_URL}}news?category=developer"><span class="menu-list-item-icon"><i class="fa fa-code"></i></span>Développeur</a></li>
                            <li><a href="{{$WEBAPP_WEBSITE_URL}}news?category=gaming"><span class="menu-list-item-icon"><i class="fa fa-gamepad"></i></span>Gaming</a></li>
                            <li><a href="{{$WEBAPP_WEBSITE_URL}}contact"><span class="menu-list-item-icon"><i class="fa fa-envelope-o"></i></span>Contact</a></li>
                        </ul>
                    </div>
                    <div class="header-block">
                        <!-- Meta goes here -->
                        <h3>Meta</h3>
                        <ul class="simplified-menu">
                            {{if $user == null or $user->getUsername() eq User::ANONYMOUS}}
                                <li><a href="$('#myModal').modal();" data-toggle="modal" data-target="#myModal">Login</a></li>
                            {{else}}
                                <li>
                                    <form method="post" target="">
                                        <input type="hidden" name="action" value="logout" />
                                        <button class="logout-text" type="submit">Logout</button>
                                    </form>
                                </li>
                            {{/if}}
                            {{if $user != null and $user->hasPermission("perm.admin") eq true}}
                                <li><a href="{{$WEBAPP_WEBSITE_URL}}admin">Admin</a></li>
                            {{/if}}
                                <li><a href="{{$WEBAPP_WEBSITE_URL}}rss.xml">RSS Feed <i class="fa fa-rss"></i></a></li>
                        </ul>
                            
                            {{if $user != null and $user->getUsername() neq User::ANONYMOUS}}
                            <div class="permissions-block">
                                Vos Permissions:
                                <ul>
                                    {{foreach from=$user->getPermissions() item="p"}}
                                        <li>{{$p}}</li>
                                    {{/foreach}}
                                </ul>
                                </div>
                            {{/if}}
                    </div>
                    {{if $lastArticles neq null}}
                    <div class="header-block">
                        <!-- Recent posts goes here -->
                        <h3>Articles récents</h3>
                        <ul class="simplified-menu">
                            {{foreach from=$lastArticles item="la"}}
                                <li><a href="{{$WEBAPP_WEBSITE_URL}}news/{{$la.id}}">{{$la.title}}</a> <span class="date">{{strftime("(%d/%m/%g)", strtotime($la.published_date))}}</span></li>
                            {{/foreach}}
                        </ul>
                    </div>
                    {{/if}}
                    <div class="header-block">
                        <!-- Social goes here -->
                        <h3>Social</h3>
                        <ul class="social-menu">
                            <li><a target="_blank" href="https://twitter.com/doubotis"><i class="fa fa-twitter"></i></a></li>
                            <li><a target="_blank" href="https://www.facebook.com/Doubotis-Gaming-114182895270106/?fref=ts"><i class="fa fa-facebook"></i></a></li>
                            <li><a target="_blank" href="https://www.youtube.com/user/doubotis"><i class="fa fa-youtube"></i></a></li>
                            <li><a target="_blank" href="https://be.linkedin.com/in/christophe-brasseur-603aab7b"><i class="fa fa-linkedin"></i></a></li>
                            <li><a target="_blank" href="https://github.com/doubotis"><i class="fa fa-github"></i></a></li>
                        </ul>
                        
                    </div>
                </header>
            </div>
            <div id="primary" class="col-md-9">
                
            