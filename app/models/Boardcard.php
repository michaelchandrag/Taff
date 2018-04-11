<?php

class Boardcard extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="cardId", type="string", length=20, nullable=false)
     */
    public $cardId;

    /**
     *
     * @var string
     * @Column(column="cardListId", type="string", length=20, nullable=false)
     */
    public $cardListId;

    /**
     *
     * @var string
     * @Column(column="cardBoardId", type="string", length=20, nullable=false)
     */
    public $cardBoardId;

    /**
     *
     * @var string
     * @Column(column="cardOwner", type="string", length=20, nullable=false)
     */
    public $cardOwner;

    /**
     *
     * @var string
     * @Column(column="cardTitle", type="string", length=20, nullable=false)
     */
    public $cardTitle;

    /**
     *
     * @var string
     * @Column(column="cardDescription", type="string", length=20, nullable=false)
     */
    public $cardDescription;

    /**
     *
     * @var string
     * @Column(column="cardPosition", type="string", length=20, nullable=false)
     */
    public $cardPosition;

    /**
     *
     * @var string
     * @Column(column="cardCreated", type="string", nullable=false)
     */
    public $cardCreated;

    /**
     *
     * @var string
     * @Column(column="cardArchive", type="string", length=20, nullable=false)
     */
    public $cardArchive;

    /**
     *
     * @var string
     * @Column(column="cardStatus", type="string", length=20, nullable=false)
     */
    public $cardStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardcard");
        $this->hasMany('cardId', 'Boardassignmembers', 'cardId', ['alias' => 'Boardassignmembers']);
        $this->hasMany('cardId', 'Boardchecklist', 'cardId', ['alias' => 'Boardchecklist']);
        $this->hasMany('cardId', 'Boardchecklistitem', 'cardId', ['alias' => 'Boardchecklistitem']);
        $this->hasMany('cardId', 'Boardduedate', 'cardId', ['alias' => 'Boardduedate']);
        $this->belongsTo('cardListId', '\Boardlist', 'listId', ['alias' => 'Boardlist']);
        $this->belongsTo('cardOwner', '\User', 'userId', ['alias' => 'User']);
        $this->belongsTo('cardBoardId', '\Board', 'boardId', ['alias' => 'Board']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardcard';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardcard[]|Boardcard|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardcard|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countCard()
    {
        $card = Boardcard::find();
        return count($card);
    }

    public function insertBoardCard($listId,$boardId,$owner,$title,$description,$archive,$status)
    {
        date_default_timezone_set('Asia/Jakarta');
        $card = new Boardcard();
        $index = $card->countCard();
        $id = "BC".str_pad($index,5,'0',STR_PAD_LEFT);
        $posAkhir = Boardcard::maximum(
            [
                "column"        => "cardPosition",
                "conditions"    => "cardListId='".$listId."'"
            ]
        );

        $card->cardId = $id;
        $card->cardListId = $listId;
        $card->cardBoardId = $boardId;
        $card->cardOwner = $owner;
        $card->cardTitle = $title;
        $card->cardDescription = $description;
        $card->cardPosition = $posAkhir+1;
        $card->cardCreated = date("Y-m-d H:i:sa");
        $card->cardArchive = $archive;
        $card->cardStatus = $status;
        $card->save();
    }

    public function countCardById($id)
    {
        $card = Boardcard::find(
            [
                "cardListId='".$id."'"
            ]
        );
        return count($card);
    }

    public function setArchive($id,$status)
    {
        $card = Boardcard::findFirst(
            [
                "cardId='".$id."'"
            ]);
        $card->cardArchive = $status;
        $card->save();
    }

    public function setTitle($id,$title)
    {
        $card = Boardcard::findFirst(
            [
                "cardId='".$id."'"
            ]);
        $card->cardTitle = $title;
        $card->save(); 
    }

    public function setDescription($id,$description)
    {
        $card = Boardcard::findFirst(
            [
                "cardId='".$id."'"
            ]);
        $card->cardDescription = $description;
        $card->save(); 
    }

    public function setPosition($listId,$cardId,$position)
    {
        $card = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]);
        $card->cardListId = $listId;
        $card->cardPosition = $position;
        $card->save(); 
    }

    public function deleteCard($cardId)
    {
        $card = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]);
        $card->cardStatus = "0";
        $card->save(); 
    }

}
