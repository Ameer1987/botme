<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Product types', ['route' => 'admin_producttype_index']);
        $menu->addChild('Products', ['route' => 'admin_product_index']);
        $menu->addChild('Cart types', ['route' => 'admin_carttype_index']);

        return $menu;
    }
}
