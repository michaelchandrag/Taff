<?php

class Boardgroup extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="boardGroupId", type="string", length=20, nullable=false)
     */
    public $boardGroupId;

    /**
     *
     * @var string
     * @Column(column="boardId", type="string", length=20, nullable=false)
     */
    public $boardId;

    /**
     *
     * @var string
     * @Column(column="groupId", type="string", length=20, nullable=false)
     */
    public $groupId;

    /**
     *
     * @var string
     * @Column(column="boardTitle", type="string", length=20, nullable=false)
     */
    public $boardTitle;

    /**
     *
     * @var string
     * @Column(column="boardGroupStatus", type="string", length=20, nullable=false)
     */
    public $boardGroupStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardgroup");
        $this->belongsTo('boardId', '\Board', 'boardId', ['alias' => 'Board']);
        $this->belongsTo('groupId', '\Groupuser', 'groupId', ['alias' => 'Groupuser']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardgroup';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardgroup[]|Boardgroup|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardgroup|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countBoardGroup()
    {
         $board = Boardgroup::find();
         return count($board);
    }

    public function insertBoardGroup($boardId,$groupId,$boardTitle,$status)
    {
        $board = new Boardgroup();
        $index = $board->countBoardGroup();
        $id = "BG".str_pad($index,5,'0',STR_PAD_LEFT);
        $board->boardGroupId = $id;
        $board->boardId = $boardId;
        $board->groupId = $groupId;
        $board->boardTitle = $boardTitle;
        $board->boardGroupStatus = $status;
        $board->save();
    }

}
