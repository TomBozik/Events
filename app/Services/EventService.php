<?php
namespace App\Services;

use App\Person;
use App\Event;
use App\Services\PersonService;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;

class EventService
{

    protected $personService;

    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    public function saveEvent($data)
    {
        $event = Event::create([
            'code' => bin2hex(openssl_random_pseudo_bytes(12)),
            'name' => $data['event_name'],
            'password' => $data['event_password'],
        ]);

        $person = $this->personService->createPerson($data, $event);
        $event = tap($event)->update([
            'admin_id' => $person->id,
        ]);

        return array($event, $person);
    }

    public function getEventByCode($code)
    {
        return Event::where('code', $code)->first();
    }

    public function getEventById($id)
    {
        return Event::where('id', $id)->firstOrFail();
    }

    public function getEventPersons($personCode)
    {
        $person = Person::where('code', $personCode)->first();
        $event = Event::where('id', $person->event_id)->firstOrFail();
        return $event->peoples()->get();
    }

    public function getEvent($personCode)
    {
        $person = Person::where('code', $personCode)->first();
        $event = Event::where('id', $person->event_id)->firstOrFail();
        return $event;
    }

    public function updateEvent($personCode, $data)
    {
        $person = Person::where('code', $personCode)->first();
        $event = Event::find($person->event_id);
        $event = tap($event)->update($data);
        return $event;
    }

    public function getOverlaps($personCode)
    {
        $person = Person::where('code', $personCode)->first();
        $event = Event::where('id', $person->event_id)->firstOrFail();
        $eventAnswers = $event->answers()->get();

        $sortedEventAnswersByPerson = [];
        foreach ($eventAnswers as $answer) {
            $sortedEventAnswersByPerson[$answer->person_id][] = $answer;
        }
        $sortedEventAnswersByPerson = array_values($sortedEventAnswersByPerson);

        $allPeriods = [];
        foreach ($sortedEventAnswersByPerson as $personAnswers) {
            $personAnswersPeriodCollection = new PeriodCollection();
            foreach ($personAnswers as $personAnswer) {
                $personAnswersPeriodCollection = $personAnswersPeriodCollection->add(Period::make($personAnswer->from, $personAnswer->to));
            }
            array_push($allPeriods, $personAnswersPeriodCollection);
        }

        $last = array_pop($allPeriods);
        $overlaps = ($last != null ? $last->overlap(...$allPeriods) : []);
        $overlapsArr = [];

        foreach ($overlaps as $overlap) {
            $overlapElement = [
                'title' => 'EVERYONE',
                'start' => \DateTime::createFromImmutable($overlap->getStart())->format('Y-m-d'),
                'end' => \DateTime::createFromImmutable($overlap->getEnd())->modify('+1 day')->format('Y-m-d'),
            ];
            array_push($overlapsArr, $overlapElement);
        }

        return json_encode($overlapsArr);

    }

}
