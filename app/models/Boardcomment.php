<?php

class Boardcomment extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
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
     * @Column(column="commentText", type="string", length=99, nullable=false)
     */
    public $commentText;

    /**
     *
     * @var string
     * @Column(column="commentCreated", type="string", nullable=false)
     */
    public $commentCreated;

    /**
     *
     * @var string
     * @Column(column="commentStatus", type="string", length=1, nullable=false)
     */
    public $commentStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardcomment");
        $this->hasMany('commentId', 'Boardreplycomment', 'commentId', ['alias' => 'Boardreplycomment']);
        $this->belongsTo('cardId', '\Boardcard', 'cardId', ['alias' => 'Boardcard']);
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
        return 'boardcomment';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardcomment[]|Boardcomment|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardcomment|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countComment()
    {
        $comment = Boardcomment::find();
        return count($comment);
    }

    public function insertBoardComment($cardId,$boardId,$userId,$commentText,$status)
    {
        $comment = new Boardcomment();
        $index = $comment->countComment();
        $id = "BUC".str_pad($index,5,'0',STR_PAD_LEFT);
        $comment->commentId = $id;
        $comment->cardId = $cardId;
        $comment->boardId = $boardId;
        $comment->userId = $userId;
        $comment->commentText = $commentText;
        $comment->commentCreated = date("Y-m-d H:i:sa");
        $comment->commentStatus = $status;
        $comment->save();
    }

    public function deleteComment($commentId)
    {
        $comment = Boardcomment::findFirst(
            [
                "commentId='".$commentId."'"
            ]
        );
        $comment->commentStatus = "0";
        $comment->save();
    }

    public function changeCommentText($commentId,$text)
    {
        $comment = Boardcomment::findFirst(
            [
                "commentId='".$commentId."'"
            ]
        );
        $comment->commentText = $text;
        $comment->save();
    }

}
