<?php


namespace App\TCGPlayer;

use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
use TrollAndToad\TCGPlayer\Stores\Inventory\BatchUpdateStoreSKUPrices;
use TrollAndToad\TCGPlayer\Stores\Inventory\BatchUpdateStoreSKUPricesRequest;
use TrollAndToad\TCGPlayer\Stores\Inventory\UpdateSKUInventoryPrice;
use TrollAndToad\TCGPlayer\Stores\Inventory\UpdateSKUInventoryPriceRequest;


class PriceProducts {

    protected $info;
    protected $commonData;

    public function __construct(Repository $config, Connection $conn) {

        $this->info = new CommonInfo($config, $conn);
        $this->commonData = $this->info->getCommonData();

    }

    public function priceProduct(array $productArr) {

        $skuID = $productArr["skuID"];
        $price = floatval($productArr["price"]);

        $priceProduct = new UpdateSKUInventoryPrice($this->commonData->apiOptions);
        $request = new UpdateSKUInventoryPriceRequest(["price" => $price, "channelid" => $this->commonData->channelID], $this->commonData->bearerToken, $this->commonData->storeID, $skuID);
        $response = $priceProduct->sendRequest($request)->getContent();

        return $response;


    }

    public function priceProducts(array $productArr) {

        //Multi-dimensional array format for using BatchUpdate
        //$productArr = array(array("skuId" => value, "price" => value, "channelId" => value))

        $priceProducts = new BatchUpdateStoreSKUPrices($this->commonData->apiOptions);
        $request = new BatchUpdateStoreSKUPricesRequest($productArr, $this->commonData->bearerToken, $this->commonData->storeID);
        $response = $priceProducts->sendRequest($request)->getContent();

        return $response;

    }

}
