<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface MeetingRepositoryInterface
{
    public function create(Request $request);
}