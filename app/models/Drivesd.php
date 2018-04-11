<?php

class Drivesd extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="driveSdId", type="string", length=20, nullable=false)
     */
    public $driveSdId;

    /**
     *
     * @var string
     * @Column(column="startDateId", type="string", length=20, nullable=false)
     */
    public $startDateId;

    /**
     *
     * @var string
     * @Column(column="driveId", type="string", length=20, nullable=false)
     */
    public $driveId;

    /**
     *
     * @var string
     * @Column(column="driveSdStatus", type="string", length=1, nullable=false)
     */
    public $driveSdStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("drivesd");
        $this->belongsTo('startDateId', '\Boardstartdate', 'startDateId', ['alias' => 'Boardstartdate']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'drivesd';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Drivesd[]|Drivesd|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Drivesd|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countSd()
    {
        $sd = Drivesd::find();
        return count($sd);
    }

    public function insertDriveSd($startDateId,$driveId,$status)
    {
        $sd = new Drivesd();
        $index = $sd->countSd();
        $id = "SD".str_pad($index,5,'0',STR_PAD_LEFT);
        $sd->driveSdId = $id;
        $sd->startDateId = $startDateId;
        $sd->driveId = $driveId;
        $sd->driveSdStatus = $status;
        $sd->save();
    }


}
