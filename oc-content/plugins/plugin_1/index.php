<?php   
/*
Plugin Name: Plugin_1
Plugin URI: http://www.yyyyyy.com/
Description: This plugin extends a Item to store some atributes
Version: 1
Author: Web-Media
Author URI: http://www.yyyyyy.com/
Short Name: plugin1

*/

require('Plugin_1.php');



// will  import table from struct.sql into database on  plugin install 
function plugin1_call_after_install() {
    
    Plugin_1::newInstance()->import('plugin_1/struct.sql');
    
       
    }
// Self-explanatory
function plugin1_call_after_uninstall() {
     
    Plugin_1::newInstance()->uninstall();
    
    

}
// this will bring  into item-post 
// form the fields from edit.php
//
function plugin1_form($catID = '') {
    // We received the categoryID
     if($catID == '') {
            return false;
        }
        if(is_numeric($catID)){
        // We check if the category is the same as our plugin
        if(osc_is_this_category('plugin1', $catID)) {
            require_once 'edit.php';
        }
         }else{ return false;}
    }
   
       

    
// will put the data  from our fields  on submit into database in some steps
    
function plugin1_form_post($item)  {
        $catID = $item['fk_i_category_id'];
        $itemID = $item['pk_i_id'];
    
    if($catID == null) {return false;}
     if(is_numeric($catID)){
      // We check if the category is the same as our plugin
        if(osc_is_this_category('plugin1', $catID) && $itemID!=null) {
            if(is_numeric($itemID)){
             $arrayInsert = _getPlugin_1Parameters();
               // Insert the data in our plugin's table
                 Plugin_1::newInstance()->insertPlugin_1Attr($arrayInsert, $itemID);
			}else{return false;}
	             }
		        }else{return false;}
    }	

// will  import detail.php into item  page
function plugin1_item_detail() {
    
    if(osc_is_this_category('plugin1', osc_item_category_id())) {
        
        // get the details from database
        $detail = Plugin_1::newInstance()->getPlugin_1Attr(osc_item_id());
		if( count($detail) == 0 ) {
                return  false;
            }
        require_once 'detail.php';
		
    }
}



// Self-explanatory
function plugin1_item_edit($catID = null, $itemID = null) {
    if(is_numeric($catID)&&is_numeric($itemID)){
         if(osc_is_this_category('plugin1', $catID))
            {
             // get the details from database
             $detail = Plugin_1::newInstance()->getPlugin_1Attr($itemID);
             
                require_once 'edit.php';
            }
            }else{return false;}
        }
// Self-explanatory
function plugin1_item_edit_post($item){
    $catID = $item['fk_i_category_id'];
        $itemID = $item['pk_i_id'];
    // We received the categoryID and the Item ID
      if($catID == null) {return false;}
        if(is_numeric($catID)&&is_numeric($itemID)){
        if(osc_is_this_category('plugin1', $catID))
          {
            
            // get the details from edit.php file
            $arrayUpdate = _getPlugin_1Parameters();
            Plugin_1::newInstance()->updatePlugin_1Attr($arrayUpdate, $itemID);
          }
          }else{return false;}
    }

// will delete from our table the data   with pk_i_id =$item_id
function plugin1_delete_item($item_id) {
     if( is_numeric($item_id)){
    Plugin_1::newInstance()->deleteItem($item_id);
     }
}




// this function  holds  values  into sessions... 
// if error on submit will post into session and back to form

function plugin1_pre_item_post()
{
 Session::newInstance()->_setForm('pplugin_first_name',  Params::getParam('plugin_first_name') );
   // keep values on session
 Session::newInstance()->_keepForm('pplugin_first_name');
  //example
   /*
 Session::newInstance()->_setForm('pplugin_second_name',  Params::getParam('plugin_second_name') );
 Session::newInstance()->_keepForm('pplugin_second_name');  
  */ 
   
}

 /// this function will get parametes from edit.php defined fields hold into array and
 // send parametres to  Plugin_1 class  for inserting into database 

function _getPlugin_1Parameters() {
    /*
* $first_name  is variable example
 *   will get value from detail.php ->plugin_first_name field
 *   shoud be  sanitized acording to your needs
 *    example we need  $second_name number->integer
     * 
     * 
 $second_name_unsafe  = Params::getParam('plugin_first_name');
 if(is_numeric($second_name_unsafe)){
           $second_name       =  $second_name_unsafe;
                }else{
       $second_name = null;
     }
 }
   */  
    
     $first_name_unsafe  = Params::getParam('plugin_first_name');
        if(strlen($first_name_unsafe)<80){
                $first_name       =  htmlspecialchars(strip_tags( trim( $first_name_unsafe )) );
                 }else{ $first_name = null;}
   
  /// this array will hold the parameters must fit ->$first_name
  //                
                 
       $array = array(
               'first_name'          => $first_name,
          );
         return $array;
    }

/// end admin
function plugin1_admin_configuration() {
    // Standard configuration page for plugin which extend item's attributes
    osc_plugin_configure_view(osc_plugin_path(__FILE__) );
 }

// this is needed in order to be able to activate the plugin
osc_register_plugin(osc_plugin_path(__FILE__), 'plugin1_call_after_install');
// this is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)

// this is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'plugin1_call_after_uninstall') ;
/* require('functions.php'); */

osc_add_hook(osc_plugin_path(__FILE__)."_configure", 'plugin1_admin_configuration');
//require('functions_button.php');

// when publishing an item we show an extra form with more attributes
osc_add_hook('item_form', 'plugin1_form');
// to add that new information to our custom table
osc_add_hook('posted_item', 'plugin1_form_post');



// show an item special attributes
osc_add_hook('item_detail', 'plugin1_item_detail');

// edit an item special attributes
osc_add_hook('item_edit', 'plugin1_item_edit');
// edit an item special attributes POST
osc_add_hook('edited_item', 'plugin1_item_edit_post');


// delete item
osc_add_hook('delete_item', 'plugin1_delete_item');



// previous to insert item
osc_add_hook('pre_item_post', 'plugin1_pre_item_post') ;


?>
