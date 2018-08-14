<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class BoardchecklistitemMigration_100
 */
class BoardchecklistitemMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('boardchecklistitem', [
                'columns' => [
                    new Column(
                        'itemId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'checklistId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'itemId'
                        ]
                    ),
                    new Column(
                        'cardId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'checklistId'
                        ]
                    ),
                    new Column(
                        'itemTitle',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'cardId'
                        ]
                    ),
                    new Column(
                        'itemChecked',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'itemTitle'
                        ]
                    ),
                    new Column(
                        'itemStatus',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'itemChecked'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['itemId'], 'PRIMARY'),
                    new Index('checklistId', ['checklistId'], null),
                    new Index('cardId', ['cardId'], null)
                ],
                'references' => [
                    new Reference(
                        'boardchecklistitem_ibfk_1',
                        [
                            'referencedTable' => 'boardchecklist',
                            'referencedSchema' => 'taff',
                            'columns' => ['checklistId'],
                            'referencedColumns' => ['checklistId'],
                            'onUpdate' => 'RESTRICT',
                            'onDelete' => 'RESTRICT'
                        ]
                    ),
                    new Reference(
                        'boardchecklistitem_ibfk_2',
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
