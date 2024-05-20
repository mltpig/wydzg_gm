<?php

namespace EasySwoole\ORM\Tests;


use EasySwoole\ORM\Db\Config;
use EasySwoole\ORM\Db\Connection;
use EasySwoole\ORM\DbManager;
use EasySwoole\ORM\Tests\models\ReuniteTableModel;
use PHPUnit\Framework\TestCase;
use EasySwoole\Mysqli\QueryBuilder;

class ReuniteTableTest extends TestCase
{
    /**
     * @var $connection Connection
     */
    protected $connection;
    protected $tableName = 'reunite_table';

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $config = new Config(MYSQL_CONFIG);
        $this->connection = new Connection($config);
        DbManager::getInstance()->addConnection($this->connection);
        $connection = DbManager::getInstance()->getConnection();
        $this->assertTrue($connection === $this->connection);
        $this->createTestTable();
    }

    function createTestTable()
    {
        $query = new QueryBuilder();
        $sql = <<<sql
CREATE TABLE If Not Exists `reunite_table`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pk_1` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pk_2` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`pk_1`, `pk_2`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;
sql;

        $query->raw($sql);
        $data = $this->connection->defer()->query($query);
        $this->assertTrue($data->getResult());
    }

    /**
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    function testAdd()
    {
        $model = ReuniteTableModel::create([
            'pk_1' => 1,
            'pk_2' => 2
        ])->save();
        $this->assertIsInt($model);

        $model = ReuniteTableModel::create([
            'pk_1' => 1,
            'pk_2' => 1
        ])->save();
        $this->assertIsInt($model);
    }

    /**
     * @throws \EasySwoole\Mysqli\Exception\Exception
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    function testGet()
    {
        $model = ReuniteTableModel::create()->get();
        $this->assertInstanceOf(ReuniteTableModel::class, $model);

        $model = ReuniteTableModel::create()->get([
            'pk_1' => 1,
            'pk_2' => 1
        ]);
        $this->assertInstanceOf(ReuniteTableModel::class, $model);
        $deleteOne = $model->destroy();
        $this->assertEquals(1, $deleteOne);
    }

    function testUpdate()
    {
        $model = ReuniteTableModel::create()->get([
            'pk_1' => 1,
            'pk_2' => 2
        ]);
        $this->assertInstanceOf(ReuniteTableModel::class, $model);
        $model->pk_2 = 'new';
        $updateRes = $model->update();
        $this->assertEquals(true, $updateRes);
        $this->assertEquals(1, $model->lastQueryResult()->getAffectedRows());
    }


    /**
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    function testDeleteAll()
    {
        $int = ReuniteTableModel::create()->destroy(null, true);
        $this->assertIsInt($int);
    }
}