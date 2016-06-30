<?php
  /*
   * Inside this file will  be some basic functions as 
   * 
   * deleteItem
   * getPlugin_1Attr
   * insertPlugin_1Attr
   * updatePlugin_1Attr
   *  check each  function comments to see  more details
   * 
   * 
   * 
   * 
   */

    class Plugin_1 extends DAO
    {
      
        private static $instance ;

       
        public static function newInstance()
        {
            if( !self::$instance instanceof self ) {
                self::$instance = new self ;
            }
            return self::$instance ;
        }

        
        function __construct()
        {
            parent::__construct();
        }
        
         /**
          * Return table name 
          * -> t_item_plugin_1
          * should be  exactly as defined into struct.sql file
          * MODIFY THE t_item_plugin_1 AS  YOUR NEEDS
          * 
          */
        public function getTable_Plugin()
        {
            return DB_TABLE_PREFIX.'t_item_plugin_1' ;
        }
        
/**
* Do not touch this one
*/
 public function import($file)
        {
            $path = osc_plugin_resource($file) ;
            $sql = file_get_contents($path);

            if(! $this->dao->importSQL($sql) ){
                throw new Exception( "Error importSQL::Plugin_1<br>".$file ) ;
            }
        }
/**
* Do not touch this one
*/
    public function uninstall()
        {
          $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_Plugin()) ) ;
            
        }
 
/**
* Do not touch this one IF 
 * fk_i_item_id  IS THE SAME  name as IN struct.sql
*/
   public function deleteItem($itemId)
        {
          if(!is_numeric($itemId)){
           return false;
         }
       
      return      $this->dao->delete($this->getTable_Plugin(), array('fk_i_item_id' => $itemId) );
        }
  
/**
* Do not touch this one IF 
 * fk_i_item_id  IS THE SAME  name as IN struct.sql
*/
   public function getPlugin_1Attr($itemId)
        {
       if(!is_numeric($itemId)){
           return false;
       }
            $this->dao->select();
            $this->dao->from($this->getTable_Plugin());
            $this->dao->where('fk_i_item_id', $itemId);
            
            $result = $this->dao->get();
            if( !$result ) {
                return array() ;
            }
            return $result->row();
        }
        
  
/**
* Do not touch this one IF 
 * fk_i_item_id  IS THE SAME  name as IN struct.sql
*/
  public function insertPlugin_1Attr( $arrayInsert, $itemId )
        {
      if(!is_numeric($itemId)){
           return false;
       }
            $aSet = $this->toArrayInsert($arrayInsert);
            $aSet['fk_i_item_id'] = $itemId;
            
            return $this->dao->insert($this->getTable_Plugin(), $aSet);
        }
        
/**
* Do not touch this one IF 
 * fk_i_item_id  IS THE SAME  name as IN struct.sql
*/
        public function updatePlugin_1Attr( $arrayUpdate, $itemId )
        {
             if(!is_numeric($itemId)){
           return false;
       }
            $aUpdate = $this->toArrayInsert($arrayUpdate) ;
            return $this->_update( $this->getTable_Plugin(), $aUpdate, array('fk_i_item_id' => $itemId));
        }
        
/**
* Here u must play ... 
 * fileds are sended by index.php 
 * 
 * _getPlugin_1Parameters... 
 * 
 * must match exactly  name and values
 * 
 * 
 * 
 * 
 * 
 * 
 * 
*/
        private function toArrayInsert( $arrayInsert )
        {
            $array = array(  
                's_plugin1_first_name'      =>  $arrayInsert['first_name']
               
                
            );
        
         return $array;
        }
        
        // not to touch
        function _update($table, $values, $where)
        {
            $this->dao->from($table) ;
            $this->dao->set($values) ;
            $this->dao->where($where) ;
            return $this->dao->update() ;
        }
        
        

        
        
    }
?>