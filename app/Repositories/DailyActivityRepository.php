<?php

namespace App\Repositories;

use App\Models\DailyActivity;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\Foreach_;

class DailyActivityRepository{

    public function activityData(DailyActivity $dailyActivity)
    {
       return  $dailyActivity->filterInOut();
    }

    public function userActivity(User $user)
    {
        $userActivity=$user->dailyActivities;
        $activity=null;
        if($userActivity){
           $activity= $userActivity;
        }
        else{
           $activity= $user->dailyActivities()->create();
        }

        return $activity;
    }

    public function checkQr($qrCode)
    {
        $user=auth()->user();
        $response=['error'=>'QrCode doesn\'t exist','user'=>null];

        if($this->isEncrypted($qrCode)){
            $user=User::find(decrypt($qrCode));
            if($user){
                $userActivity=$user->dailyActivities;
                if($userActivity){
                    $userActivity->update([
                        'in_out'=>$this->checkInOut($userActivity)[0]
                    ]);

                }else{
                    DailyActivity::create([
                        'in_out'=>[
                                now()->format('Y-m-d')=>[
                                    'in'=>now()->addHours(2)->format('H:i:s')
                                ]
                            ],
                        'user_id'=>$user->id
                    ]);
                }
                $response= ['error'=>null,'user'=>$user,'status'=>$this->checkInOut($userActivity)[1]];
            }
        }

        return $response;
    }

    protected function checkInOut($activity)
    {
        $activity_in_out = $activity->in_out ?? [];
        $currentDate = now()->format('Y-m-d');
        $currentTime = now()->addHours(2)->format('H:i:s');
        $status=null;

        // Check if there are any activities for today
        $todayActivities = $activity_in_out[$currentDate] ?? [];

        if (!empty($todayActivities)) {
            $activityCount = count($todayActivities);
            $lastActivityKey = array_key_last($todayActivities);

            // Determine if the last activity is an 'in' or 'out'
            $status = str_contains($lastActivityKey, 'in') ? 'out_' : 'in_';

            $index = (int) ceil(($activityCount + 1) / 2);

            $nextKey = $status . $index;
            $todayActivities[$nextKey] = $currentTime;
        } else {
            // If no activities for today, initialize with 'in_1'
            $todayActivities['in_1'] = $currentTime;
            $status = 'in';
        }

        // Update the activity_in_out array with today's activities
        $activity_in_out[$currentDate] = $todayActivities;

        ksort($activity_in_out);

        return [$activity_in_out,$status];
    }

    protected function isEncrypted(string $encryptedString){

        try{
             Crypt::decryptString($encryptedString);
            return true;

        }catch(\Illuminate\Contracts\Encryption\DecryptException $ex){

           //DecryptException thrown by laravel, so we can assume this text is already encrypted.
            return false;

        }catch(Exception $ex){

            //some other error occured
            return false;
        }

        return false;
    }
}
