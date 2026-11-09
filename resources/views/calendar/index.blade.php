@extends('layouts.app')

@section('content')


<div class="w-full" x-data="{open: false, selectedDate: '', eventType: ''}">
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

                    @php
                        $dayTasks = $tasks->filter(function($task) use ($dateKey){
                            return $task->deadline->format('Y-m-d') === $dateKey;
                        });
                        $dayAssessments = $assessments->filter(function($assessment) use ($dateKey){
                            return $assessment->date->format('Y-m-d') === $dateKey;
                        });
                        $dayLectures = $scheduledLectures->filter(function($scheduledLecture) use ($dateKey){
                            return $scheduledLecture->date->format('Y-m-d') === $dateKey;
                        });
                    @endphp

                    <div class="space-y-1">
                        @foreach($dayLectures as $lecture)
                            <div class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">
                                {{$lecture->time_from}} - {{$lecture->time_to}} {{$lecture->time_to}} 
                            </div>
                        @endforeach

                        @foreach($dayTasks as $task)
                            <div class="px-2 py-1 rounded text-xs {{ $task->is_completed ? 'bg-gray-200 text-gray-500 line-through' : 'bg-amber-100 text-amber-800' }}">
                                {{ $task->title }} 
                            </div>
                        @endforeach

                        @foreach($dayAssessments as $assessment)
                            <div class="px-2 py-1 rounded text-xs bg-red-100 text-red-800 ">
                                {{ $assessment->title }} 
                            </div>
                        @endforeach
                    </div>
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

                <select x-model="eventType" name="type" class="w-full border rounded px-3 py-2 mb-4" required>

                    <option value="">Select type</option>
                    <option value="lecture">Lecture</option>
                    <option value="task">Task</option>
                    <option value="assessment">Assessment</option>
                
                </select>

                <label>Title</label>

                <input type="text" name="title" class="w-full border rounded px-3 py-2 mb-4" required>
                
                <div x-show="eventType === 'task' || eventType === 'assessment'">
                    <label>Description</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2 mb-4"></textarea>

                    <label>Link</label>
                    <textarea name="link" class="w-full border rounded px-3 py-2 mb-4"></textarea>
                </div>

                    <div x-show="eventType === 'lecture'">
                        <label>Start time</label>

                        <input type="time" name="start_time" class="w-full border rounded px-3 py-2 mb-4" required>

                        <label>End time</label>

                        <input type="time" name="end_time" class="w-full border rounded px-3 py-2 mb-4">
                    </div>
                <div class="flex gap-2">

                    <button type="submit" class="px-4 py-2 bg-teal-950 text-white rounded">Save</button>

                    <button type="button" @click="open = false" class="border rounded px-4 py-2">Close</button>
                </div>

            </form>        
        </div>
    </div>

</div>


@endsection