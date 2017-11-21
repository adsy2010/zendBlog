<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 21/11/2017
 * Time: 21:17
 */

namespace Blog\Controller;


use Blog\Model\Post;
use Blog\Form\PostForm;
use Blog\Model\PostCommandInterface;
use Blog\Model\PostRepositoryInterface;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use InvalidArgumentException;
use Exception;

class WriteController extends AbstractActionController
{
    private $command;
    private $form;
    private $repository;

    public function __construct(PostCommandInterface $command, PostForm $form, PostRepositoryInterface $repository)
    {
        $this->command = $command;
        $this->form = $form;
        $this->repository = $repository;
    }

    public function addAction()
    {
        $request = $this->getRequest();

        $viewModel = new ViewModel([
            'form' => $this->form,
        ]);

        if(! $request->isPost()){
            return $viewModel;
        }

        $this->form->setData($request->getPost());

        if(! $this->form->isValid()){
            return $viewModel;
        }

        $post = $this->form->getData();

        //$data = $this->form->getData()['post'];
        //$post = new Post($data['title'], $data['text']);

        try{
            $post = $this->command->insertPost($post);
        } catch (Exception $e){
            throw $e;
        }

        return $this->redirect()->toRoute('blog/detail', ['id' => $post->getId()]);
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id');

        //if the route id does not exist, redirect
        if(! $id){
            return $this->redirect()->toRoute('blog');
        }

        //if the post doesn't exist, redirect
        try{
            $post = $this->repository->findPost($id);
        } catch (InvalidArgumentException $e){
            $this->redirect()->toRoute('blog');
        }

        $this->form->bind($post);
        $viewModel = new ViewModel(['form' => $this->form]);

        $request = $this->getRequest();
        if(! $request->isPost()){
            return $viewModel;
        }

        $this->form->setData($request->getPost());

        if(! $this->form->isValid()){
            return $viewModel;
        }

        $post = $this->command->updatePost($post);

        return $this->redirect()->toRoute('blog/detail', ['id' => $post->getId()]);


    }
}