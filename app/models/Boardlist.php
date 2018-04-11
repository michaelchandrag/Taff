<?php

class Boardlist extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="listId", type="string", length=20, nullable=false)
     */
    public $listId;

    /**
     *
     * @var string
     * @Column(column="listBoardId", type="string", length=20, nullable=false)
     */
    public $listBoardId;

    /**
     *
     * @var string
     * @Column(column="listTitle", type="string", length=20, nullable=false)
     */
    public $listTitle;

    /**
     *
     * @var string
     * @Column(column="listPosition", type="string", length=20, nullable=false)
     */
    public $listPosition;

    /**
     *
     * @var string
     * @Column(column="listCreated", type="string", nullable=false)
     */
    public $listCreated;

    /**
     *
     * @var string
     * @Column(column="listArchive", type="string", length=1, nullable=false)
     */
    public $listArchive;

    /**
     *
     * @var string
     * @Column(column="listStatus", type="string", length=1, nullable=false)
     */
    public $listStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("boardlist");
        $this->belongsTo('listBoardId', '\Board', 'boardId', ['alias' => 'Board']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'boardlist';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardlist[]|Boardlist|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Boardlist|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countList()
    {
        $list = Boardlist::find();
        return count($list);
    }

    public function insertBoardList($owner,$title,$archive,$status)
    {
        $list = new Boardlist();
        $index = $list->countList();
        $id = "BL".str_pad($index,5,'0',STR_PAD_LEFT);
        $indexPos = $list->countListById($owner);
        $posAkhir = Boardlist::maximum(
            [
                "column"        => "listPosition",
                "conditions"    => "listBoardId='".$owner."'"
            ]
        );
        $list->listId = $id;
        $list->listBoardId = $owner;
        $list->listTitle = $title;
        $list->listPosition = $posAkhir+1;
        $list->listCreated = date("Y-m-d H:i:sa");
        $list->listArchive = $archive;
        $list->listStatus = $status;
        $list->save();
    }

    public function countListById($id)
    {
        $list = Boardlist::find(
            [
                "listBoardId='".$id."'"
            ]
        );
        return count($list);
    }

    public function setPosition($id,$position)
    {
        $list = Boardlist::findFirst(
            [
                "listId='".$id."'"
            ]
        );
        $list->listPosition = $position;
        $list->save();
    }

    public function setArchive($listId,$archive)
    {
        $list = Boardlist::findFirst(
            [
                "listId='".$listId."'"
            ]
        );
        $list->listArchive = $archive;
        $list->save();
    }

    public function deleteList($listId)
    {
        $list = Boardlist::findFirst(
            [
                "listId='".$listId."'"
            ]
        );
        $list->listStatus = "0";
        $list->save();
    }

}
