<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class CartType
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $carts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->carts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add cart
     *
     * @param \AppBundle\Entity\Cart $cart
     *
     * @return CartType
     */
    public function addCart(\AppBundle\Entity\Cart $cart)
    {
        $this->carts[] = $cart;

        return $this;
    }

    /**
     * Remove cart
     *
     * @param \AppBundle\Entity\Cart $cart
     */
    public function removeCart(\AppBundle\Entity\Cart $cart)
    {
        $this->carts->removeElement($cart);
    }

    /**
     * Get carts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCarts()
    {
        return $this->carts;
    }
}
