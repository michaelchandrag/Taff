<?php

class Board extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="boardId", type="string", length=20, nullable=false)
     */
    public $boardId;

    /**
     *
     * @var string
     * @Column(column="boardOwner", type="string", length=20, nullable=false)
     */
    public $boardOwner;

    /**
     *
     * @var string
     * @Column(column="boardTitle", type="string", length=20, nullable=false)
     */
    public $boardTitle;

    /**
     *
     * @var string
     * @Column(column="boardCreated", type="string", nullable=false)
     */
    public $boardCreated;

    /**
     *
     * @var string
     * @Column(column="boardPublic", type="string", length=20, nullable=false)
     */
    public $boardPublic;

    /**
     *
     * @var string
     * @Column(column="boardClosed", type="string", length=20, nullable=false)
     */
    public $boardClosed;

    /**
     *
     * @var string
     * @Column(column="boardGroup", type="string", length=1, nullable=false)
     */
    public $boardGroup;

    /**
     *
     * @var string
     * @Column(column="boardStatus", type="string", length=20, nullable=false)
     */
    public $boardStatus;

    /**
     *
     * @var string
     * @Column(column="boardBackground", type="string", length=20, nullable=false)
     */
    public $boardBackground;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("board");
        $this->hasMany('boardId', 'Boardlist', 'listBoardId', ['alias' => 'Boardlist']);
        $this->hasMany('boardId', 'Boardmember', 'boardId', ['alias' => 'Boardmember']);
        $this->belongsTo('boardOwner', '\User', 'userId', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'board';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Board[]|Board|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Board|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countBoard()
    {
         $board = Board::find();
         return count($board);
    }

    public function insertBoard($owner,$title,$public,$group,$status,$background)
    {
        $board = new Board();
        $index = $board->countBoard();
        $id = "BO".str_pad($index,5,'0',STR_PAD_LEFT);
        $board->boardId = $id;
        $board->boardOwner = $owner;
        $board->boardTitle = $title;
        $board->boardCreated = date("Y-m-d H:i:sa");
        $board->boardPublic = $public;
        $board->boardGroup = $group;
        $board->boardClosed = '0';
        $board->boardStatus = $status;
        $board->boardBackground = $background;
        $board->save();
    }

    public function findBoardByUser($id)
    {
        $board = Board::find(
            [
                'boardOwner="'.$id.'"' 
            ]
        );
        return $board;
    }

    public function setBackground($boardId,$color)
    {
        $board = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $board->boardBackground = $color;
        $board->save();
    }

    public function setTitle($boardId,$title)
    {
        $board = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $board->boardTitle = $title;
        $board->save();
    }

    public function setAll($boardOwner,$boardTitle,$boardGroup,$boardClosed,$boardStatus,$boardBackground)
    {
        $this->boardOwner = $boardOwner;
        $this->boardTitle = $boardTitle;
        //$board->boardCreated = date("Y-m-d H:i:sa");
        //$board->boardPublic = $public;
        $this->boardGroup = $boardGroup;
        $this->boardClosed = $boardClosed;
        $this->boardStatus = $boardStatus;
        $this->boardBackground = $boardBackground;
        $this->save();
    }
}
