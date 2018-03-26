<?php

class Boardchat extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Column(column="chatId", type="string", length=20, nullable=false)
     */
    public $chatId;

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
     * @Column(column="chatText", type="string", length=99, nullable=false)
     */
    public $chatText;

    /**
     *
     * @var string
     * @Column(column="chatCreated", type="string", nullable=false)
     */
    public $chatCreated;

    /**
     *
     * @var string
     * @Column(column="chatStatus", type="string", length=1, nullable=false)
     */
    public $chatStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardchat");
        $this->belongsTo('boardId', '\Board', 'boardId', ['alias' => 'Board']);
        $this->belongsTo('userId', '\User', 'userId', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardchat';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardchat[]|Boardchat|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardchat|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countChat()
    {
        $chat = Boardchat::find();
        return count($chat);
    }

    public function insertBoardChat($boardId,$userId,$chatText,$status)
    {
        date_default_timezone_set('Asia/Jakarta');
        $chat = new Boardchat();
        $index = $chat->countChat();
        $id = "BCH".str_pad($index,5,'0',STR_PAD_LEFT);
        $chat->chatId = $id;
        $chat->boardId = $boardId;
        $chat->userId = $userId;
        $chat->chatText = $chatText;
        $chat->chatCreated = date("Y-m-d H:i:sa");
        $chat->chatStatus = $status;
        $chat->save();
    }

}
