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
        $this->belongsTo('cardListId', '\Boardlist', 'listId', ['alias' => 'Boardlist']);
        $this->belongsTo('cardOwner', '\User', 'userId', ['alias' => 'User']);
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

    public function insertBoardCard($listId,$owner,$title,$description,$archive,$status)
    {
        $card = new Boardcard();
        $index = $card->countCard();
        $id = "BC".str_pad($index,3,'0',STR_PAD_LEFT);
        $indexPos = $card->countCardById($listId);
        $card->cardId = $id;
        $card->cardListId = $listId;
        $card->cardOwner = $owner;
        $card->cardTitle = $title;
        $card->cardDescription = $description;
        $card->cardPosition = $indexPos+1;
        $card->cardCreated = date("Y-m-d h:i:sa");
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
}
