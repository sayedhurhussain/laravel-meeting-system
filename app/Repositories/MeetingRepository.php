<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Google_Client;
use App\Models\Meeting;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Google\Auth\ApplicationDefaultCredentials;

use App\Repositories\Interfaces\MeetingRepositoryInterface;

class MeetingRepository implements MeetingRepositoryInterface
{
    public function create(Request $request)
    {
        $client = new Google_Client();
        $client->setAuthConfig(base_path('app/Credentials/meeting-system.json'));
        $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
    
        $service = new Google_Service_Calendar($client);
    
        $event = new Google_Service_Calendar_Event([
            'summary' => $request->input('title'),
            'description' => $request->input('description'),
            'start' => [
                'dateTime' => $request->input('date') . 'T' . $request->input('time') . ':00',
                'timeZone' => 'Asia/Karachi',
            ],
            'end' => [
                'dateTime' => $request->input('date') . 'T' . $request->input('time') . ':00',
                'timeZone' => 'Asia/Karachi',
            ],
        ]);
    
        $calendarId = '38f5b1e422008d8cffb24cf68350f8a356cf3809763d04daacb2267e938fe586@group.calendar.google.com';
    
        $event = $service->events->insert($calendarId, $event);
    
        // Store the meeting event in the database
        $meeting = new Meeting([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date_time' => $request->input('date') . ' ' . $request->input('time') . ':00',
            'end_date_time' => $request->input('date') . ' ' . $request->input('time') . ':00',
            'creator_id' => Auth::id(),
            'attendee1_id' => $this->getOrCreateUserByEmail($request->input('attendee1'))->id,
            'attendee2_id' => $this->getOrCreateUserByEmail($request->input('attendee2'))->id,
        ]);
        $meeting->save();
    
        return $meeting;
    }
    
    private function getOrCreateUserByEmail($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = new User();
            $user->name = $email; // Use email as the name
            $user->email = $email;
            $user->password = bcrypt(Str::random(10));
            $user->save();
        }

        return $user;
    }

}