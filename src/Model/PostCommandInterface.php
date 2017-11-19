<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 19/11/2017
 * Time: 16:07
 */

namespace Blog\Model;


interface PostCommandInterface
{
    /**
     * @param Post $post
     * @return Post
     */
    public function insertPost(Post $post);

    /**
     * @param Post $post
     * @return Post
     */
    public function updatePost(Post $post);

    /**
     * @param Post $post
     * @return bool
     */
    public function deletePost(Post $post);
}