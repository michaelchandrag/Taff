<?php

class Groupuser extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="groupId", type="string", length=20, nullable=false)
     */
    public $groupId;

    /**
     *
     * @var string
     * @Column(column="groupName", type="string", length=30, nullable=false)
     */
    public $groupName;

    /**
     *
     * @var string
     * @Column(column="groupCreated", type="string", nullable=false)
     */
    public $groupCreated;

    /**
     *
     * @var string
     * @Column(column="groupStatus", type="string", length=1, nullable=false)
     */
    public $groupStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("groupuser");
        $this->hasMany('groupId', 'Board', 'boardOwner', ['alias' => 'Board']);
        $this->hasMany('groupId', 'Groupmember', 'groupUserId', ['alias' => 'Groupmember']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'groupuser';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Groupuser[]|Groupuser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Groupuser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countGroup()
    {
        $group = Groupuser::find();
        return count($group);
    }

    public function insertGroupUser($name,$status)
    {
        date_default_timezone_set('Asia/Jakarta');
        $groupUser = new Groupuser();
        $index = Groupuser::countGroup();
        $id = "GU".str_pad($index,3,'0',STR_PAD_LEFT);
        $groupUser->groupId = $id;
        $groupUser->groupName = $name;
        $groupUser->groupCreated = date("Y-m-d H:i:sa");
        $groupUser->groupStatus = $status;
        $groupUser->save();
    }

    public function findGroupByMember($id)
    {
        $groupUser = Groupuser::find(
            [
                "groupId='".$id."'" 
            ]

        );
        return $groupUser;
    }

}
