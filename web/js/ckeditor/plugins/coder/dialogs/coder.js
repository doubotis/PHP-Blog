CKEDITOR.dialog.add( 'coderDialog', function ( editor ) {
    
    return {
        title: 'Coder',
        minWidth: 400,
        minHeight: 100,

        contents: [
            {
                id: 'tab-item',
                label: 'Insérer Code',
                elements: [
                    {
                        type: 'textarea',
                        id: 'codeblock',
                        'default':'',
                        style:'height: 100px;',
                        label: 'Code Block',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Le bloc de code ne peut pas être vide." )
                    }
                ]
            }
        ],
        onOk: function() {
            
            console.log("onOk !");
            
            var dialog = this;
            var contentText = dialog.getValueOf('tab-item', 'codeblock');
            
            var html = "<pre class='prettyprint'>" + contentText + "</pre>";
            
            console.log(html);
            
            var myscript = CKEDITOR.dom.element.createFromHtml(html, editor.document);
            
            console.log(myscript);
            
            editor.insertElement(myscript);
        }
    };
    
});