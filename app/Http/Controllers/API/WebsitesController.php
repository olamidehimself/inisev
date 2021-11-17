<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Website;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendPostMailToUsersJob;
use Illuminate\Support\Facades\Validator;

class WebsitesController extends Controller
{
    public function getAllWebsites()
    {
        return response()->json(Website::all(), 200);
    }

    public function createPost(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|between:3,100',
            'description' => 'required|max:255|',
            'website_id' => 'required|exists:websites,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'error'  => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 400);
        }

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'website_id' => $request->website_id,
            'sends_at' => Carbon::parse($request->sends_at)->format('Y-m-d H:i:s')
        ]);

        $post->load('website');
        if (!$request->sends_at) {
            SendPostMailToUsersJob::dispatch($post, $post->website);
        }

        return response()->json(['msg' => 'Post Created Successfully'], 200);
    }
}
