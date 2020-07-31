<?php
namespace App\Services;
use App\Person;

class PersonService
{
    public function getPersonByCode($code)
    {
        return Person::where('code', '=', $code)->first();
    }

    public function getPersonById($id)
    {
        return Person::where('id', '=', $id)->first();
    }

    public function createPerson($data, $event)
    {
        $person = Person::create([
            'code' => bin2hex(openssl_random_pseudo_bytes(12)),
            'username' => $data['person_name'],
            'email' => $data['email'],
            'event_id' => $event->id,
        ]);
        
        return $person;
    }

}