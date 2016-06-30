<?php 
    $i_userId = osc_logged_user_id();
	if(Params::getParam('delete') != '' && osc_is_web_user_logged_in()){
		delete_item(Params::getParam('delete'), $i_userId);
	}

    $itemsPerPage = (Params::getParam('itemsPerPage') != '') ? Params::getParam('itemsPerPage') : 12;
    $iPage        = (Params::getParam('iPage') != '') ? Params::getParam('iPage') : 0;

    Search::newInstance()->addConditions(sprintf("%st_item_watchlist.fk_i_user_id = %d", DB_TABLE_PREFIX, $i_userId));
    Search::newInstance()->addConditions(sprintf("%st_item_watchlist.fk_i_item_id = %st_item.pk_i_id", DB_TABLE_PREFIX, DB_TABLE_PREFIX));
    Search::newInstance()->addTable(sprintf("%st_item_watchlist", DB_TABLE_PREFIX));
    Search::newInstance()->page($iPage, $itemsPerPage);

    $aItems      = Search::newInstance()->doSearch();
    $iTotalItems = Search::newInstance()->count();
    $iNumPages   = ceil($iTotalItems / $itemsPerPage) ;

    View::newInstance()->_exportVariableToView('items', $aItems);
    View::newInstance()->_exportVariableToView('search_total_pages', $iNumPages);
    View::newInstance()->_exportVariableToView('search_page', $iPage) ;

	// delete item from watchlist
	function delete_item($item, $uid){
		$conn = getConnection();
		$conn->osc_dbExec("DELETE FROM %st_item_watchlist WHERE fk_i_item_id = %d AND fk_i_user_id = %d LIMIT 1", DB_TABLE_PREFIX , $item, $uid);
	}
?>

            <div class="searchpage">
            	<div class="page-title">
                	<h2><?php _e('Watchlist', 'watchlist'); ?></h2>
                    <?php if (osc_count_items() == 0) { ?>
                    <?php } else { ?>
                    <span class="counter-search"><?php printf(_n('You are watching %d item', 'You are watching %d items', $iTotalItems, 'watchlist'), $iTotalItems) ; ?></span>
                    <?php } ?>
                </div>
        <?php if (osc_count_items() == 0) { ?>
        	<div id="content">
            	<p class="empty"><?php _e('You don\'t have any items yet', 'watchlist'); ?></p>
            </div>
        <?php } else { ?>
        	<div id="content">
            	<div class="row listing-grid">
					<?php while ( osc_has_items() ) { ?>
                    	<?php //osc_current_web_theme_path('loop-single.php'); ?>
                        <div class="listing-card col-md-4 col-sm-6 col-xs-6<?php echo $class; if(osc_item_is_premium()){ echo ' premium'; } ?>">
                        <div class="clearfix">
                        <div class="listing-image">
                            <div class="image">
                                <?php if( osc_images_enabled_at_items() ) { ?>
                                <?php if(osc_count_item_resources()) { ?>
                                    <a href="<?php echo osc_item_url(); ?>" title="<?php echo osc_item_title(); ?>"><img src="<?php echo osc_resource_preview_url(); ?>" alt="<?php echo osc_item_title() ; ?>" class="img-responsive" /></a>
                                <?php } else { ?>
                                    <a href="<?php echo osc_item_url(); ?>" title="<?php echo osc_item_title(); ?>"><img src="<?php echo osc_current_web_theme_url('images/no-photo.jpg'); ?>" alt="<?php echo osc_item_title() ; ?>" class="img-responsive" /></a>
                                <?php } ?>
                                <?php } ?>
                            </div>
                            <?php if(osc_item_is_premium()){ ?><div class="status sbg"><span class="premium"><?php _e('Premium', 'flatter'); ?></span></div><?php } ?>
                            <?php if (function_exists("watchlist")) { ?>
                                <div class="status wishlist">
                                    <?php if( osc_is_web_user_logged_in() ) { ?>
                                        <?php watchlist2(); ?>
                                    <?php } else { ?>
                                    <a title="<?php _e("Add to watchlist", 'watchlist'); ?>" rel="nofollow" href="<?php echo osc_user_login_url(); ?>"><i class="fa fa-heart-o fa-lg"></i></a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        
                        <div class="listing-detail">
                            <h5 class="clr"><a href="<?php echo osc_item_url() ; ?>" class="title" title="<?php echo osc_item_title() ; ?>"><?php echo osc_item_title() ; ?></a></h5>
                            <div class="listitem-detail"><?php echo osc_item_category(); ?></div>
                            <p><?php echo osc_highlight( strip_tags( osc_item_description()) ,150) ; ?></p>
                            
                            <?php if( osc_price_enabled_at_items() ) { ?><span class="price sclr"><?php echo osc_format_price(osc_item_price()); ?></span><?php } ?>

                            <div class="listing-option">
                                    <span class="admin-options">
                                        <a class="delete whover" onclick="javascript:return confirm('<?php echo osc_esc_js(__('Are you sure you want to continue?', 'flatter')); ?>')" href="<?php echo osc_render_file_url(osc_plugin_folder(__FILE__) . 'watchlist.php') . '&delete=' . osc_item_id(); ?>" ><?php _e('Remove', 'bender'); ?></a>
                                    </span>
                            </div>

                        </div><!-- Detail -->
                        </div>
                    </div>
                    
                    <?php } ?>
            	</div>
        	</div>
            <div class="pagination">
                <?php echo osc_pagination(array('url' => osc_render_file_url(osc_plugin_folder(__FILE__) . 'watchlist.php') . '&iPage={PAGE}')); ?>
            </div>
        <?php } ?>
            </div>