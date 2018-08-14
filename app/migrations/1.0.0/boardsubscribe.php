<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class BoardsubscribeMigration_100
 */
class BoardsubscribeMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('boardsubscribe', [
                'columns' => [
                    new Column(
                        'subscribeId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'userId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'subscribeId'
                        ]
                    ),
                    new Column(
                        'boardId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'userId'
                        ]
                    ),
                    new Column(
                        'subscribeChecked',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'boardId'
                        ]
                    ),
                    new Column(
                        'subscribeStatus',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'subscribeChecked'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['subscribeId'], 'PRIMARY'),
                    new Index('userId', ['userId'], null),
                    new Index('boardId', ['boardId'], null)
                ],
                'references' => [
                    new Reference(
                        'boardsubscribe_ibfk_1',
                        [
                            'referencedTable' => 'user',
                            'referencedSchema' => 'taff',
                            'columns' => ['userId'],
                            'referencedColumns' => ['userId'],
                            'onUpdate' => 'RESTRICT',
                            'onDelete' => 'RESTRICT'
                        ]
                    ),
                    new Reference(
                        'boardsubscribe_ibfk_2',
                        [
                            'referencedTable' => 'board',
                            'referencedSchema' => 'taff',
                            'columns' => ['boardId'],
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
