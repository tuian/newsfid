<?php if ( !defined('ABS_PATH') ) exit('ABS_PATH is not loaded. Direct access is not allowed.');
    /**
     * Model database for UserResource table
     *
     * @package Osclass
     * @subpackage Model
     * @since unknown
     */
    class Madhouse_Avatar_Model extends DAO
    {
        /**
         * It references to self object: UserResource.
         * It is used as a singleton
         *
         * @access private
         * @since unknown
         * @var UserResource
         */
        private static $instance;

        /**
         * It creates a new UserResource object class ir if it has been created
         * before, it return the previous object
         *
         * @access public
         * @since unknown
         * @return UserResource
         */
        public static function newInstance()
        {
            if( !self::$instance instanceof self ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        /**
         * Set data related to t_user_resource table
         */
        function __construct()
        {
            parent::__construct();
            $this->setTableName('t_user_resource');
            $this->setPrimaryKey('pk_i_id');
            $this->setFields( array('pk_i_id', 'fk_i_user_id', 's_extension', 's_name', 's_content_type', 's_path') );
        }

        /**
         * Get all resources
         *
         * @access public
         * @since unknown
         * @return array of resources
         */
        public function getAllResources()
        {
            $this->dao->select('r.*, c.dt_reg_date');
            $this->dao->from($this->getTableName() . ' r');
            $this->dao->join($this->getTableUserName() . ' c', 'c.pk_i_id = r.fk_i_user_id');

            $result = $this->dao->get();

            if( $result == false ) {
                return array();
            }

            return $result->result();
        }

        /**
         * Get all resources belong to an User given its id
         *
         * @access public
         * @since 2.3.7
         * @param int $userId User id
         * @return array of resources
         */
        public function getAllResourcesFromUser($userId) {
            $this->dao->select();
            $this->dao->from($this->getTableName());
            $this->dao->where('fk_i_user_id', (int)$userId);

            $result = $this->dao->get();

            if( $result == false ) {
                return array();
            }

            return $result->result();
        }

        /**
         * Get first resource belong to an user given it id
         *
         * @access public
         * @since unknown
         * @param int $userId User id
         * @return array resource
         */
        function getResource($userId)
        {
            $this->dao->select( $this->getFields() );
            $this->dao->from( $this->getTableName() );
            $this->dao->where('fk_i_user_id', $userId);
            $this->dao->limit(1);

            $result = $this->dao->get();

            if($result == false) {
                return array();
            }

            if($result->numRows == 0) {
                return array();
            }

            return $result->row();
        }

        /**
         * Check if resource id and name exist
         *
         * @access public
         * @since unknown
         * @param int $resourceId
         * @param string $code
         * @return bool
         */
        function existResource($resourceId, $code)
        {
            $this->dao->select('COUNT(*) AS numrows');
            $this->dao->from( $this->getTableName() );
            $this->dao->where('pk_i_id', $resourceId);
            $this->dao->where('s_name', $code);

            $result = $this->dao->get();

            if( $result == false ) {
                return 0;
            }

            if( $result->numRows() != 1 ) {
                return 0;
            }

            $row = $result->row();
            return $row['numrows'];
        }

        /**
         * Count resouces belong to user given its id
         *
         * @access public
         * @since unknown
         * @param int $userId User id
         * @return int
         */
        function countResources($userId = null)
        {
            $this->dao->select('COUNT(*) AS numrows');
            $this->dao->from( $this->getTableName() );
            if( !is_null($userId) && is_numeric($userId)) {
                $this->dao->where('fk_i_user_id', $userId);
            }

            $result = $this->dao->get();

            if( $result == false ) {
                return 0;
            }

            if( $result->numRows() != 1 ) {
                return 0;
            }

            $row = $result->row();
            return $row['numrows'];
        }

        /**
         * Get resources, if $userId is set return resources belong to an user given its id,
         * can be filtered by $start/$end and ordered by column.
         *
         * @access public
         * @since unknown
         * @param int $userId user id
         * @param int $start beginig
         * @param int $length ending
         * @param string $order column order default='pk_i_id'
         * @param string $type order type [DESC|ASC]
         * @return array of resources
         */
        function getResources($userId = NULL, $start = 0, $length = 10, $order = 'r.pk_i_id', $type = 'DESC')
        {
            if( !in_array($order, array(  0=> 'r.pk_i_id',
                    1=> 'r.pk_i_id',
                    2=> 'r.fk_i_user_id')) ) {
                // order by is incorrect
                return array();
            }

            if( !in_array(strtoupper($type), array('DESC', 'ASC')) ) {
                // order type is incorrect
                return array();
            }

            $this->dao->from($this->getTableName() . ' r');
            if( !is_null($userId) && is_numeric($userId) ) {
                $this->dao->where('r.fk_i_user_id', $userId);
            }
            $this->dao->orderBy($order, $type);
            $this->dao->limit($start);
            $this->dao->offset($length);
            $result = $this->dao->get();

            if( $result == false ) {
                return array();
            }

            return $result->result();
        }

        /**
         * Delete all resources where id is in $ids
         *
         * @param array $ids
         */
        public function deleteResourcesIds($ids)
        {
            $this->dao->whereIn('pk_i_id', $ids);
            return $this->dao->delete( $this->getTableName() );
        }

        /**
         * Return table user name
         *
         * @access public
         * @since unknown
         * @return string table name
         */
        function getTableUserName()
        {
            return $this->getTablePrefix() . 't_user';
        }
    }

    /* file end*/
?>