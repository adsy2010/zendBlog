<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 21/11/2017
 * Time: 21:54
 */

namespace Blog\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Update;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;

use RuntimeException;

class ZendDbSqlCommand implements PostCommandInterface
{
    private $db;

    public function __construct(AdapterInterface $db)
    {
        $this->db = $db;
    }

    /**
     * @param Post $post
     * @return Post
     */
    public function insertPost(Post $post)
    {
        $insert = new Insert('posts');
        $insert->values([
            'title' => $post->getTitle(),
            'text' => $post->getText()
        ]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        if(! $result instanceof ResultInterface){
            throw new RuntimeException('Database error occurred during blog post insert operation');
        }

        $id = $result->getGeneratedValue();

        return new Post($post->getTitle(), $post->getText(), $id);
    }

    /**
     * @param Post $post
     * @return Post
     */
    public function updatePost(Post $post)
    {
        if(!$post->getId()){
            throw new RuntimeException('Cannot update post; missing identifier');
        }

        $update = new Update('posts');
        $update->set([
            'title' => $post->getTitle(),
            'text' => $post->getText()
        ])->where(['id = ? ' => $post->getId()]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

        if(! $result instanceof ResultInterface){
            throw new RuntimeException('Database error occurred during blog post update operation');
        }

        return $post;

    }

    /**
     * @param Post $post
     * @return bool
     */
    public function deletePost(Post $post)
    {
        if(! $post->getId()){
            throw new RuntimeException('Cannot delete post; missing identifier');
        }

        $delete = new Delete('posts');
        $delete->where(['id = ?' => $post->getId()]);

        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();

        if(! $result instanceof ResultInterface){
            return false;
        }

        return true;
    }
}