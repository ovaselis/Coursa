@extends('layouts.app')

@section('content')


<div class="w-full" x-data="{open: false, selectedDate: ''}">
    <div class="flex items-center justify-between">
        <div>
            <h1>{{ $currentMonth->format('F Y') }}</h1>

            <p class="text-sm text-gray-500 mt-1">Calendar</p>
        
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('calendar.index', ['month' => $currentMonth->copy()->subMonth()->format('Y-m')])}}">Previous</a>

            <a  href="{{ route('calendar.index', ['month' => now()->format('Y-m')]) }}">Today</a>
            <a href="{{ route('calendar.index', ['month' => $currentMonth->copy()->addMonth()->format('Y-m')]) }}">Next</a>

        </div>  
    </div>
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="grid grid-cols-7">
            <div class="p-3 text-center text-sm font-semibold text-gray-600">Monday</div>
            <div class="p-3 text-center text-sm font-semibold text-gray-600">Tuesday</div>
            <div class="p-3 text-center text-sm font-semibold text-gray-600">Wednesday</div>
            <div class="p-3 text-center text-sm font-semibold text-gray-600">Thursday</div>
            <div class="p-3 text-center text-sm font-semibold text-gray-600">Friday</div>
            <div class="p-3 text-center text-sm font-semibold text-gray-600">Saturday</div>
            <div class="p-3 text-center text-sm font-semibold text-gray-600">Sunday</div>
        </div>
        <div class="grid grid-cols-7">
            @php
                //starts from the first visible day in the calendar
                $day = $calendarStart->copy();
            @endphp

            @while($day <= $calendarEnd)
                @php

                    $dateKey = $day->format('Y-m-d');

                    $isCurrentMonth = $day->month === $currentMonth->month;

                    $isToday = $day->isToday();

                @endphp
                
                <div 
                    @click="open = true; selectedDate = '{{ $day->format('Y-m-d') }}'"
                    class="min-h-36 p-3 border border-gray-200 {{ !$isCurrentMonth ? 'bg-gray-50' : 'bg-white' }}"
                    >
                    <div class="mb-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full text-sm font-medium
                            {{ !$isCurrentMonth ? 'text-gray-400' : 'text-gray-700' }}
                            {{ $isToday ? 'bg-slate-900 text-white' : '' }}">
                             
                            {{ $day->day }}
                        </span>
                    </div>

                    {{-- Checks if this day contains events --}}
                    @if(isset($events[$dateKey]))
                        <div class="space-y-1">
                            {{-- Displays all events for this date --}}
                            @foreach($events[$dateKey] as $event)
                                <a @click.stop href="{{ route('courses.calendar-events.show',[$event->course, $event]) }}"
                                    class=" block px-2 py-1 rounded text-xs

                                        @if($event->type === 'task' && $event->is_completed)
                                            bg-gray-200 text-gray-500 line-through
                                        @elseif($event->type === 'lecture')
                                            bg-blue-100 text-blue-800
                                        @elseif($event->type === 'task')
                                            bg-amber-100 text-amber-800
                                        @elseif($event->type === 'assessment')
                                            bg-red-100 text-red-800
                                        @endif
                                        "
                                >
                                    {{-- Event time --}}
                                    {{ $event->starts_at->format('H:i') }}

                                    {{-- Event title --}}
                                    {{ $event->title }}
                                
                                </a>
                            @endforeach
                        </div>

                    @endif       
                </div>

                @php
                    
                    $day->addDay(); //goes to next calendar day
                @endphp


            @endwhile

        </div>
    </div>

    {{-- event popup --}}
    <div x-show="open" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div @click.outside="open = false"  class="bg-white rounded-xl p-6 w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Add calendar event</h2>
            <form method="POST" action=" {{ route('calendar.events.store') }}">
                @csrf

                <label>Date</label>

                <input type="date" name="date" x-model="selectedDate" class="w-full border rounded px-3 py-2 mb-4">
                
                <label>Course</label>

                <select name="course_id" class="w-full border rounded px-3 py-2 mb-4" required>
                    <option value="">Select course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">
                            {{ $course->name }}
                        </option>
                    @endforeach

                </select>

                <label>Type</label>

                <select name="type" class="w-full border rounded px-3 py-2 mb-4" required>

                    <option value="lecture">Lecture</option>
                    <option value="task">Task</option>
                    <option value="assessment">Assessment</option>
                
                </select>

                <label>Title</label>

                <input type="text" name="title" class="w-full border rounded px-3 py-2 mb-4" required>

                <label>Description</label>

                <textarea name="description" class="w-full border rounded px-3 py-2 mb-4"></textarea>

                <label>Start time</label>

                <input type="time" name="start_time" class="w-full border rounded px-3 py-2 mb-4" required>

                <label>End time</label>

                <input type="time" name="end_time" class="w-full border rounded px-3 py-2 mb-4">

                <div class="flex gap-2">

                    <button type="submit" class="px-4 py-2 bg-teal-950 text-white rounded">Save</button>

                    <button type="button" @click="open = false" class="border rounded px-4 py-2">Close</button>
                </div>

            </form>        
        </div>
    </div>

</div>


@endsection