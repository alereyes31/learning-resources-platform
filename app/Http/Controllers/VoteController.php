<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Voter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;


class VoteController extends Controller
{
    public function __invoke(Request $request, Resource $resource)
    {
        $voter = Voter::getOrCreateVoter($request);
        $resource->votes()->toggle($voter->id);

        return $resource->load('votes','category');
        
    }
    
}
