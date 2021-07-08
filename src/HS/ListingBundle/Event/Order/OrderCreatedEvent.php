<?php
/**
 * Created by PhpStorm.
 * User: Redaa
 * Date: 2/2/2018
 * Time: 9:55 AM
 */

namespace HS\ListingBundle\Event\Order;


use HS\ListingBundle\Entity\LOrder;
use Symfony\Component\EventDispatcher\Event;

class OrderCreatedEvent extends Event
{
    const NAME = "order.created";

    protected $order;


    /**
     * OrderCreatedEvent constructor.
     * @param LOrder $order
     */
    public function __construct(LOrder $order)
    {
        $this->order = $order;
    }

    /**
     * @return LOrder
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param LOrder $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }
}