<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 21/11/2017
 * Time: 21:10
 */

namespace Blog\Form;

use Blog\Model\Post;
use Zend\Hydrator\Reflection as ReflectionHydrator;
use Zend\Form\Fieldset;

class PostFieldset extends Fieldset
{
    public function init()
    {
        $this->setHydrator(new ReflectionHydrator());
        $this->setObject(new Post('',''));

        $this->add([
            'type' => 'hidden',
            'name' => 'id'
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'title',
            'options' => [
                'label' => 'Post title'
            ],
            'attributes' =>[
                'placeholder' => 'Title'
            ]
        ]);

        $this->add([
            'type' => 'textarea',
            'name' => 'text',
            'options' => [
                'label' => 'Post text'
            ],
            'attributes' => [
                'placeholder' => 'Post'
            ]
        ]);
    }
}