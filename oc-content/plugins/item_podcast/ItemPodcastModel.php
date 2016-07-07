<?php

class ItemPodcastModel extends DAO {

    private static $instance;

    public static function newInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    function __construct() {
        parent::__construct();
    }

    public function get_item_podcast_table() {
        return DB_TABLE_PREFIX . 't_item_podcasts';
    }

    public function import($file) {
        $path = osc_plugin_resource($file);
        $sql = file_get_contents($path);

        if (!$this->dao->importSQL($sql)) {
            throw new Exception("Error importSQL::DGModel<br>" . $file);
        }
    }

    public function uninstall() {
//        $this->removeAllFiles();
//        $this->dao->query("DELETE FROM %s WHERE s_plugin_name = 'digitalgoods'", $this->get_item_podcast_table());
    }

    public function getFileByItemNameCode($item, $name, $code) {
        $this->dao->select();
        $this->dao->from($this->get_item_podcast_table());
        $this->dao->where('fk_i_item_id', $item);
        $this->dao->where('s_embed_code', $name);
        $this->dao->where('s_code', $code);

        $result = $this->dao->get();
        if (!$result) {
            return array();
        }

        return $result->row();
    }

    public function getMp3File($id) {
        $this->dao->select();
        $this->dao->from($this->get_item_podcast_table());
        $this->dao->where('pk_i_id', $id);

        $result = $this->dao->get();
        if (!$result) {
            return array();
        }

        return $result->row();
    }

    public function getFilesFromItem($itemId) {
        $this->dao->select();
        $this->dao->from($this->get_item_podcast_table());
        $this->dao->where('fk_i_item_id', $itemId);

        $result = $this->dao->get();
        if (!$result) {
            return array();
        }

        return $result->result();
    }

    public function getAllFiles() {
        $this->dao->select();
        $this->dao->from($this->get_item_podcast_table());

        $result = $this->dao->get();
        if (!$result) {
            return array();
        }

        return $result->result();
    }

    public function removeAllFiles() {
        $dgs = $this->getAllFiles();
        foreach ($dgs as $dg) {
            @unlink(osc_get_preference('upload_path', 'item_podcast') . $dg['s_code'] . "_" . $dg['fk_i_item_id'] . "_" . $dg['s_embed_code']);
            @rmdir(osc_get_preference('upload_path', 'item_podcast'));
        }
        $this->dao->query('DROP TABLE %s', $this->get_item_podcast_table());
    }

    public function removeItem($itemId) {
        $dgs = $this->getFilesFromItem($itemId);
        foreach ($dgs as $dg) {
            @unlink(osc_get_preference('upload_path', 'item_podcast') . $dg['s_code'] . "_" . $dg['fk_i_item_id'] . "_" . $dg['s_embed_code']);
            $this->dao->query("DELETE FROM %s WHERE fk_i_item_id = %d", $this->get_item_podcast_table(), $dg['pk_i_id']);
        }
    }

    public function insertFile($itemId, $content, $date) {
        $aSet = array();
        $aSet['fk_i_item_id'] = $itemId;
        $aSet['s_embed_code'] = $content;
        $aSet['s_code'] = $date;
        return $this->dao->insert($this->get_item_podcast_table(), $aSet);
    }

    function updateDownloads($id, $downloads) {
        $this->dao->from($this->get_item_podcast_table());
        $this->dao->set(array('i_downloads' => $downloads));
        $this->dao->where(array('pk_i_id' => $id));
        return $this->dao->update();
    }

}

?>