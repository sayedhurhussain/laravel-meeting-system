<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface RegisterRepositoryInterface
{
    public function register(Request $request);
}