<?php


namespace App\TCGPlayer;

use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
use TrollAndToad\TCGPlayer\Stores\Inventory\UpdateSKUInventory;
use TrollAndToad\TCGPlayer\Stores\Inventory\UpdateSKUInventoryRequest;


class ListProducts {

    protected $info;
    protected $storeID;
    protected $bearerToken;
    protected $channelID;
    protected $apiOptions;

    public function __construct(Repository $config, Connection $conn) {

        $this->info = new CommonInfo($config, $conn);
        $this->storeID = $this->info->getStoreID();
        $this->bearerToken = $this->info->getBearerToken();
        $this->channelID = $this->info->getChannelID();
        $this->apiOptions = $this->info->getApiOptions();

    }

    public function ListProduct(array $productArr) {

        $skuID = $productArr["skuID"];
        $price = $productArr["price"];
        $qty = $productArr["qty"];

        $listProducts = new UpdateSKUInventory($this->apiOptions);
        $request = new UpdateSKUInventoryRequest(["price" => $price, "quantity" => $qty, "channelid" => $this->channelID], $this->bearerToken, $this->storeID, $skuID);
        $response = $listProducts->sendRequest($request)->getContent();

        return $response;

    }

    public function removeProduct(array $productArr) {

        $qty = 0;
        $price = $productArr["price"];
        $skuID = $productArr["skuID"];

        $listProducts = new UpdateSKUInventory($this->apiOptions);
        $request = new UpdateSKUInventoryRequest(["price" => $price, "quantity" => $qty, "channelid" => $this->channelID], $this->bearerToken, $this->storeID, $skuID);
        $response = $listProducts->sendRequest($request)->getContent();

        return $response;

    }

}
