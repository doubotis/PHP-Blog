<h4>Admin - Articles</h4>

<table class="table table-hover">
    <thead>
        <tr>
            <td>#</td>
            <td width="60%">Titre</td>
            <td width="120">Vues</td>
            <td width="120">Commentaires</td>
        </tr>
    </thead>
    <tbody>
        <div style="text-align: right;">
            <a href="{{$WEBAPP_WEBSITE_URL}}admin?sub=articles_edit&id=0" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Créer un article</a>
        </div>
        {{if count($articles) eq 0}}
        <tr>
            <td colspan="4" style="text-align: center; color: gray;">Aucun article</td>
        </tr>
        {{else}}
        {{foreach from=$articles item="a"}}
        <tr>
            <td>{{$a.id}}</td>
            <td>
                <span id="element_{{$a.id}}">{{$a.title}}</span> 
                <span style="margin-left: 10px; font-size: 15px;">
                    <a href="{{$WEBAPP_WEBSITE_URL}}admin?sub=articles_edit&id={{$a.id}}"><i class="fa fa-pencil-square"></i></a>&nbsp;
                    <a href="javascript:displayDeleteDialog({{$a.id}})" ><i class="fa fa-trash-o" style="color: red;"></i></a>
                </span>
            </td>
            <td>0</td>
            <td>0</td>
        </tr>
        {{/foreach}}
        {{/if}}
    </tbody>
    
</table>

<!-- Delete Article Dialog -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Supprimer cet article ?</h4>
      </div>
      <div class="modal-body">
          <p>Êtes-vous sûr de vouloir supprimer <span id="delete-article-caption" style="color: #D9534F;"></span> ?</p>
      </div>
      <div class="modal-footer">
          <form method="POST">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="hidden" name="action" value="delete_article" />
                <input type="hidden" name="id" id="delete-article-input" value="-1" />
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    
    function displayDeleteDialog(id)
    {
        $("#delete-article-caption").html($("#element_" + id).html());
        $("#delete-article-input").val(id);
        $('#deleteModal').modal("show");
    }
    
</script>