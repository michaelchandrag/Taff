<?php

class Groupboardlist extends \Phalcon\Mvc\Model
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
     * @Column(column="listArchive", type="string", length=20, nullable=false)
     */
    public $listArchive;

    /**
     *
     * @var string
     * @Column(column="listStatus", type="string", length=20, nullable=false)
     */
    public $listStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("groupboardlist");
        $this->belongsTo('listBoardId', '\Groupboard', 'boardId', ['alias' => 'Groupboard']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'groupboardlist';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Groupboardlist[]|Groupboardlist|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Groupboardlist|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function countList()
    {
        $list = Groupboardlist::find();
        return count($list);
    }

    public function insertBoardList($owner,$title,$archive,$status)
    {
        $list = new Groupboardlist();
        $index = $list->countList();
        $id = "GL".str_pad($index,3,'0',STR_PAD_LEFT);
        $indexPos = $list->countListById($owner);
        $list->listId = $id;
        $list->listBoardId = $owner;
        $list->listTitle = $title;
        $list->listPosition = $indexPos+1;
        $list->listCreated = date("Y-m-d h:i:sa");
        $list->listArchive = $archive;
        $list->listStatus = $status;
        $list->save();
    }

    public function countListById($id)
    {
        $list = Groupboardlist::find(
            [
                "listBoardId='".$id."'"
            ]
        );
        return count($list);
    }

}
