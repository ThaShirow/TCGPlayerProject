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

    public function priceProduct(array $productArr) {

        $skuID = $productArr["skuID"];
        $price = floatval($productArr["price"]);

        $priceProduct = new UpdateSKUInventoryPrice($this->apiOptions);
        $request = new UpdateSKUInventoryPriceRequest(["price" => $price, "channelid" => $this->channelID], $this->bearerToken, $this->storeID, $skuID);
        $response = $priceProduct->sendRequest($request)->getContent();

        return $response;


    }

    public function priceProducts(array $productArr) {

        //Multi-dimensional array format for using BatchUpdate
        //$productArr = array(array("skuId" => value, "price" => value, "channelId" => value))

        $priceProducts = new BatchUpdateStoreSKUPrices($this->apiOptions);
        $request = new BatchUpdateStoreSKUPricesRequest($productArr, $this->bearerToken, $this->storeID);
        $response = $priceProducts->sendRequest($request)->getContent();

        return $response;

    }

}
