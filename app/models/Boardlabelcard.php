<?php

class Boardlabelcard extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="labelId", type="string", length=20, nullable=false)
     */
    public $labelId;

    /**
     *
     * @var string
     * @Column(column="boardId", type="string", length=20, nullable=false)
     */
    public $boardId;

    /**
     *
     * @var string
     * @Column(column="cardId", type="string", length=20, nullable=false)
     */
    public $cardId;

    /**
     *
     * @var string
     * @Column(column="labelRed", type="string", length=5, nullable=false)
     */
    public $labelRed;

    /**
     *
     * @var string
     * @Column(column="labelYellow", type="string", length=5, nullable=false)
     */
    public $labelYellow;

    /**
     *
     * @var string
     * @Column(column="labelGreen", type="string", length=5, nullable=false)
     */
    public $labelGreen;

    /**
     *
     * @var string
     * @Column(column="labelBlue", type="string", length=5, nullable=false)
     */
    public $labelBlue;

    /**
     *
     * @var string
     * @Column(column="labelStatus", type="string", length=1, nullable=false)
     */
    public $labelStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardlabelcard");
        $this->belongsTo('boardId', '\Board', 'boardId', ['alias' => 'Board']);
        $this->belongsTo('cardId', '\Boardcard', 'cardId', ['alias' => 'Boardcard']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardlabelcard';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardlabelcard[]|Boardlabelcard|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardlabelcard|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countLabel()
    {
        $label = Boardlabelcard::find();
        return count($label);
    }

    public function insertBoardLabelCard($boardId,$cardId,$red,$yellow,$green,$blue,$status)
    {
        $label = new Boardlabelcard();
        $index = $label->countLabel();
        $id ="BLC".str_pad($index,5,'0',STR_PAD_LEFT);
        $label->labelId = $id;
        $label->boardId = $boardId;
        $label->cardId = $cardId;
        $label->labelRed = $red;
        $label->labelYellow = $yellow;
        $label->labelGreen = $green;
        $label->labelBlue = $blue;
        $label->labelStatus = $status;
        $label->save();

    }

    public function setColor($cardId,$red,$yellow,$green,$blue)
    {
        $label = Boardlabelcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $label->labelRed = $red;
        $label->labelYellow = $yellow;
        $label->labelGreen = $green;
        $label->labelBlue = $blue;
        $label->save();
    }

}
