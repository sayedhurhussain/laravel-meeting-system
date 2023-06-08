<?php

namespace App\Repositories;

use Google_Client;
use App\Models\User;
use App\Models\Meeting;
use Illuminate\Support\Str;
use Google_Service_Calendar;
use Illuminate\Http\Request;

use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Auth;
use Google\Service\Calendar\EventDateTime;

use Google\Auth\ApplicationDefaultCredentials;
use App\Repositories\Interfaces\MeetingRepositoryInterface;

class MeetingRepository implements MeetingRepositoryInterface
{
    public function all()
    {
        $meetings = Meeting::where('creator_id', auth()->id())
        ->with('attendee1', 'attendee2', 'creator')
        ->paginate(10);
    
        return $meetings;    
    }

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
        $calendarId = env('CALENDAR_ID');
        $event = $service->events->insert($calendarId, $event);

    
        // Store the meeting event in the database
        $meeting = new Meeting([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date_time' => $request->input('date') . ' ' . $request->input('time') . ':00',
            'end_date_time' => $request->input('date') . ' ' . $request->input('time') . ':00',
            'event_id' => $event->getId(),
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

    public function find($id)
    {
        $meeting = Meeting::with('attendee1', 'attendee2', 'creator')->findOrFail($id);
        return $meeting;
    }

    public function update(Request $request, $id)
    {
        $client = new Google_Client();
        $client->setAuthConfig(base_path('app/Credentials/meeting-system.json'));
        $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
    
        $service = new Google_Service_Calendar($client);
        $calendarId = env('CALENDAR_ID');
        //show all events
        // $events = $service->events->listEvents($calendarId);
        $meeting = Meeting::find($id);
        $eventId = $meeting->event_id;
        $event = $service->events->get($calendarId, $eventId);
    
        $event->setSummary($request->input('title'));
        $event->setDescription($request->input('description'));

        $startDateTime = new EventDateTime();
        $startDateTime->setDateTime($request->input('date') . 'T' . $request->input('time') . ':00');
        $startDateTime->setTimeZone('Asia/Karachi');
        $event->setStart($startDateTime);
    
        $endDateTime = new EventDateTime();
        $endDateTime->setDateTime($request->input('date') . 'T' . $request->input('time') . ':00');
        $endDateTime->setTimeZone('Asia/Karachi');
        $event->setEnd($endDateTime);
        $updatedEvent = $service->events->update($calendarId, $eventId, $event);
    
        // Update the meeting event in the database
        $meeting = Meeting::find($id);
        $meeting->title = $request->input('title');
        $meeting->description = $request->input('description');
        $meeting->start_date_time = $request->input('date') . ' ' . $request->input('time');
        $meeting->end_date_time = $request->input('date') . ' ' . $request->input('time');
        $updateAttendee1 = User::where('id', $meeting->attendee1_id)->first();
        $updateAttendee1->name = $request->input('attendee1');
        $updateAttendee1->email = $request->input('attendee1');
        $updateAttendee1->update();

        $updateAttendee2 = User::where('id', $meeting->attendee2_id)->first();
        $updateAttendee2->email = $request->input('attendee2');
        $updateAttendee2->email = $request->input('attendee2');
        $updateAttendee2->update();
        
        $meeting->save();

        return $meeting;
    }

    public function delete($id)
    {
        $meeting = Meeting::findOrFail($id);
        
        // Get the event ID
        $eventId = $meeting->event_id;
        
        // Delete the event from Google Calendar
        $client = new Google_Client();
        $client->setAuthConfig(base_path('app/Credentials/meeting-system.json'));
        $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
        
        $service = new Google_Service_Calendar($client);
        $calendarId = env('CALENDAR_ID');
        
        $service->events->delete($calendarId, $eventId);
        $meeting->delete();

         // Remove the attendee relationship
        $attendee1 = User::findOrFail($meeting->attendee1_id);
        $attendee1->delete();

        $attendee2 = User::findOrFail($meeting->attendee2_id);
        $attendee2->delete();

        return null; 
    }
}