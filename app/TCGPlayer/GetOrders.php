<?php


namespace App\TCGPlayer;

use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
use TrollAndToad\TCGPlayer\Stores\Orders\SearchOrders;
use TrollAndToad\TCGPlayer\Stores\Orders\SearchOrdersRequest;
use TrollAndToad\TCGPlayer\Stores\Orders\GetOrderItems;
use TrollAndToad\TCGPlayer\Stores\Orders\GetOrderItemsRequest;

class GetOrders {

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

}
