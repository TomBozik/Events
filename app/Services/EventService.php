<?php
namespace App\Services;
use App\Event;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;

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

    public function getOverlaps($event)
    {
        $eventAnswers = $event->answers()->get();

        $sortedEventAnswersByPerson = [];
        foreach($eventAnswers as $answer){
            $sortedEventAnswersByPerson[$answer->person_id][] = $answer;
        }
        $sortedEventAnswersByPerson = array_values($sortedEventAnswersByPerson);


        $allPeriods = [];
        foreach($sortedEventAnswersByPerson as $personAnswers){
            $personAnswersPeriodCollection = new PeriodCollection();
            foreach($personAnswers as $personAnswer){
                $personAnswersPeriodCollection = $personAnswersPeriodCollection->add(Period::make($personAnswer->from, $personAnswer->to));
            }
            array_push($allPeriods, $personAnswersPeriodCollection);
        }

        $last = array_pop($allPeriods);
        $overlaps = $last->overlap(...$allPeriods);
        $overlapsArr = [];

        foreach($overlaps as $overlap){
            $overlapElement = [
                'title' => 'EVERYONE',
                'start' => \DateTime::createFromImmutable($overlap->getStart())->format('Y-m-d'),
                'end' => \DateTime::createFromImmutable($overlap->getEnd())->modify('+1 day')->format('Y-m-d')
            ];
            array_push($overlapsArr, $overlapElement);
        }

        return json_encode($overlapsArr);

    }

}