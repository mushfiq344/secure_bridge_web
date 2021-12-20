<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Opportunity;
class UpdateOpportunityStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-opportunity-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Opportunity Status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Opportunity::where('opportunity_date', '<=',date("Y-m-d"))->where('status',Opportunity::$opportunityStatusValues['Published'])
        ->update(['status' => Opportunity::$opportunityStatusValues['Currently Happening']]);
    }
}
