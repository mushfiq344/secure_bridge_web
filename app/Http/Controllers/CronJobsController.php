<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;

class CronJobsController extends Controller
{
    public function updateOpportunityStatus(){
        Opportunity::where('opportunity_date', '<=',date("Y-m-d"))
        ->update(['status' => Opportunity::$opportunityStatusValues['Currently Happening']]);
    }
}
