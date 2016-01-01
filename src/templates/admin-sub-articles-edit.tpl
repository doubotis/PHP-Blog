<h4>Admin - Créer/Modifier un article</h4>

<script src="{{$WEBAPP_WEBSITE_URL}}js/ckeditor/ckeditor.js"></script>
<script src="{{$WEBAPP_WEBSITE_URL}}js/ckeditor/adapters/jquery.js"></script>
<form method="POST">
    <fieldset>
        <p>
            <label>Nom de l'article</label><br/>
            <input class="form-control" type="text" style="width: 100%" value="{{$article.title}}" name="title"/>
        </p>
        <div class="row">
            <div class="col-lg-6">
                <div style="margin-bottom: 10px;">
                    <label>Status</label>
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        <li><input type="checkbox" {{if $article.published eq 1}}checked{{/if}} value="1" name="published"/> Publié</li>
                    </ul>
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Catégories</label>
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        {{foreach from=$categories item="c"}}
                        <li><input type="checkbox" name="category_{{$c.id}}" value="1" {{if $c.checked eq true}}checked{{/if}}/> {{$c.friendlyName}}</li>
                        {{/foreach}}
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div style="margin-bottom: 10px;">
                    <input type="checkbox" id="release_date_active" name="release_date_active" {{if $article.release_date neq null}}checked{{/if}}/> <label>Date de parution</label><br/>
                    <input class="form-control" type="datetime-local" id="release_date" name="release_date" value="{{$article.release_date}}" {{if $article.release_date eq null}}disabled{{/if}}/>
                </div>
            </div>
        </div>
        
    </fieldset>
    <hr/>
    <fieldset>
        <p>
            <label>Résumé</label><br/>
            <textarea class="form-control" style="width: 100%" rows="8" id="summary" name="summary">{{$article.summary}}</textarea>
        </p>
        <p>
            <label>Contenu</label><br/>
            <textarea class="form-control" style="width: 100%" rows="30" id="content" name="content">{{$article.content}}</textarea>
        </p>
    </fieldset>
    <div style="clear: both; height: 35px;">
        <fieldset style="float: left;">
            <button class="btn btn-default" type="submit" value="preview">Prévisualisation</button>
        </fieldset>
        <fieldset style="float:right;">
            <input type="hidden" name="action" value="edit_article" />
            <input type="hidden" name="id" value="{{$article.id}}" />
            <button class="btn btn-success" type="submit" value="confirm">Valider</button>
            <button class="btn btn-default" type="clear">Retour ancienne version</button>
            <a href="?v=admin&sub=articles" class="btn btn-default">Cancel</a>
        </fieldset>
    </div>
</form>
            
<script>
    $(document).ready(function() {
        $("#summary").ckeditor();
        $("#content").ckeditor();
    });
    
    $("#release_date_active").change(function() {

        // do stuff here. It will fire on any checkbox change
        if ($("#release_date_active").prop("checked"))
            $("#release_date").prop("disabled", false);
        else
        {
            $("#release_date").val("");
            $("#release_date").prop("disabled", true);
        }

});
</script>
