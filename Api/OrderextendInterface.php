<?php
namespace Orderhistoryextend\Orderextend\Api;
 
interface OrderextendInterface
{
    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $name Users name.
     * @return string Greeting message with users name.
     */
     public function customerid($customerId);

}
