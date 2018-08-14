<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class BoardgroupMigration_100
 */
class BoardgroupMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('boardgroup', [
                'columns' => [
                    new Column(
                        'boardGroupId',
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
                            'after' => 'boardGroupId'
                        ]
                    ),
                    new Column(
                        'groupId',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'boardId'
                        ]
                    ),
                    new Column(
                        'boardTitle',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'groupId'
                        ]
                    ),
                    new Column(
                        'boardGroupStatus',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 20,
                            'after' => 'boardTitle'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['boardGroupId'], 'PRIMARY'),
                    new Index('boardId', ['boardId'], null),
                    new Index('groupId', ['groupId'], null)
                ],
                'references' => [
                    new Reference(
                        'boardgroup_ibfk_1',
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
                        'boardgroup_ibfk_2',
                        [
                            'referencedTable' => 'groupuser',
                            'referencedSchema' => 'taff',
                            'columns' => ['groupId'],
                            'referencedColumns' => ['groupId'],
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
