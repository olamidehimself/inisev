<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|unique:users|email|between:3,100',
            'name' => 'required|max:255|',
            'website_id' => 'required|exists:websites,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'error'  => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 400);
        }
        
        DB::beginTransaction();
            $user = User::firstOrCreate(
                ['email' => $request->email],
                ['name' => $request->name,]
            );

            Subscription::create([
                'user_id' => $user->id,
                'website_id' => $request->website_id
            ]);
        DB::commit();

        return response()->json(['msg' => 'Success'], 200);
    }
}
