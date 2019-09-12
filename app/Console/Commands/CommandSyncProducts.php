<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
use App\TCGPlayer\SyncProducts;


class CommandSyncProducts extends Command
{

    protected $signature = 'command:syncproducts';
    protected $description = 'Takes our productid and tcgplayers productid and syncs our productdetailid with tcgplayers SKUs';
    protected $syncProducts;
    protected $conn;

    public function __construct(Repository $config, Connection $conn) {

        parent::__construct();

        $this->conn = $conn;
        $this->syncProducts = new SyncProducts($config, $conn);

    }


    public function handle() {

        $dataObjArr = $this->conn->table("product_affiliate_mapping")
            ->where("productdetailid", "=", 0)
            ->where("affiliateproductdetailid", "=", 0)
            ->orderBy("created_at", "asc")
            ->limit(10)
            ->get();

        print "<pre>"; print_r($dataObjArr); print "</pre>";

    }
}
