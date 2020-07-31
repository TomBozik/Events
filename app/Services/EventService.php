<?php
namespace App\Services;
use App\Event;

class EventService
{

    public function createEvent($data)
    {
        $event = Event::create([
            'code' => bin2hex(openssl_random_pseudo_bytes(12)),
            'name' => $data['event_name'],
            // 'description' => $data['description'],
            // 'max_answers' => $data['max_answers'],
            'password' => $data['event_password'],
        ]);
        
        return $event;
    }


    public function updateEvent($event, $data)
    {
        $event->update($data);
        return $event;
    }


    public function getEventByCode($code)
    {
        return Event::where('code', '=', $code)->first();
    }

    public function getEventById($id)
    {
        return Event::where('id', '=', $id)->first(); 
    }


    public function addAdmin($event, $person)
    {
        $event->update([
            'admin_id' => $person->id
        ]);
        
        return $event;
    }

}