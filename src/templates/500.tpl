{{include file="content_header.tpl" title="Home"}}
{{include file="content_navbar.tpl" title="Home"}}

<div class="blog">
    <div class="error-container">
        <h1>{{$exception->getCode()}}</h1>

        <h2>{{$exception->getMessage()}}</h2>

        <div class="error-details">
                Désolé, une erreur s'est produite ! Pourquoi ne pas essayer de revenir à la <a href="index.php">page d'acceuil</a> ou peut-être d'essayer ce bouton.

        </div> <!-- /error-details -->

        <div class="error-actions">
                <a href="index.php" class="btn btn-large btn-primary">
                        <i class="icon-chevron-left"></i>
                        &nbsp;
                        Revenir à l'acceuil						
                </a>



        </div> <!-- /error-actions -->

    </div> <!-- /error-container -->			
</div>

{{include file="content_footer.tpl" view="home"}}