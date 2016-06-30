<?php

class Madhouse_Messenger_Views_ThreadSummary extends Madhouse_Messenger_ThreadSummary
{
    /**
     * The user that is looking at this message.
     * @var Madhouse_User
     * @since 1.10
     */
    protected $viewer;

    /**
     * The number of unread messages the thread has from the viewer location.
     * @var int
     * @since 1.10
     */
    protected $count_unread;

    public function __construct($viewer, $thread, $nbUnread)
    {
        parent::__construct(
            $thread->getId(),
            new Madhouse_Messenger_Views_Message($viewer, $thread->getLastMessage()),
            $thread->getNumberOfMessages()
        );
        $this->withTitle($thread->getTitle());
        $this->withItem($thread->getItem());
        $this->withStatus($thread->getStatus());
        $this->setLabels($thread->getLabels());

        $this->viewer = $viewer;
        $this->count_unread = $nbUnread;
    }

    /**
     * Returns the URL of the image of the thread.
     *
     * Returns the avatar of the first other users (all but the viewer).
     *
     * @return a string.
     * @since 1.10
     */
    public function getThumbnail()
    {
        $o = $this->getOthers();
        if(empty($o)) {
            return $this->viewer->getAvatar();
        }
        return array_shift($o)->getAvatar();
    }

    /**
     * Returns the excerpt of the thread.
     * @return a string.
     * @since 1.10
     */
    public function getExcerpt()
    {
        return $this->getLastMessage()->getExcerpt();
    }

    /**
     * Returns the date of last activity of this thread.
     * @return a date string.
     * @since 1.10
     */
    public function getLastActivity()
    {
        return $this->getLastMessage()->getSentDate();
    }

    /**
     * Is the viewer the sender of the last message ?
     * @return true/false.
     * @since 1.10
     */
    public function isLastSender()
    {
        return ($this->getLastMessage()->getSender()->getId() == $this->viewer->getId()) ? true : false;
    }

    /**
     * Is the viewer owner of the item linked to this thread ?
     * @return true/false.
     * @since 1.10
     */
    public function isItemOwner()
    {
        if($this->hasItem()) {
            return ($this->viewer->getId() == $this->getItem()->getUserId()) ? true : false;
        }
        return false;
    }

    public function getOthers()
    {
        return Madhouse_Utils_Collections::filterById($this->getUsers(), $this->viewer->getId());
    }

    public function countUnreadMessages()
    {
        return $this->count_unread;
    }

    public function hasUnreadMessages()
    {
        return ($this->countUnreadMessages()) ? true : false;
    }

    public function getUsersLabels()
    {
        return $this->getUserLabels($this->viewer);
    }

    public function hasLabel($label, $user = null)
    {
        if (is_null($user)) {
            $user = $this->viewer;
        }

        return parent::hasLabel($label, $user);
    }

    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            array(
                "thumbnail" => $this->getThumbnail(),
                "excerpt" => $this->getExcerpt(),
                "last_activity" => array(
                    "fb_formatted" => Madhouse_Utils_Dates::smartDate($this->getLastActivity())
                ),
                "is_read" => $this->getLastMessage()->isRead(),
                "is_last_sender" => $this->isLastSender(),
                "is_item_owner" => $this->isItemOwner(),
                "has_unread" => $this->hasUnreadMessages()
            )
        );
    }
}

?>