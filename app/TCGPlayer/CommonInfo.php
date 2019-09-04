<?php


namespace App\TCGPlayer;

use Illuminate\Config\Repository;
use TrollAndToad\TCGPlayer\Core\ApiCallOptions;
use Illuminate\Database\Connection;

class CommonInfo {

    protected $config;
    protected $conn;
    protected $bearerToken;

    public function __construct(Repository $config, Connection $conn) {

        $this->config = $config;
        $this->conn = $conn;

    }

    public function getConn() {

        $conn = $this->conn;
        return $conn;

    }

    public function getBearerToken() {

        $tokenHandle = new TokenHandler($this->config, $this->conn);
        $this->bearerToken = $tokenHandle->getBearerToken();
        return $this->bearerToken;

    }

    public function getStoreID() {

        $storeID = $this->config->get("tcgplayer_settings.tcgplayer.store_key");
        return $storeID;

    }

    public function getChannelID() {

        $channelID = $this->config->get("tcgplayer_settings.tcgplayer.channelID");
        return $channelID;

    }

    public function getApiOptions() {

        $options = new ApiCallOptions();
        return $options;

    }

    public function getURLToken() {

        $urlToken =  $this->config->get("tcgplayer_settings.tcgplayer.url_token");
        return $urlToken;

    }

    public function getPublicKey() {

        $publicKey = $this->config->get("tcgplayer_settings.tcgplayer.public_key");
        return $publicKey;

    }

    public function getPrivateKey() {

        $privateKey = $this->config->get("tcgplayer_settings.tcgplayer.private_key");
        return $privateKey;

    }

    public function getAccessKey() {

        $accessKey = $this->config->get("tcgplayer_settings.tcgplayer.access_key");
        return $accessKey;

    }


}
