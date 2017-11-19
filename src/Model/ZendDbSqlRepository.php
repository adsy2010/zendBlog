<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 19/11/2017
 * Time: 16:18
 */

namespace Blog\Model;

use InvalidArgumentException;
use RuntimeException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;

use Zend\Db\Adapter\Driver\ResultInterface;

use Zend\Hydrator\HydratorInterface;
use Zend\Hydrator\Reflection as ReflectionHydrator;
use Zend\Db\ResultSet\HydratingResultSet;


class ZendDbSqlRepository implements PostRepositoryInterface
{

    private $db;
    private $hydrator;
    private $postPrototype;

    public function __construct(
        AdapterInterface $db,
        HydratorInterface $hydrator,
        Post $postPrototype)
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->postPrototype = $postPrototype;
    }

    /**
     * @{inheritDoc}
     */
    public function findAllPosts()
    {
        $sql = new Sql($this->db);
        $select = $sql->select('posts');
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            return [];
        }

        $resultSet = new HydratingResultSet($this->hydrator,$this->postPrototype);
        $resultSet->initialize($result);
        return $resultSet;
    }

    /**
     * @{inheritDoc}
     */
    public function findPost($id)
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select('posts');
        $select->where(['id = ?' => $id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving blog post with identifier "%s"; unknown database error.',
                $id
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);
        $resultSet->initialize($result);
        $post = $resultSet->current();

        if (! $post) {
            throw new InvalidArgumentException(sprintf(
                'Blog post with identifier "%s" not found.',
                $id
            ));
        }

        return $post;
    }
}