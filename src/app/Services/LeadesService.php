<?php

namespace App\Services;
use App\Models\Leads;

class LeadesService {
   public function getLeadsByName($name) : array
   {

        return Leads::where('name', 'LIKE', "%$name%")->get()->map(function($lead) {
            return [
                'id' => $lead->id,
                'name' => $lead->name ?? null,
                'phone' => $lead->phone ?? null,
                'email' => $lead->email ?? null,
                'status' => $lead->status ?? null,
            ];
        })->toArray();
   }
}