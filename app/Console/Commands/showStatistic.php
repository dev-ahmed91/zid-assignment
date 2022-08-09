<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Repository\ItemRepository;
use Illuminate\Console\Command;

class showStatistic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:statistic {statistic}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show Statistics Data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected ItemRepository $itemsRepository;

    Protected const ALLOWED_STATISTICS = [
                                            'count_items' => ['method' => 'countAllData', 'column' => ""],
                                            'average_price'=>['method' => 'getAverageForColumn', 'column'=> "price"],
                                            'sum_price_month' => ['method' => 'getSumDataAddedThisMonth','column' => 'price']
                                         ];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ItemRepository $itemRepository)
    {
        parent::__construct();
        $this->itemsRepository = $itemRepository;
    }



    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $statistic = $this->argument('statistic');

        if(array_key_exists($statistic,self::ALLOWED_STATISTICS)){
            echo $this->itemsRepository->{self::ALLOWED_STATISTICS[$statistic]['method']}(self::ALLOWED_STATISTICS[$statistic]['column']);
        }
    }
}
