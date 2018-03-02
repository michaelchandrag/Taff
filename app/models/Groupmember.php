<?php

class Groupmember extends \Phalcon\Mvc\Model
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
     * @Column(column="groupUserId", type="string", length=20, nullable=false)
     */
    public $groupUserId;

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
     * @Column(column="memberStatus", type="string", length=20, nullable=false)
     */
    public $memberStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("groupmember");
        $this->belongsTo('userId', '\User', 'userId', ['alias' => 'User']);
        $this->belongsTo('groupUserId', '\Groupuser', 'groupId', ['alias' => 'Groupuser']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'groupmember';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Groupmember[]|Groupmember|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Groupmember|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countMember()
    {
        $member = Groupmember::find();
        return count($member);
    }

    public function insertGroupMember($userId,$groupId,$role,$status)
    {
        $groupMember = new Groupmember();
        $index = Groupmember::countMember();
        $id = "GM".str_pad($index,3,'0',STR_PAD_LEFT);
        $groupMember->memberId = $id;
        $groupMember->userId = $userId;
        $groupMember->groupUserId = $groupId;
        $groupMember->memberCreated = date("Y-m-d h:i:sa");
        $groupMember->memberRole = $role;
        $groupMember->memberStatus = $status;
        $groupMember->save();
    }

    public function findGroup($id)
    {
        $groupMember = Groupmember::find(
            [
                "userId = '".$id."'"
            ]

        );
        return $groupMember;

    }

}
