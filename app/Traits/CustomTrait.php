<?php

namespace App\Traits;
use Carbon\Carbon;

trait CustomTrait
{
    static public function SuccessResponse($data,$statusCode=200){
        return Response()->json([
            'status'=>true,
            'response'=>$data
        ],$statusCode);
    }

    static public function ErrorResponse($data,$statusCode=422){
        return Response()->json([
            'status'=>false,
            'response'=>$data
        ],$statusCode);
    }

    static public function isOlderThan($dateOfBirth,$mininum)
    {
        $date = Carbon::parse($dateOfBirth);
        $today = Carbon::now();
        $age = $today->diffInYears($date);

        return $age >= $mininum;
    }
}
