<?php

class Boardduedate extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="dueDateId", type="string", length=20, nullable=false)
     */
    public $dueDateId;

    /**
     *
     * @var string
     * @Column(column="cardId", type="string", length=20, nullable=false)
     */
    public $cardId;

    /**
     *
     * @var string
     * @Column(column="dueDate", type="string", nullable=false)
     */
    public $dueDate;

    /**
     *
     * @var string
     * @Column(column="dueDateChecked", type="string", length=1, nullable=false)
     */
    public $dueDateChecked;

    /**
     *
     * @var string
     * @Column(column="dueDateStatus", type="string", length=1, nullable=false)
     */
    public $dueDateStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardduedate");
        $this->belongsTo('cardId', '\Boardcard', 'cardId', ['alias' => 'Boardcard']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardduedate';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardduedate[]|Boardduedate|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardduedate|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countDueDate()
    {
        $date = Boardduedate::find();
        return count($date);
    }

    public function insertBoardDueDate($cardId,$dueDate,$checked,$status)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date                   = new Boardduedate();
        $index                  = $date->countDueDate();
        $id                     = "BDD".str_pad($index,3,'0',STR_PAD_LEFT);
        $date->dueDateId        = $id;
        $date->cardId           = $cardId;
        $date->dueDate          = date("Y-m-d H:i:sa",$dueDate);
        $date->dueDateChecked   = $checked;
        $date->dueDateStatus    = $status;
        $date->save();
    }

}
