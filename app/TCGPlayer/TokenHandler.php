<?php

namespace App\TCGPlayer;

use GuzzleHttp\Client;
use Illuminate\Config\Repository;
use Illuminate\Database\Connection;

class TokenHandler {

    protected $config;
    protected $conn;
    protected $info;

    public function __construct(Repository $config, Connection $conn) {

        $this->info = new CommonInfo($config, $conn);
        $this->conn = $this->info->getConn();

    }

    public function getBearerToken() {

        $bearerToken = $this->conn->table("api_credentials_t")
            ->where("api_name", "TCGPlayer")
            ->first();

        $authToken = $bearerToken->auth_token;
        $expireDate = $bearerToken->auth_expires_on;
        $isExpired = $this->isTokenExpired($expireDate);

        if($isExpired) {

           $authToken = $this->refreshBearerToken();

           return $authToken;

        } else {

            return $authToken;

        }

    }

    public function refreshBearerToken() {

        $url = $this->info->getURLToken();
        $publicKey = $this->info->getPublicKey();
        $privateKey = $this->info->getPrivateKey();
        $accessKey = $this->info->getAccessKey();

        $headers = ["X-Tcg-Access-Token" => $accessKey];
        $body = "grant_type=client_credentials&client_id=".$publicKey."&client_secret=".$privateKey;

        $client = new Client();

        try {

            $response = $client->post($url, ["body" => $body, "headers" => $headers]);

        } catch (\Exception $e) {

        }

        $response = json_decode($response->getBody()->getContents(), TRUE);

        $authToken = $response["access_token"];
        $expiresDate = $response[".expires"];

        $result = $this->conn->table("api_credentials_t")
            ->where("api_name", "TCGPlayer")
            ->update(["auth_token" => $authToken, "auth_expires_on" => $expiresDate]);

        if($result) {

            return $authToken;

        } else {

        }


    }

    public function isTokenExpired($authTokenDate) {

        if(strtotime($authTokenDate) > strtotime("+2 Days")) {

            return false;

        } else {

            return true;

        }

    }




}
