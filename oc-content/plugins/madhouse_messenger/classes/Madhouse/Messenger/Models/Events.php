<?php

/**
 *
 *
 *
 * @since 1.10
 */
class Madhouse_Messenger_Models_Events extends Madhouse_DAO_BaseDAO
{
	/**
	 * Singleton.
	 */
	private static $instance;

	/**
     * Singleton constructor.
     * @return an MadhouseMessengerDAO object.
     */
    public static function newInstance()
    {
        if(!self::$instance instanceof self) {
            $cache = new Madhouse_Cache_ArrayCache();
            $helper = new Madhouse_DAO_CacheHelper($cache);
            self::$instance = new self($helper);
        }
        return self::$instance;
    }

    public function __construct($helper)
    {
        // Setup the helper.
        $helper->setTableName('t_mmessenger_events');
        $helper->setFields(
            array(
                "id",
                "name"
            )
        );
        $helper->setPrimaryKey("id");

        // Init the DAO.
        parent::__construct($helper);
    }

    public function getDescriptionTableName()
    {
        return $this->helper->getTablePrefix() . 't_mmessenger_events_description';
    }

    /**
     * Finds an event by name.
     * @param $name name of the event that we're looking for.
     * @returns MadhouseMessengerEvent object.
     * @throws Exception if no event is found for $name name.
     * @see Madhouse_Utils_Models::findByName
     * @since 1.10
     */
    public function findByName($name, $raw = false)
    {
        return $this->helper->findOneBy(
            array(
                "name" => $name
            ),
            array($this, "buildObject")
        );
    }

    public function create($event)
    {
        $that = $this;
        $eventId = $this->helper->insert(
            array(
                "name" => $event->getName()
            )
        );

        // Insert description.
        $event->setId($eventId);
        $this->insertDescription($event);

        return $this->findByPrimaryKey($eventId);
    }

    public function insertDescription($event)
    {
        // Insert locales, for every available one.
        foreach (osc_listLanguageCodes() as $code) {
            $this->helper->dao->insert(
                $this->getDescriptionTableName(),
                array(
                    "fk_i_event_id" => $event->getId(),
                    "fk_c_locale_code" => $code,
                    "s_excerpt" => $event->getExcerpt($code),
                    "s_text" => $event->getText($code)
                )
            );
        }
    }

    /**
     * Build (constitute) the object that will be returned to controllers/views.
     * @param $e associative array that contains data to create the event.
     * @returns MadhouseMessengerEvent object.
     * @since 1.10
     */
    public function buildObject($row)
    {
        return new Madhouse_Messenger_Event(
            array_merge(
                $row,
                array(
                    "locale" => Madhouse_Utils_Models::extendData(
                        $this->helper,
                        $this->getDescriptionTableName(),
                        "fk_i_event_id",
                        $row
                    )
                )
            )
        );
    }
}

?>