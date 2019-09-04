<?php


namespace App\TCGPlayer;

use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
use TrollAndToad\TCGPlayer\Pricing\ListSKUMarketPrices;
use TrollAndToad\TCGPlayer\Pricing\ListSKUMarketPricesRequest;

class GetPriceData {

    protected $info;
    protected $commonData;

    public function __construct(Repository $config, Connection $conn) {

        $this->info = new CommonInfo($config, $conn);
        $this->commonData = $this->info->getCommonData();

    }

    public function getLowestPriceData(array $skuArr) {

        $grabPriceData = new ListSKUMarketPrices($this->commonData->apiOptions);
        $request = new ListSKUMarketPricesRequest($this->commonData->bearerToken, $skuArr);
        $response = $grabPriceData->sendRequest($request)->getContent();

        return $response;

    }


}
