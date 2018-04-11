<?php

class Boardsubscribe extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="subscribeId", type="string", length=20, nullable=false)
     */
    public $subscribeId;

    /**
     *
     * @var string
     * @Column(column="userId", type="string", length=20, nullable=false)
     */
    public $userId;

    /**
     *
     * @var string
     * @Column(column="boardId", type="string", length=20, nullable=false)
     */
    public $boardId;

    /**
     *
     * @var string
     * @Column(column="subscribeChecked", type="string", length=1, nullable=false)
     */
    public $subscribeChecked;

    /**
     *
     * @var string
     * @Column(column="subscribeStatus", type="string", length=1, nullable=false)
     */
    public $subscribeStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardsubscribe");
        $this->belongsTo('userId', '\User', 'userId', ['alias' => 'User']);
        $this->belongsTo('boardId', '\Board', 'boardId', ['alias' => 'Board']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardsubscribe';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardsubscribe[]|Boardsubscribe|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardsubscribe|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countSubscribe()
    {
        $subscribe = Boardsubscribe::find();
        return count($subscribe);
    }

    public function insertBoardSubscribe($boardId,$userId,$check,$status)
    {
        $subscribe = new Boardsubscribe();
        $index = $subscribe->countSubscribe();
        $id = "BS".str_pad($index,5,'0',STR_PAD_LEFT);
        $subscribe->subscribeId = $id;
        $subscribe->boardId = $boardId;
        $subscribe->userId = $userId;
        $subscribe->subscribeChecked = $check;
        $subscribe->subscribeStatus = $status;
        $subscribe->save();
    }

    public function setCheck($subscribeId,$check)
    {
        $subscribe = Boardsubscribe::findFirst(
            [
                "subscribeId='".$subscribeId."'"
            ]
        );
        $subscribe->subscribeChecked = $check;
        $subscribe->save();
    }

}
