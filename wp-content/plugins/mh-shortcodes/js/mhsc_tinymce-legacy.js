// =============================================================================
// JS/ADMIN/TINYMCE-LEGACY.JS
// -----------------------------------------------------------------------------
// v3.X TinyMCE specific functions.
// =============================================================================

(function() {
  tinymce.create('tinymce.plugins.MHShortcodeMce', {

    init : function(ed, url){
      tinymce.plugins.xShortcodeMce.theurl = url;
    },

    createControl : function(btn, e) {
      if ( btn == 'mhsc_shortcodes_button' ) {
        var a   = this;
        var btn = e.createSplitButton('mhsc_button', {
          title: 'Insert Shortcode',
          image: tinymce.plugins.xShortcodeMce.theurl + '/mhsc_shortcodes.png',
          icons: false,
        });

        btn.onRenderMenu.add(function (c, b) {



          // Buttons & Icons.
            
          c = b.addMenu({title:'Shortcodes'});
          a.render( c, 'Button', 'button' );
          a.render( c, 'Marker', 'marker' );
          a.render( c, 'Alert', 'alert' );          
          a.render( c, 'Separator', 'separator' );
          a.render( c, 'Link', 'link' );
          a.render( c, 'Clearfix', 'clearfix' );



        });
        return btn;
      }
      return null;
    },

    render : function(ed, title, id) {
      ed.add({
        title: title,
        onclick: function () {


          //
          // Structure.
          //

          if(id === 'separator') {
            tinyMCE.activeEditor.selection.setContent('[separator size="100px" color="#2ecc71"]');
          }
            
            if(id === 'link') {
            tinyMCE.activeEditor.selection.setContent('[link href="#" title="Title" target="blank"]I am a link[/link]');
          }

          if(id === 'clearfix') {
            tinyMCE.activeEditor.selection.setContent('[clearfix]');
          }


          if(id === 'marker') {
            tinyMCE.activeEditor.selection.setContent('[marker color="#2ecc71" txcolor="light"]Mark some text to make it stand out![/marker]');
          }


          if(id === 'button') {
            tinyMCE.activeEditor.selection.setContent('[button href="#" title="Title" target="blank" size="small, regular, large" color="#e84533" txcolor="#ffffff" fullwidth="false"] I am a Clickable Button! [/button]');
          }

          if(id === 'alert') {
            tinyMCE.activeEditor.selection.setContent('[alert color="#2ecc71" close="true" heading="Heading"] ... [/alert]');
          }


        

          return false;

        }
      });
    }
  
  });

  tinymce.PluginManager.add('mhsc_shortcodes', tinymce.plugins.xShortcodeMce);

})();