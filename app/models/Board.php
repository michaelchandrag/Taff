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
        $this->belongsTo('boardOwner', '\Groupuser', 'groupId', ['alias' => 'Groupuser']);
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

    public function insertBoard($owner,$title,$public,$status,$background)
    {
        $board = new Board();
        $index = $board->countBoard();
        $id = "BO".str_pad($index,3,'0',STR_PAD_LEFT);
        $board->boardId = $id;
        $board->boardOwner = $owner;
        $board->boardTitle = $title;
        $board->boardCreated = date("Y-m-d h:i:sa");
        $board->boardPublic = $public;
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

}
