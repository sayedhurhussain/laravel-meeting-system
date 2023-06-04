<?php

namespace App\Http\Controllers;

use Google_Client;
use App\Models\User;
use App\Models\Meeting;
use Illuminate\Support\Str;

use Google_Service_Calendar;
use Illuminate\Http\Request;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\MeetingRequest;
use Google\Service\Calendar\EventDateTime;
use Google\Auth\ApplicationDefaultCredentials;
use App\Repositories\Interfaces\MeetingRepositoryInterface;


class MeetingController extends Controller
{
    protected $userRepository;

    public function __construct(MeetingRepositoryInterface $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meetings = $this->meetingRepository->all();
        return view('meetings.index', ['meetings' => $meetings]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('meetings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
     
     public function store(MeetingRequest $request)
     {
        $this->meetingRepository->create($request);
        return redirect('/meetings')->with('message', 'User created successfully');
     }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->meetingRepository->create($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $meeting = $this->meetingRepository->find($id);
        return view('meetings.edit', ['meeting' => $meeting]);
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, $id)
     {
        $this->meetingRepository->update($request, $id);

        return redirect('/meetings')->with('message', 'Meeting updated successfully');
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
