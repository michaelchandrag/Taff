<?php

class Boardmember extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="memberId", type="string", length=20, nullable=false)
     */
    public $memberId;

    /**
     *
     * @var string
     * @Column(column="userId", type="string", length=20, nullable=false)
     */
    public $userId;

    /**
     *
     * @var string
     * @Column(column="boardId", type="string", length=20, nullable=false)
     */
    public $boardId;

    /**
     *
     * @var string
     * @Column(column="memberCreated", type="string", nullable=false)
     */
    public $memberCreated;

    /**
     *
     * @var string
     * @Column(column="memberRole", type="string", length=20, nullable=false)
     */
    public $memberRole;

    /**
     *
     * @var string
     * @Column(column="memberStatus", type="string", length=1, nullable=false)
     */
    public $memberStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardmember");
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
        return 'boardmember';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardmember[]|Boardmember|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardmember|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countMember()
    {
        $member = Boardmember::find();
        return count($member);
    }

    public function insertBoardMember($userId,$boardId,$role,$status)
    {
        date_default_timezone_set('Asia/Jakarta');
        $boardMember = new Boardmember();
        $index = $boardMember->countMember();
        $id = "BM".str_pad($index,3,'0',STR_PAD_LEFT);
        $boardMember->memberId = $id;
        $boardMember->userId = $userId;
        $boardMember->boardId = $boardId;
        $boardMember->memberCreated = date("Y-m-d H:i:sa");
        $boardMember->memberRole = $role;
        $boardMember->memberStatus = $status;
        $boardMember->save();
    }

}
