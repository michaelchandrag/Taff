<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class BoardcardMigration_100
 */
class BoardcardMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('boardcard', [
                'columns' => [
                    new Column(
                        'cardId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'cardListId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'cardId'
                        ]
                    ),
                    new Column(
                        'cardBoardId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'cardListId'
                        ]
                    ),
                    new Column(
                        'cardOwner',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'cardBoardId'
                        ]
                    ),
                    new Column(
                        'cardTitle',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'cardOwner'
                        ]
                    ),
                    new Column(
                        'cardDescription',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 20,
                            'after' => 'cardTitle'
                        ]
                    ),
                    new Column(
                        'cardPosition',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'cardDescription'
                        ]
                    ),
                    new Column(
                        'cardCreated',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'cardPosition'
                        ]
                    ),
                    new Column(
                        'cardArchive',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'cardCreated'
                        ]
                    ),
                    new Column(
                        'cardStatus',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'cardArchive'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['cardId'], 'PRIMARY'),
                    new Index('cardOwner', ['cardOwner'], null),
                    new Index('boardcard_ibfk_1', ['cardListId'], null),
                    new Index('cardBoardId', ['cardBoardId'], null)
                ],
                'references' => [
                    new Reference(
                        'boardcard_ibfk_1',
                        [
                            'referencedTable' => 'boardlist',
                            'referencedSchema' => 'taff',
                            'columns' => ['cardListId'],
                            'referencedColumns' => ['listId'],
                            'onUpdate' => 'RESTRICT',
                            'onDelete' => 'RESTRICT'
                        ]
                    ),
                    new Reference(
                        'boardcard_ibfk_2',
                        [
                            'referencedTable' => 'user',
                            'referencedSchema' => 'taff',
                            'columns' => ['cardOwner'],
                            'referencedColumns' => ['userId'],
                            'onUpdate' => 'RESTRICT',
                            'onDelete' => 'RESTRICT'
                        ]
                    ),
                    new Reference(
                        'boardcard_ibfk_3',
                        [
                            'referencedTable' => 'board',
                            'referencedSchema' => 'taff',
                            'columns' => ['cardBoardId'],
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
