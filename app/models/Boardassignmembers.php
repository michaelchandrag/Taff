<?php

class Boardassignmembers extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="assignId", type="string", length=20, nullable=false)
     */
    public $assignId;

    /**
     *
     * @var string
     * @Column(column="cardId", type="string", length=20, nullable=false)
     */
    public $cardId;

    /**
     *
     * @var string
     * @Column(column="userId", type="string", length=20, nullable=false)
     */
    public $userId;

    /**
     *
     * @var string
     * @Column(column="userName", type="string", length=20, nullable=false)
     */
    public $userName;

    /**
     *
     * @var string
     * @Column(column="assignChecked", type="string", length=1, nullable=false)
     */
    public $assignChecked;

    /**
     *
     * @var string
     * @Column(column="assignStatus", type="string", length=1, nullable=false)
     */
    public $assignStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardassignmembers");
        $this->belongsTo('cardId', '\Boardcard', 'cardId', ['alias' => 'Boardcard']);
        $this->belongsTo('userId', '\User', 'userId', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardassignmembers';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardassignmembers[]|Boardassignmembers|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardassignmembers|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countAssign()
    {
        $assign = Boardassignmembers::find();
        return count($assign);
    }

    public function insertBoardAssignMembers($cardId,$userId,$userName,$checked,$status)
    {
        $assign = new Boardassignmembers();
        $index = $assign->countAssign();
        $id = "BAM".str_pad($index,5,'0',STR_PAD_LEFT);
        $assign->assignId = $id;
        $assign->cardId = $cardId;
        $assign->userId = $userId;
        $assign->userName = $userName;
        $assign->assignChecked = $checked;
        $assign->assignStatus = $status;
        $assign->save();
    }

    public function changeAssignChecked($assignId,$checked)
    {
        $assign = Boardassignmembers::findFirst(
                [
                    "assignId='".$assignId."'"
                ]
            );
        $assign->assignChecked = $checked;
        $assign->save();
    }

}
