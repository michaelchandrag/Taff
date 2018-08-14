<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class BoardreplycommentMigration_100
 */
class BoardreplycommentMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('boardreplycomment', [
                'columns' => [
                    new Column(
                        'replyId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'commentId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'replyId'
                        ]
                    ),
                    new Column(
                        'cardId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'commentId'
                        ]
                    ),
                    new Column(
                        'boardId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'cardId'
                        ]
                    ),
                    new Column(
                        'userId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'boardId'
                        ]
                    ),
                    new Column(
                        'replyText',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 99,
                            'after' => 'userId'
                        ]
                    ),
                    new Column(
                        'replyCreated',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'replyText'
                        ]
                    ),
                    new Column(
                        'replyStatus',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'replyCreated'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['replyId'], 'PRIMARY'),
                    new Index('boardId', ['boardId'], null),
                    new Index('cardId', ['cardId'], null),
                    new Index('commentId', ['commentId'], null),
                    new Index('userId', ['userId'], null)
                ],
                'references' => [
                    new Reference(
                        'boardreplycomment_ibfk_1',
                        [
                            'referencedTable' => 'board',
                            'referencedSchema' => 'taff',
                            'columns' => ['boardId'],
                            'referencedColumns' => ['boardId'],
                            'onUpdate' => 'RESTRICT',
                            'onDelete' => 'RESTRICT'
                        ]
                    ),
                    new Reference(
                        'boardreplycomment_ibfk_2',
                        [
                            'referencedTable' => 'boardcard',
                            'referencedSchema' => 'taff',
                            'columns' => ['cardId'],
                            'referencedColumns' => ['cardId'],
                            'onUpdate' => 'RESTRICT',
                            'onDelete' => 'RESTRICT'
                        ]
                    ),
                    new Reference(
                        'boardreplycomment_ibfk_3',
                        [
                            'referencedTable' => 'boardcomment',
                            'referencedSchema' => 'taff',
                            'columns' => ['commentId'],
                            'referencedColumns' => ['commentId'],
                            'onUpdate' => 'RESTRICT',
                            'onDelete' => 'RESTRICT'
                        ]
                    ),
                    new Reference(
                        'boardreplycomment_ibfk_4',
                        [
                            'referencedTable' => 'user',
                            'referencedSchema' => 'taff',
                            'columns' => ['userId'],
                            'referencedColumns' => ['userId'],
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
