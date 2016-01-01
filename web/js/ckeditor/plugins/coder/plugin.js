CKEDITOR.plugins.add( 'coder', {
    icons: 'wowhead',
    init: function( editor ) {
        // Plugin logic goes here...
        
        editor.ui.addButton( 'Coder', {
            label: 'Coder Block',
            command: 'coder',
            toolbar: 'insert'
        });
        CKEDITOR.dialog.add( 'coderDialog', this.path + 'dialogs/coder.js' );
        editor.addCommand( 'coder', new CKEDITOR.dialogCommand( 'coderDialog', {
            allowedContent: {
                pre: {
                    classes: 'prettyprint'
                }
            }
        } ) );
    }
});