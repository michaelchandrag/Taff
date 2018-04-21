<?php

class Boardroleclient extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="roleId", type="string", length=20, nullable=false)
     */
    public $roleId;

    /**
     *
     * @var string
     * @Column(column="boardId", type="string", length=20, nullable=false)
     */
    public $boardId;

    /**
     *
     * @var string
     * @Column(column="listCreate", type="string", length=1, nullable=false)
     */
    public $listCreate;

    /**
     *
     * @var string
     * @Column(column="listEdit", type="string", length=1, nullable=false)
     */
    public $listEdit;

    /**
     *
     * @var string
     * @Column(column="listDelete", type="string", length=1, nullable=false)
     */
    public $listDelete;

    /**
     *
     * @var string
     * @Column(column="cardCreate", type="string", length=1, nullable=false)
     */
    public $cardCreate;

    /**
     *
     * @var string
     * @Column(column="cardEdit", type="string", length=1, nullable=false)
     */
    public $cardEdit;

    /**
     *
     * @var string
     * @Column(column="cardDelete", type="string", length=1, nullable=false)
     */
    public $cardDelete;

    /**
     *
     * @var string
     * @Column(column="activityAM", type="string", length=1, nullable=false)
     */
    public $activityAM;

    /**
     *
     * @var string
     * @Column(column="activityLabel", type="string", length=1, nullable=false)
     */
    public $activityLabel;

    /**
     *
     * @var string
     * @Column(column="activityChecklist", type="string", length=1, nullable=false)
     */
    public $activityChecklist;

    /**
     *
     * @var string
     * @Column(column="activityStartDate", type="string", length=1, nullable=false)
     */
    public $activityStartDate;

    /**
     *
     * @var string
     * @Column(column="activityDueDate", type="string", length=1, nullable=false)
     */
    public $activityDueDate;

    /**
     *
     * @var string
     * @Column(column="activityAttachment", type="string", length=1, nullable=false)
     */
    public $activityAttachment;

    /**
     *
     * @var string
     * @Column(column="roleStatus", type="string", length=1, nullable=false)
     */
    public $roleStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardroleclient");
        $this->belongsTo('boardId', '\Board', 'boardId', ['alias' => 'Board']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardroleclient';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardroleclient[]|Boardroleclient|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardroleclient|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countRoleClient()
    {
        $role = Boardroleclient::find();
        return count($role);
    }

    public function insertBoardRoleClient($boardId,$listCreate,$listEdit,$listDelete,$cardCreate,$cardEdit,$cardDelete,$activityAM,$activityLabel,$activityChecklist,$activityStartDate,$activityDueDate,$activityAttachment,$roleStatus)
    {
        $role = new Boardroleclient();
        $index = $role->countRoleClient();
        $id = "BRC".str_pad($index,5,'0',STR_PAD_LEFT);
        $role->roleId = $id;
        $role->boardId  = $boardId;
        $role->listCreate = $listCreate;
        $role->listEdit = $listEdit;
        $role->listDelete = $listDelete;
        $role->cardCreate = $cardCreate;
        $role->cardEdit = $cardEdit;
        $role->cardDelete = $cardDelete;
        $role->activityAM = $activityAM;
        $role->activityLabel = $activityLabel;
        $role->activityChecklist = $activityChecklist;
        $role->activityStartDate = $activityStartDate;
        $role->activityDueDate = $activityDueDate;
        $role->activityAttachment = $activityAttachment;
        $role->roleStatus = $roleStatus;
        $role->save();
    }

    public function setRoleClient($boardId,$listCreate,$listEdit,$listDelete,$cardCreate,$cardEdit,$cardDelete,$activityAM,$activityLabel,$activityChecklist,$activityStartDate,$activityDueDate,$activityAttachment)
    {
        $role = Boardroleclient::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $role->listCreate = $listCreate;
        $role->listEdit = $listEdit;
        $role->listDelete = $listDelete;
        $role->cardCreate = $cardCreate;
        $role->cardEdit = $cardEdit;
        $role->cardDelete = $cardDelete;
        $role->activityAM = $activityAM;
        $role->activityLabel = $activityLabel;
        $role->activityChecklist = $activityChecklist;
        $role->activityStartDate = $activityStartDate;
        $role->activityDueDate = $activityDueDate;
        $role->activityAttachment = $activityAttachment;
        $role->save();

    }

}
