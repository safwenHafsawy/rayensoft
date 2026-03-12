<?php

namespace App\Services;

use App\Models\ExternalMeeting;

class MeetingsServices {
    public function getMeetingsInDateRange($startDate, $endDate) 
    {
        return ExternalMeeting::whereBetween('date', [$startDate, $endDate])->with('lead')->get();
    }
}