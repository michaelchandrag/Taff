<?php

class Boardchecklist extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="checklistId", type="string", length=20, nullable=false)
     */
    public $checklistId;

    /**
     *
     * @var string
     * @Column(column="cardId", type="string", length=20, nullable=false)
     */
    public $cardId;

    /**
     *
     * @var string
     * @Column(column="checklistTitle", type="string", length=20, nullable=false)
     */
    public $checklistTitle;

    /**
     *
     * @var string
     * @Column(column="checklistStatus", type="string", length=20, nullable=false)
     */
    public $checklistStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardchecklist");
        $this->hasMany('checklistId', 'Boardchecklistitem', 'checklistId', ['alias' => 'Boardchecklistitem']);
        $this->belongsTo('cardId', '\Boardcard', 'cardId', ['alias' => 'Boardcard']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardchecklist';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardchecklist[]|Boardchecklist|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardchecklist|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countChecklist()
    {
        $checklist = Boardchecklist::find();
        return count($checklist);
    }

    public function insertBoardChecklist($cardId,$title,$status)
    {
        $checklist = new Boardchecklist();
        $index = $checklist->countChecklist();
        $id = "BCL".str_pad($index,5,'0',STR_PAD_LEFT);
        $checklist->checklistId = $id;
        $checklist->cardId = $cardId;
        $checklist->checklistTitle = $title;
        $checklist->checklistStatus = $status;
        $checklist->save();
    }

}
