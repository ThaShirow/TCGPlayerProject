<?php


namespace App\TCGPlayer;

use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
use TrollAndToad\TCGPlayer\Stores\Inventory\UpdateSKUInventory;
use TrollAndToad\TCGPlayer\Stores\Inventory\UpdateSKUInventoryRequest;


class ListProducts {

    protected $info;
    protected $commonData;

    public function __construct(Repository $config, Connection $conn) {

        $this->info = new CommonInfo($config, $conn);
        $this->commonData = $this->info->getCommonData();

    }

    public function ListProduct(array $productArr) {

        $skuID = $productArr["skuID"];
        $price = $productArr["price"];
        $qty = $productArr["qty"];

        $listProducts = new UpdateSKUInventory($this->commonData->apiOptions);
        $request = new UpdateSKUInventoryRequest(["price" => $price, "quantity" => $qty, "channelid" => $this->commonData->channelID], $this->commonData->bearerToken, $this->commonData->storeID, $skuID);
        $response = $listProducts->sendRequest($request)->getContent();

        return $response;

    }

    public function removeProduct(array $productArr) {

        $qty = 0;
        $price = $productArr["price"];
        $skuID = $productArr["skuID"];

        $listProducts = new UpdateSKUInventory($this->commonData->apiOptions);
        $request = new UpdateSKUInventoryRequest(["price" => $price, "quantity" => $qty, "channelid" => $this->commonData->channelID], $this->commonData->bearerToken, $this->commonData->storeID, $skuID);
        $response = $listProducts->sendRequest($request)->getContent();

        return $response;

    }

}
