<?php

class Boardprogressdate extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="dateId", type="string", length=20, nullable=false)
     */
    public $dateId;

    /**
     *
     * @var string
     * @Column(column="boardId", type="string", length=20, nullable=false)
     */
    public $boardId;

    /**
     *
     * @var string
     * @Column(column="date", type="string", nullable=false)
     */
    public $date;

    /**
     *
     * @var string
     * @Column(column="dateStatus", type="string", length=1, nullable=false)
     */
    public $dateStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardprogressdate");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardprogressdate';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardprogressdate[]|Boardprogressdate|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardprogressdate|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countDate()
    {
        $date = Boardprogressdate::find();
        return count($date);
    }

    public function insertBoardProgressDate($boardId,$d,$status)
    {
        $date                       = new Boardprogressdate();
        $index                      = $date->countDate();
        $id                         = "BPD".str_pad($index,3,'0',STR_PAD_LEFT);
        $date->dateId               = $id;
        $date->boardId              = $boardId;
        $date->date                 = date("Y-m-d H:i:sa",$d);
        $date->dateStatus           = $status;
        $date->save();
    }

    public function setDate($dateId,$d)
    {
        $date = Boardprogressdate::findFirst(
            [
                "dateId='".$dateId."'"
            ]
        );
        $date->date = date("Y-m-d H:i:sa",$d);
        $date->save();
    }

}
