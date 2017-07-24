<?php

use Illuminate\Database\Seeder;
use App\Coin;

class CoinTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coins = array(
            array('name' => 'ETP Token', 'code' => 'ETP'),
    		array('name' => 'Bitcoin', 'code' => 'BTC'),
    		array('name' => 'Ethereum', 'code' => 'ETH'),
    		array('name' => 'Dinarcoin', 'code' => 'DNC'),
    	);

    	foreach ($coins as $key => $coin) {
    		Coin::create($coin);
    	}
    }
}
