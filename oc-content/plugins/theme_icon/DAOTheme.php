<?php

/**
 * Created by WTEH.
 * Date: 3/20/2016
 * Time: 12:35 AM
 */
class DAOTheme extends DAO {

    /**
     * @var
     */
    private static $instance;

    /**
     *
     */
    function __construct() {
        parent::__construct();
        $this->setTableName('t_themes');
        $this->setPrimaryKey('id');
        $this->setFields(array('id', 'name', 'image'));
    }

    /**
     * @return DAOCategoryIcon
     */
    public static function newInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * @param $id
     * @return array
     */
    public function find_theme_by_id($id) {
        $this->dao->select('*');
        $this->dao->from($this->getTableName());
        $this->dao->where('id', $id);
        $result = $this->dao->get();

        if ($result == false) {
            return array();
        }

        return $result->result();
    }

    /**
     * @return array
     */
    public function get_all_theme() {
        $this->dao->select('*');
        $this->dao->from($this->getTableName());
        $result = $this->dao->get();

        if ($result == false) {
            return array();
        }

        return $result->result();
    }

    /**
     * @return array
     */
    public function add_theme(array $values) {
        return $this->dao->insert($this->getTableName(), $values);
    }

    /**
     * @return array
     */
    public function update_theme(array $values, array $conditions) {
//        $this->dao->set($values);
//        $this->dao->where($conditions);
        $result = $this->dao->update($this->getTableName(), $values, $conditions);
        if ($result == false) {
            return array();
        }

        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete_theme_by_id($id) {
        $cond = array(
            $this->getPrimaryKey() => $id
        );

        return $this->delete($cond);
    }

    /**
     * @param $sql
     * @return bool
     */
    public function importSql($sql) {
        return $this->dao->importSQL($sql);
    }

}
