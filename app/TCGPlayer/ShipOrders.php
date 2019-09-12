<?php


namespace App\TCGPlayer;

use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
use TrollAndToad\TCGPlayer\Stores\Orders\AddOrderTrackingNumber;
use TrollAndToad\TCGPlayer\Stores\Orders\AddOrderTrackingNumberRequest;


class ShipOrders {

    protected $info;
    protected $commonData;

    public function __construct(Repository $config, Connection $conn) {

        $this->info = new CommonInfo($config, $conn);
        $this->commonData = $this->info->getCommonData();

    }

    public function sendTracking(array $orderArr) {

        $trackingJSON = json_encode($orderArr["trackingArr"]);

        $sendTracking = new AddOrderTrackingNumber($this->commonData->apiOptions);
        $request = new AddOrderTrackingNumberRequest([$trackingJSON], $this->commonData->bearerToken, $this->commonData->storeID, $orderArr["orderID"]);
        $response = $sendTracking->sendRequest($request)->getContent();

        return $response;

    }


}
