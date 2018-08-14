<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class BoardlabelcardMigration_100
 */
class BoardlabelcardMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('boardlabelcard', [
                'columns' => [
                    new Column(
                        'labelId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'boardId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'labelId'
                        ]
                    ),
                    new Column(
                        'cardId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'boardId'
                        ]
                    ),
                    new Column(
                        'labelRed',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 5,
                            'after' => 'cardId'
                        ]
                    ),
                    new Column(
                        'labelYellow',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 5,
                            'after' => 'labelRed'
                        ]
                    ),
                    new Column(
                        'labelGreen',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 5,
                            'after' => 'labelYellow'
                        ]
                    ),
                    new Column(
                        'labelBlue',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 5,
                            'after' => 'labelGreen'
                        ]
                    ),
                    new Column(
                        'labelStatus',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'labelBlue'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['labelId'], 'PRIMARY'),
                    new Index('boardId', ['boardId'], null),
                    new Index('boardlabelcard_ibfk_2', ['cardId'], null)
                ],
                'references' => [
                    new Reference(
                        'boardlabelcard_ibfk_1',
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
                        'boardlabelcard_ibfk_2',
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
