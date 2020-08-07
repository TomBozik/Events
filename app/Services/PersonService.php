<?php
namespace App\Services;

use App\Event;
use App\Person;
use App\Mail\PersonalCode;
use Illuminate\Support\Facades\Mail;

class PersonService
{
    public function checkIfAdmin($event, $person)
    {
        if ($person->id == $event->admin_id) {
            return 1;
        }

        return 0;
    }

    public function getPersonByCode($code)
    {
        return Person::where('code', $code)->first();
    }
    // public function getPersonById($id)
    // {
    //     return Person::where('id', $id)->firstOrFail();
    // }

    public function createPerson($data, $event)
    {
        $person = Person::create([
            'code' => bin2hex(openssl_random_pseudo_bytes(12)),
            'username' => $data['person_name'],
            'email' => $data['email'],
            'event_id' => $event->id,
        ]);

        if ($person->email) {
            Mail::to($person->email)->send(new PersonalCode($person->code, $event));
        }

        return $person;
    }

    public function deletePerson($personCode, $id)
    {
        $person = Person::where('code', $personCode)->first();
        $event = Event::where('id', $person->event_id)->firstOrFail();
        $personToDelete = Person::where('id', $id)->first();

        if (($person->id == $event->admin_id) && ($personToDelete->event_id == $event->id) && ($personToDelete->id != $event->admin_id)) {
            $personToDelete->answers()->delete();
            $personToDelete->delete();
            return true;
        }

        return false;
    }
}
