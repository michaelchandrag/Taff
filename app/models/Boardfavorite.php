<?php

class Boardfavorite extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="favoriteId", type="string", length=20, nullable=false)
     */
    public $favoriteId;

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
     * @Column(column="favoriteCheck", type="string", length=1, nullable=false)
     */
    public $favoriteCheck;

    /**
     *
     * @var string
     * @Column(column="favoriteStatus", type="string", length=1, nullable=false)
     */
    public $favoriteStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardfavorite");
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
        return 'boardfavorite';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardfavorite[]|Boardfavorite|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardfavorite|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countFavorite()
    {
        $favorite = Boardfavorite::find();
        return count($favorite);
    }

    public function insertBoardFavorite($boardId,$userId,$check,$status)
    {
        $favorite = new Boardfavorite();
        $index = $favorite->countFavorite();
        $id = "BF".str_pad($index,5,'0',STR_PAD_LEFT);
        $favorite->favoriteId = $id;
        $favorite->boardId = $boardId;
        $favorite->userId = $userId;
        $favorite->favoriteCheck = $check;
        $favorite->favoriteStatus = $status;
        $favorite->save();
    }

    public function setCheck($favoriteId,$check)
    {
        $favorite = Boardfavorite::findFirst(
            [
                "favoriteId='".$favoriteId."'"
            ]
        );
        $favorite->favoriteCheck = $check;
        $favorite->save();
    }

}
