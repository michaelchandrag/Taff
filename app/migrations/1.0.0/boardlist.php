<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class BoardlistMigration_100
 */
class BoardlistMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('boardlist', [
                'columns' => [
                    new Column(
                        'listId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'listBoardId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'listId'
                        ]
                    ),
                    new Column(
                        'listTitle',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'listBoardId'
                        ]
                    ),
                    new Column(
                        'listPosition',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'listTitle'
                        ]
                    ),
                    new Column(
                        'listCreated',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'listPosition'
                        ]
                    ),
                    new Column(
                        'listArchive',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'listCreated'
                        ]
                    ),
                    new Column(
                        'listStatus',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'listArchive'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['listId'], 'PRIMARY'),
                    new Index('listBoardId', ['listBoardId'], null)
                ],
                'references' => [
                    new Reference(
                        'boardlist_ibfk_1',
                        [
                            'referencedTable' => 'board',
                            'referencedSchema' => 'taff',
                            'columns' => ['listBoardId'],
                            'referencedColumns' => ['boardId'],
                            'onUpdate' => 'RESTRICT',
                            'onDelete' => 'RESTRICT'
                        ]
                    )
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'latin1_swedish_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
