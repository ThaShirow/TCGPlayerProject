<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Illuminate\Database\Connection;
use App\TCGPlayer\ListProducts;
use App\TCGPlayer\TokenHandler;
use App\TCGPlayer\GetPriceData;

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
    protected $grabPrice;

    /**
     * @var ListProducts
     */

    public function __construct(Repository $config, Connection $conn) {
        parent::__construct();

        $this->conn = $conn;
        $this->config = $config;
        $this->list = new ListProducts($config, $conn);
        $this->token = new TokenHandler($config, $conn);
        $this->grabPrice = new GetPriceData($config, $conn);

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $sku = array(14602);

        $test = $this->grabPrice->getLowestPriceData($sku);
        $this->info(print_r($test));

    }
}
