<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
use App\TCGPlayer\ListProducts;
use App\TCGPlayer\TokenHandler;

class TestCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Test:Test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $conn;
    protected $config;
    protected $list;
    protected $token;
    /**
     * @var ListProducts
     */

    public function __construct(Repository $config, Connection $conn) {
        parent::__construct();

        $this->conn = $conn;
        $this->config = $config;
        $this->list = new ListProducts($config, $conn);
        $this->token = new TokenHandler($config, $conn);

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $testArr = array("skuID" => "262695", "price" => "19.99", "qty" => "3");

        $test = $this->list->removeProduct($testArr["skuID"]);
        $this->info(print_r($test));

    }
}
