<?php
namespace App\Traits;

use App\Models\Settings\Setting;

trait RunJobTrait {

    // public function runJob($job){
    //     $setting = optional(Setting::where('key','payout_cron_job')->first())->value;
    //     switch ($setting) {
    //         case 'everyMinute':
    //             $job->everyMinute();
    //             break;
    //         case 'everyTwoMinutes':
    //             $job->everyTwoMinutes();
    //             break;
    //         case 'everyThreeMinutes':
    //             $job->everyThreeMinutes();
    //             break;
    //         case 'everyFourMinutes':
    //             $job->everyFourMinutes();
    //             break;
    //         case 'everyFiveMinutes':
    //             $job->everyFiveMinutes();
    //             break;
    //         case 'everyTenMinutes':
    //             $job->everyTenMinutes();
    //             break;
    //         case 'everyFifteenMinutes':
    //             $job->everyFifteenMinutes();
    //             break;
    //         case 'everyThirtyMinutes':
    //             $job->everyThirtyMinutes();
    //             break;
    //         case 'hourly':
    //             $job->hourly();
    //             break;
    //         default:
    //             $job->everyTwoMinutes();
    //             break;
    //     }
    // }

}
