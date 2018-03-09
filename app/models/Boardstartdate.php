<?php

class Boardstartdate extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="startDateId", type="string", length=20, nullable=false)
     */
    public $startDateId;

    /**
     *
     * @var string
     * @Column(column="cardId", type="string", length=20, nullable=false)
     */
    public $cardId;

    /**
     *
     * @var string
     * @Column(column="startDate", type="string", nullable=false)
     */
    public $startDate;

    /**
     *
     * @var string
     * @Column(column="startDateStatus", type="string", length=20, nullable=false)
     */
    public $startDateStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardstartdate");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardstartdate';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardstartdate[]|Boardstartdate|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardstartdate|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countStartDate()
    {
        $date = Boardstartdate::find();
        return count($date);
    }

    public function insertBoardStartDate($cardId,$startDate,$status)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = new Boardstartdate();
        $index = $date->countStartDate();
        $id = "BSD".str_pad($index,3,'0',STR_PAD_LEFT);
        $date->startDateId = $id;
        $date->cardId = $cardId;
        $date->startDate = date("Y-m-d H:i:sa",$startDate);
        $date->startDateStatus = $status;
        $date->save();
    }

}