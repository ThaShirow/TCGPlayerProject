<?php


namespace App\TCGPlayer;

use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
use TrollAndToad\TCGPlayer\Stores\Orders\SearchOrders;
use TrollAndToad\TCGPlayer\Stores\Orders\SearchOrdersRequest;
use TrollAndToad\TCGPlayer\Stores\Orders\GetOrderItems;
use TrollAndToad\TCGPlayer\Stores\Orders\GetOrderItemsRequest;
use TrollAndToad\TCGPlayer\Stores\Orders\GetOrderDetails;
use TrollAndToad\TCGPlayer\Stores\Orders\GetOrderDetailsRequest;

class GetOrders {

    protected $info;
    protected $commonData;

    public function __construct(Repository $config, Connection $conn) {

        $this->info = new CommonInfo($config, $conn);
        $this->commonData = $this->info->getCommonData();

    }

    public function getOrders() {

        $getOrders = new SearchOrders($this->commonData->apiOptions);
        $request = new SearchOrdersRequest(["orderStatusIds" => "0,1,2"], $this->commonData->bearerToken, $this->commonData->storeID);
        $response = $getOrders->sendRequest($request)->getContent();

        return $response;

    }

    public function getOrderDetails($orderArr) {

        $getOrderDetails = new GetOrderDetails($this->commonData->apiOptions);
        $request = new GetOrderDetailsRequest($this->commonData->bearerToken, $this->commonData->storeID, $orderArr);
        $response = $getOrderDetails->sendRequest($request)->getContent();

        return $response;

    }

    public function getOrderItems($orderID) {

        $getOrderItems = new GetOrderItems($this->commonData->apiOptions);
        $request = new GetOrderItemsRequest(["includeItemDetails" => "true", "limit" => 50], $this->commonData->bearerToken, $this->commonData->storeID, $orderID);
        $response = $getOrderItems->sendRequest($request)->getContent();

        return $response;

    }

}
