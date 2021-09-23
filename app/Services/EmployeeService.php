<?php

namespace App\Services;

class EmployeeService{

    static function formRequest($request){
        return [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company_id' => $request->company_id,
            'email' => $request->email ?? NULL,
            'phone' => $request->phone ?? NULL,
        ];
    }
}
