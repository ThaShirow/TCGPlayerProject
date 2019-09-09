<?php

namespace App\Console\Commands;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use App\TCGPlayer\GetPriceData;
use Carbon\Carbon;

class CommandGetPriceData extends Command {

    protected $signature = 'command:getpricedata';
    protected $description = 'Grab price data from TCGPlayer to use internally.';

    protected $grabPrices;
    protected $conn;

    public function __construct(Repository $config, Connection $conn) {

        parent::__construct();

        $this->conn = $conn;
        $this->grabPrices = new GetPriceData($config, $conn);

    }

    public function handle() {

        $countDown = 0;
        $resultArr = array();

        $dataObjArr = $this->conn->table("product_affiliate_mapping")
            ->orderBy("updated_at", "asc")
            ->limit(500);

        //$dataObjArr = Object("id" => serial, "productid" => our_product_id, "productdetailid" => our_product_detail_id, "affiliateid" => tcgplayerID, "affiliateproductid" => tcgproductid, "affiliateproductdetailid" => tcg sku, "created_at" date, "updated_at" date)

        if(count($dataObjArr) > 0) {

            foreach ($dataObjArr as $dataObj) {

                $skuArr[] = $dataObj->affiliateproductid;
                $countDown++;

                if ($countDown == 10) {

                    $resultArr = array_merge($resultArr, $this->grabPrices->getLowestPriceData($skuArr)["results"]);
                    $countDown = 0;
                    $skuArr = array();

                }

            }

            $alteredArr = array();

            foreach ($resultArr as $result) {

                $alteredArr[$result["skuId"]] = $result;

            }

            foreach ($dataObjArr as $dataObj) {

                $value = $alteredArr[$dataObj->affiliateproductid];

                foreach ($value as $name => $val) {

                    $dataObj->$name = $val;

                }

                $this->conn->table("affiliate_prices_t")
                    ->updateOrInsert(["affiliateid" => $dataObj->affiliateid, "affiliateproductdetailid" => $dataObj->affiliateproductdetailid],
                        ["low_price" => $dataObj->lowPrice, "lowest_shipping" => $dataObj->lowestShipping, "lowest_listing_price" => $dataObj->lowestListingPrice, "marketprice" => $dataObj->marketPrice,
                            "direct_low_price" => $dataObj->directLowPrice, "updated_at" => Carbon::now()]);

            }

        }

    }
}
