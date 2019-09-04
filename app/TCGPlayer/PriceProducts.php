<?php


namespace App\TCGPlayer;

use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
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

    public function priceProducts(array $productArr) {

        $skuID = $productArr["skuID"];
        $price = floatval($productArr["price"]);

        $priceProducts = new UpdateSKUInventoryPrice($this->apiOptions);
        $request = new UpdateSKUInventoryPriceRequest(["price" => $price, "channelid" => $this->channelID], $this->bearerToken, $this->storeID, $skuID);
        $response = $priceProducts->sendRequest($request)->getContent();

        return $response;


    }

}
