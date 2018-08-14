<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class BoardduedateMigration_100
 */
class BoardduedateMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('boardduedate', [
                'columns' => [
                    new Column(
                        'dueDateId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'cardId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'dueDateId'
                        ]
                    ),
                    new Column(
                        'dueDate',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'cardId'
                        ]
                    ),
                    new Column(
                        'dueDateChecked',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'dueDate'
                        ]
                    ),
                    new Column(
                        'dueDateStatus',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'dueDateChecked'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['dueDateId'], 'PRIMARY'),
                    new Index('cardId', ['cardId'], null)
                ],
                'references' => [
                    new Reference(
                        'boardduedate_ibfk_1',
                        [
                            'referencedTable' => 'boardcard',
                            'referencedSchema' => 'taff',
                            'columns' => ['cardId'],
                            'referencedColumns' => ['cardId'],
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
