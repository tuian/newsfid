<?php if( isset($detail['s_youtube']) && !empty($detail['s_youtube']) ) { ?>
<div class="widget">
            <h3 id="gmap"><?php _e('Youtube', 'flatter'); ?></h3>
            <div class="youtube wblock">
            
    <object width="100%" height="80%">
        <param name="movie" value="<?php echo trim($detail['s_youtube']) ; ?>"></param>
        <param name="allowFullScreen" value="true"></param>
        <param name="wmode" value="transparent"></param>
        <param name="allowScriptAccess" value="always"></param>
        <embed src="<?php echo $detail['s_youtube'] ; ?>"
          type="application/x-shockwave-flash"
          allowfullscreen="true"
          allowscriptaccess="always"
          wmode="transparent"
          width="100%" height="80%">
        </embed>
    </object>
    
          </div>
        </div>

<?php } ?>