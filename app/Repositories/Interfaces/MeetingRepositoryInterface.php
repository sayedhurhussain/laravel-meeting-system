<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface MeetingRepositoryInterface
{
    public function all();
    public function create(Request $request);
    public function find($id);
    public function update(Request $request, $id);
}