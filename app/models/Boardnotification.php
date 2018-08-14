<?php

class Boardnotification extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="notificationId", type="string", length=20, nullable=false)
     */
    public $notificationId;

    /**
     *
     * @var string
     * @Column(column="boardId", type="string", length=20, nullable=false)
     */
    public $boardId;

    /**
     *
     * @var string
     * @Column(column="userId", type="string", length=20, nullable=false)
     */
    public $userId;

    /**
     *
     * @var string
     * @Column(column="message", type="string", length=256, nullable=false)
     */
    public $message;

    /**
     *
     * @var string
     * @Column(column="notificationStatus", type="string", length=1, nullable=false)
     */
    public $notificationStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardnotification");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardnotification';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardnotification[]|Boardnotification|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardnotification|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countNotification()
    {
        $notification = Boardnotification::find();
        return count($notification);
    }

    public function insertBoardNotification($boardId,$userId,$message,$status)
    {
        $notification               = new Boardnotification();
        $index              = $notification->countNotification();
        $id                 = "BN".str_pad($index,5,'0',STR_PAD_LEFT);
        $notification->notificationId       = $id;
        $notification->boardId      = $boardId;
        $notification->userId    = $userId;
        $notification->message  = $message;
        $notification->notificationStatus   = $status;
        $notification->save();
    }

}
