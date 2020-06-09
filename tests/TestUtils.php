<?php

declare(strict_types=1);

namespace Unixslayer;

use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Pdo\MySqlEventStore;
use Prooph\EventStore\Pdo\PersistenceStrategy\MySqlSimpleStreamStrategy;
use Prooph\EventStore\Pdo\PersistenceStrategy\PostgresSimpleStreamStrategy;
use Prooph\EventStore\Pdo\PostgresEventStore;

final class TestUtils
{
    public static function postgresEventStore(): EventStore
    {
        return new PostgresEventStore(new FQCNMessageFactory(), self::postgresPdo(), new PostgresSimpleStreamStrategy());
    }

    public static function mySqlEventStore(): EventStore
    {
        return new MySqlEventStore(new FQCNMessageFactory(), self::mySqlPdo(), new MySqlSimpleStreamStrategy());
    }

    public static function postgresPdo(): \PDO
    {
        $dsn = 'pgsql:';
        $dsn .= \sprintf('host=%s;', \getenv('POSTGRES_HOST'));
        $dsn .= \sprintf('port=%s;', \getenv('POSTGRES_PORT'));
        $dsn .= \sprintf('dbname=%s;', \getenv('POSTGRES_DB'));
        $dsn .= \sprintf('user=%s;', \getenv('POSTGRES_USER'));
        $dsn .= \sprintf('password=%s;', \getenv('POSTGRES_PASS'));
        $dsn = \rtrim($dsn);

        return new \PDO($dsn);
    }

    public static function mySqlPdo(): \PDO
    {
        $dsn = 'mysql:';
        $dsn .= \sprintf('host=%s;', \getenv('MYSQL_HOST'));
        $dsn .= \sprintf('port=%s;', \getenv('MYSQL_PORT'));
        $dsn .= \sprintf('dbname=%s;', \getenv('MYSQL_DB'));
        $dsn .= \sprintf('user=%s;', \getenv('MYSQL_USER'));
        $dsn .= \sprintf('password=%s;', \getenv('MYSQL_PASS'));
        $dsn .= \sprintf('charset=%s;', \getenv('MYSQL_CHARSET'));
        $dsn = \rtrim($dsn);

        return new \PDO($dsn);
    }
}
