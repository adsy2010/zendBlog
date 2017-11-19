<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 19/11/2017
 * Time: 16:22
 */

namespace Blog\Factory;

use DeepCopy\Reflection\ReflectionHelper;
use Interop\Container\Exception\ContainerException;
use Blog\Model\ZendDbSqlRepository;
use Blog\Model\Post;
use Zend\Db\Adapter\AdapterInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

use Zend\Hydrator\Reflection as ReflectionHydrator;



class ZendDbSqlRepositoryFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ZendDbSqlRepository
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // TODO: Implement __invoke() method.
        return new ZendDbSqlRepository(
            $container->get(AdapterInterface::class),
            new ReflectionHydrator(),
            new Post('','')
        );
    }
}