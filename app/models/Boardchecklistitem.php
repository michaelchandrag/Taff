<?php

class Boardchecklistitem extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="itemId", type="string", length=20, nullable=false)
     */
    public $itemId;

    /**
     *
     * @var string
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
     * @Column(column="itemTitle", type="string", length=20, nullable=false)
     */
    public $itemTitle;

    /**
     *
     * @var string
     * @Column(column="itemChecked", type="string", length=1, nullable=false)
     */
    public $itemChecked;

    /**
     *
     * @var string
     * @Column(column="itemStatus", type="string", length=20, nullable=false)
     */
    public $itemStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardchecklistitem");
        $this->belongsTo('checklistId', '\Boardchecklist', 'checklistId', ['alias' => 'Boardchecklist']);
        $this->belongsTo('cardId', '\Boardcard', 'cardId', ['alias' => 'Boardcard']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardchecklistitem';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardchecklistitem[]|Boardchecklistitem|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardchecklistitem|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countChecklistItem()
    {
        $item = Boardchecklistitem::find();
        return count($item);
    }

    public function insertBoardChecklistItem($checklistId,$cardId,$title,$checked,$status)
    {
        $item               = new Boardchecklistitem();
        $index              = $item->countChecklistItem();
        $id                 = "BCI".str_pad($index,5,'0',STR_PAD_LEFT);
        $item->itemId       = $id;
        $item->checklistId  = $checklistId;
        $item->cardId       = $cardId;
        $item->itemTitle    = $title;
        $item->itemChecked  = $checked;
        $item->itemStatus   = $status;
        $item->save();
    }

    public function deleteChecklistItem($itemId)
    {
        $item = Boardchecklistitem::findFirst(
            [
                "itemId='".$itemId."'"
            ]
        );
        $item->itemStatus = "0";
        $item->save();
    }

    public function changeItemChecked($itemId,$checked)
    {
        $item = Boardchecklistitem::findFirst(
            [
                "itemId='".$itemId."'"
            ]
        );
        $item->itemChecked = $checked;
        $item->save();
    }
}
