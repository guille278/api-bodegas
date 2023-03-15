<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Storage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function resume($storageId, $planId)
    {
        $storage = Storage::find($storageId);
        if (!$storage->available)  return response(
            [
                'success' => false,
                "errors" => "Este espacio no se encuentra disponible en este momento."
            ],
            Response::HTTP_ACCEPTED
        );

        $endDate = new Carbon();
        $currentDate = Carbon::now();

        switch ($planId) {
            case 0:
                $endDate->addMonths(1);
                break;
            case 1:
                $endDate->addMonths(3);
                break;
            case 2:
                $endDate->addMonths(6);
                break;
            case 3:
                $endDate->addYear();
                break;
        }

        return response([
            "success" => true,
            "storage" => $storage,
            "start_date" => $currentDate,
            "end_date" => $endDate
        ]);
    }

    public function checkout(Request $request)
    {
        $storage = Storage::find($request->storage_id);
        if (!$storage->available)  return response(
            [
                'success' => false,
                "errors" => "Este espacio no se encuentra disponible en este momento."
            ],
            Response::HTTP_ACCEPTED
        );

        $storage->available = false;
        $storage->update();

        $endDate = new Carbon();
        $currentDate = Carbon::now();

        switch ($request->plan_id) {
            case 0:
                $endDate->addMonths(1);
                break;
            case 1:
                $endDate->addMonths(3);
                break;
            case 2:
                $endDate->addMonths(6);
                break;
            case 3:
                $endDate->addYear();
                break;
        }

        $user = User::find(Auth::user()->id);
        
        $user->contracts()->attach($storage->id,
        [
            "total" => $storage->price,
            "start_date" => $currentDate,
            "end_date" => $endDate,
        ]);
        return response(["success" => true], Response::HTTP_ACCEPTED);
    }
}
