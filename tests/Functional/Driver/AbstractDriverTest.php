<?php

namespace Doctrine\DBAL\Tests\Functional\Driver;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Driver\Connection as DriverConnection;
use Doctrine\DBAL\Tests\FunctionalTestCase;

abstract class AbstractDriverTest extends FunctionalTestCase
{
    /**
     * The driver instance under test.
     *
     * @var Driver
     */
    protected $driver;

    protected function setUp(): void
    {
        $this->driver = $this->createDriver();
    }

    public function testConnectsWithoutDatabaseNameParameter(): void
    {
        $params = $this->connection->getParams();
        unset($params['dbname']);

        $connection = $this->driver->connect($params);

        self::assertInstanceOf(DriverConnection::class, $connection);
    }

    public function testReturnsDatabaseNameWithoutDatabaseNameParameter(): void
    {
        $params = $this->connection->getParams();
        unset($params['dbname']);

        $connection = new Connection(
            $params,
            $this->connection->getDriver(),
            $this->connection->getConfiguration(),
            $this->connection->getEventManager()
        );

        self::assertSame(
            static::getDatabaseNameForConnectionWithoutDatabaseNameParameter(),
            $connection->getDatabase()
        );
    }

    abstract protected function createDriver(): Driver;

    protected static function getDatabaseNameForConnectionWithoutDatabaseNameParameter(): ?string
    {
        return null;
    }
}
