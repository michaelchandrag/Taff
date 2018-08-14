<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class BoardrolecollaboratorMigration_100
 */
class BoardrolecollaboratorMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('boardrolecollaborator', [
                'columns' => [
                    new Column(
                        'roleId',
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
                            'after' => 'roleId'
                        ]
                    ),
                    new Column(
                        'listCreate',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'boardId'
                        ]
                    ),
                    new Column(
                        'listEdit',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'listCreate'
                        ]
                    ),
                    new Column(
                        'listDelete',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'listEdit'
                        ]
                    ),
                    new Column(
                        'cardCreate',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'listDelete'
                        ]
                    ),
                    new Column(
                        'cardEdit',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'cardCreate'
                        ]
                    ),
                    new Column(
                        'cardDelete',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'cardEdit'
                        ]
                    ),
                    new Column(
                        'activityAM',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'cardDelete'
                        ]
                    ),
                    new Column(
                        'activityLabel',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'activityAM'
                        ]
                    ),
                    new Column(
                        'activityChecklist',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'activityLabel'
                        ]
                    ),
                    new Column(
                        'activityStartDate',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'activityChecklist'
                        ]
                    ),
                    new Column(
                        'activityDueDate',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'activityStartDate'
                        ]
                    ),
                    new Column(
                        'activityAttachment',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'activityDueDate'
                        ]
                    ),
                    new Column(
                        'roleStatus',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'activityAttachment'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['roleId'], 'PRIMARY'),
                    new Index('boardId', ['boardId'], null)
                ],
                'references' => [
                    new Reference(
                        'boardrolecollaborator_ibfk_1',
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
