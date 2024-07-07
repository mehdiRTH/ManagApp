<?php

namespace App\Repositories;

use App\Models\Holiday;

class HolidayRepository{

    public function  store($request) : void
    {
        Holiday::create($this->holiday_credentials($request));
    }

    public function update($request, $holiday) : void
    {
        $holiday->update($this->holiday_credentials($request));
    }

    public function destroy(Holiday $holiday) : void
    {
        $holiday->delete();
    }

    private function holiday_credentials($request) : Array
    {
        return [
            'name'=>$request->name,
            'start_date'=>$request->start,
            'end_date'=>$request->end
        ];
    }
}
