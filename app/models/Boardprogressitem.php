<?php

class Boardprogressitem extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="progressItemId", type="string", length=20, nullable=false)
     */
    public $progressItemId;

    /**
     *
     * @var string
     * @Column(column="boardId", type="string", length=20, nullable=false)
     */
    public $boardId;

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
     * @Column(column="itemStatus", type="string", length=1, nullable=false)
     */
    public $itemStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardprogressitem");
        $this->belongsTo('boardId', '\Board', 'boardId', ['alias' => 'Board']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardprogressitem';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardprogressitem[]|Boardprogressitem|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardprogressitem|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countProgressItem()
    {
        $item = Boardprogressitem::find();
        return count($item);
    }

    public function insertBoardProgressItem($boardId,$title,$checked,$status)
    {
        $item               = new Boardprogressitem();
        $index              = $item->countProgressItem();
        $id                 = "BPI".str_pad($index,5,'0',STR_PAD_LEFT);
        $item->progressItemId       = $id;
        $item->boardId      = $boardId;
        $item->itemTitle    = $title;
        $item->itemChecked  = $checked;
        $item->itemStatus   = $status;
        $item->save();
    }

    public function deleteProgressItem($itemId,$status)
    {
        $item = Boardprogressitem::findFirst(
            [
                "progressItemId='".$itemId."'"
            ]
        );
        $item->itemStatus = $status;
        $item->save();
    }

    public function changeProgressItem($itemId,$status)
    {
        $item = Boardprogressitem::findFirst(
            [
                "progressItemId='".$itemId."'"
            ]
        );
        $item->itemChecked = $status;
        $item->save();
    }

}
