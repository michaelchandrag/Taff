<?php

class Boardreplycomment extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="replyId", type="string", length=20, nullable=false)
     */
    public $replyId;

    /**
     *
     * @var string
     * @Column(column="commentId", type="string", length=20, nullable=false)
     */
    public $commentId;

    /**
     *
     * @var string
     * @Column(column="cardId", type="string", length=20, nullable=false)
     */
    public $cardId;

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
     * @Column(column="replyText", type="string", length=99, nullable=false)
     */
    public $replyText;

    /**
     *
     * @var string
     * @Column(column="replyCreated", type="string", nullable=false)
     */
    public $replyCreated;

    /**
     *
     * @var string
     * @Column(column="replyStatus", type="string", length=20, nullable=false)
     */
    public $replyStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardreplycomment");
        $this->belongsTo('boardId', '\Board', 'boardId', ['alias' => 'Board']);
        $this->belongsTo('cardId', '\Boardcard', 'cardId', ['alias' => 'Boardcard']);
        $this->belongsTo('commentId', '\Boardcomment', 'commentId', ['alias' => 'Boardcomment']);
        $this->belongsTo('userId', '\User', 'userId', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardreplycomment';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardreplycomment[]|Boardreplycomment|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardreplycomment|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countReply()
    {
        $reply = Boardreplycomment::find();
        return count($reply);
    }

    public function insertBoardReplyComment($commentId,$cardId,$boardId,$userId,$replyText,$status)
    {
        date_default_timezone_set('Asia/Jakarta');
        $reply = new Boardreplycomment();
        $index = $reply->countReply();
        $id = "BRC".str_pad($index,5,'0',STR_PAD_LEFT);
        $reply->replyId = $id;
        $reply->commentId = $commentId;
        $reply->cardId = $cardId;
        $reply->boardId = $boardId;
        $reply->userId = $userId;
        $reply->replyText = $replyText;
        $reply->replyCreated = date("Y-m-d H:i:sa");
        $reply->replyStatus = $status;
        $reply->save();

    }

}
