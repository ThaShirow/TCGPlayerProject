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
            ->whereNotNull("affiliateproductdetailid")
            ->whereNotNull("productdetailid")
            ->where("affiliateproductdetailid", "!=", 0)
            ->where("productdetailid", "!=", 0)
            ->orderBy("updated_at", "asc")
            ->limit(500)
            ->get();

        if(count($dataObjArr) > 0) {

            foreach ($dataObjArr as $dataObj) {

                $skuArr[] = $dataObj->affiliateproducdetailtid;
                $countDown++;

                if ($countDown == 10) {
                    //print "<pre>"; print_r($skuArr); print "</pre>";
                    $resultArr = array_merge($resultArr, $this->grabPrices->getLowestPriceData($skuArr)["results"]);
                    print "<pre>"; print_r($resultArr); print "</pre>"; exit;
                    $countDown = 0;
                    $skuArr = array();

                }

            }

            print "<pre>"; print_r($resultArr); print "</pre>"; exit;

            $alteredArr = array();

            foreach ($resultArr as $result) {

                $alteredArr[$result["skuId"]] = $result;

            }

            print "<pre>"; print_r($alteredArr); print "<pre>"; exit;

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

            $this->conn->raw();

        }

    }
}
