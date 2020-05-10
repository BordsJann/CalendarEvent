<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Event;
use App\Http\Resources\EventCollection;

class EventController extends Controller
{

    protected $parent;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::whereNotNull('parent_id')->get();

        return EventCollection::collection($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $days   = Carbon::parse($request->start_date)->daysUntil($request->end_date);
        $ranges = collect([]);

        if(!$request->parent_id){
            $parentEvent = new Event();
            $parentEvent->title  = $request->title;
            $parentEvent->color  = $request->color;
            $parentEvent->start_date  = Carbon::parse($request->start_date);
            $parentEvent->end_date  = Carbon::parse($request->end_date);
            $parentEvent->save();
        }
        
        if (!empty($request->parent_id)) {
            Event::where('parent_id', $request->parent_id)->delete();
            $parentEvent = Event::findOrFail($request->parent_id);
        }

        collect($days)->each(function ($day) use ($ranges, $parentEvent){
            $day = Carbon::parse($day);

            $event = new \stdClass;

            if ( in_array($day->format('D'), request('days')) || count(request('days')) === 0 ) {
                $day               = $day->format('Y-m-d');
                $event->start_date = $day;
                $event->end_date   = $day;

                $data = Event::create([
                    'title' => request('title'),
                    'color' => request('color'),
                    'parent_id' => $parentEvent->id,
                    'start_date' => Carbon::parse($event->start_date),
                    'end_date' => Carbon::parse($event->end_date),
                ]);

                $ranges->push($data);
            }
        });
        
        return EventCollection::collection($ranges);
    }
}
