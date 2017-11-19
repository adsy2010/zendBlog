<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 19/11/2017
 * Time: 10:54
 */

namespace Blog;


class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}