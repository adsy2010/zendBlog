<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 19/11/2017
 * Time: 15:20
 */

namespace Blog\Model;


interface PostRepositoryInterface
{
    /**
     * @return Post[]
     */
    public function findAllPosts();

    /**
     * @param $id
     * @return Post
     */
    public function findPost($id);
}