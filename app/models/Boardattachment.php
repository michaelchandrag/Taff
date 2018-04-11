<?php

class Boardattachment extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="attachmentId", type="string", length=20, nullable=false)
     */
    public $attachmentId;

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
     * @Column(column="attachmentTitle", type="string", length=256, nullable=false)
     */
    public $attachmentTitle;

    /**
     *
     * @var string
     * @Column(column="attachmentDirectory", type="string", length=256, nullable=false)
     */
    public $attachmentDirectory;

    /**
     *
     * @var string
     * @Column(column="attachmentStatus", type="string", length=1, nullable=false)
     */
    public $attachmentStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardattachment");
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
        return 'boardattachment';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardattachment[]|Boardattachment|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardattachment|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countAttachment()
    {
        $attachment = Boardattachment::find();
        return count($attachment);
    }

    public function insertBoardAttachment($boardId,$cardId,$title,$directory,$status)
    {
        $attachment                         = new Boardattachment();
        $index                              = $attachment->countAttachment();
        $id                                 = "BAT".str_pad($index,5,'0',STR_PAD_LEFT);
        $attachment->attachmentId           = $id;
        $attachment->boardId                = $boardId;
        $attachment->cardId                 = $cardId;
        $attachment->attachmentTitle        = $title;
        $attachment->attachmentDirectory    = $directory;
        $attachment->attachmentStatus       = $status;
        $attachment->save();
    }

    public function deleteAttachment($id)
    {
        $attachment = Boardattachment::findFirst(
            [
                "attachmentId='".$id."'"
            ]
        );
        $attachment->attachmentStatus = "0";
        $attachment->save();
    }

}
