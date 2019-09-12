<?php


namespace App\TCGPlayer;

use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
use TrollAndToad\TCGPlayer\Catalog\ListProductSKUs;
use TrollAndToad\TCGPlayer\Catalog\ListProductSKUsRequest;
use TrollAndToad\TCGPlayer\Catalog\ListConditions;
use TrollAndToad\TCGPlayer\Catalog\ListConditionsRequest;


class SyncProducts {

    protected $info;
    protected $commonData;

    public function __construct(Repository $config, Connection $conn) {

        $this->info = new CommonInfo($config, $conn);
        $this->commonData = $this->info->getCommonData();

    }

    public function syncProducts(string $productID) {

        $syncProducts = new ListProductSKUs($this->commonData->apiOptions);
        $request = new ListProductSKUsRequest($this->commonData->bearerToken, $productID);
        $response = $syncProducts->sendRequest($request)->getContent();

        return $response;

    }

    public function getConditionName(int $conditionID) {

        $listConditions = new ListConditions($this->commonData->apiOptions);
        $request = new ListConditionsRequest($this->commonData->bearerToken);
        $response = $listConditions->sendRequest($request)->getContent();

        return $response;

    }

    public function syncArrays(array $trollArr, array $tcgArr) {



    }

}
