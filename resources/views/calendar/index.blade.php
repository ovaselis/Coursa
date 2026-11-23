@extends('layouts.app')

@section('content')

{{-- Calendar popup and recurring lecture state --}}
<div class="w-full" 
    x-data="{open: false, selectedDate: '', eventType: '', recurring: false, recurringDays: [],
            eventOpen: false, editing: false, selectedEvent: {}}">
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
                            <div class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800"
                                @click.stop="eventOpen=true; editing= false;
                                    selectedEvent={
                                        id: {{ $lecture->id }},
                                        type: 'lecture',
                                        title: @js($lecture->title),
                                        course: @js($lecture->course->name),
                                        course_id: {{$lecture->course_id}},
                                        date: @js($lecture->date->format('Y-m-d')),
                                        start_time: @js(\Carbon\Carbon::parse($lecture->time_from)->format('H:i')),
                                        end_time: @js(\Carbon\Carbon::parse($lecture->time_to)->format('H:i'))
                                    }">
                                {{ \Carbon\Carbon::parse($lecture->time_from)->format('H:i') }} - {{ \Carbon\Carbon::parse($lecture->time_to)->format('H:i') }} {{$lecture->title}} 
                            </div>
                        @endforeach

                        @foreach($dayTasks as $task)
                            <div class="px-2 py-1 rounded text-xs {{ $task->is_completed ? 'bg-gray-200 text-gray-500 line-through' : 'bg-amber-100 text-amber-800' }}"
                                @click.stop="eventOpen=true; editing= false;
                                    selectedEvent={
                                        id: {{ $task->id }},
                                        type: 'task',
                                        title: @js($task->title),
                                        course: @js($task->course->name),
                                        course_id: {{$task->course_id}},
                                        date: @js($task->deadline->format('Y-m-d')),
                                        description: @js($task->description ?? ''),
                                        link: @js($task->link ?? ''),
                                        completed: {{ $task->is_completed ? 'true' : 'false' }}
                                    }">
                                {{ $task->title }} 
                            </div>
                        @endforeach

                        @foreach($dayAssessments as $assessment)
                            <div class="px-2 py-1 rounded text-xs bg-red-100 text-red-800 "
                                @click.stop="eventOpen=true; editing= false;
                                    selectedEvent={
                                        id: {{ $assessment->id }},
                                        type: 'assessment',
                                        title: @js($assessment->title),
                                        course: @js($assessment->course->name),
                                        course_id: {{$assessment->course_id}},
                                        date: @js($assessment->date->format('Y-m-d')),
                                        description: @js($assessment->description ?? ''),
                                        link: @js($assessment->link ?? ''),
                                        
                                    }">
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
        <div @click.outside="open = false"  class="bg-white max-h-[90vh] rounded-xl p-6 w-full max-w-md overflow-y-auto">
            <h2 class="text-xl font-semibold mb-4">Add calendar event</h2>
            <form method="POST" action=" {{ route('calendar.events.store') }}">
                @csrf

                <label>Date</label>

                <input required type="date" name="date" x-model="selectedDate" class="w-full border rounded px-3 py-2 mb-4">
                
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
                    {{-- Add lecture --}}
                    <div x-show="eventType === 'lecture'">
                        
                        <label>
                            <input type="checkbox"
                                    name="recurring"
                                    value="1"
                                    x-model="recurring">

                            <span>Recurring lecture</span>
                        </label>
                        {{-- One-time lecture time --}}
                        <div x-show="!recurring">
                            <label>Start time</label>

                            <input type="time" name="start_time" class="w-full border rounded px-3 py-2 mb-4"
                                :required="eventType === 'lecture' && !recurring">

                            <label>End time</label>

                            <input type="time" name="end_time" class="w-full border rounded px-3 py-2 mb-4"
                                :required="eventType === 'lecture' && !recurring">
                        </div>
                    </div>
                    {{-- Recurring lecture schedule --}}
                    <div x-show="eventType === 'lecture' && recurring" x-cloak>
                        @php
                            $weekdays = [
                                'monday' => 'Monday',
                                'tuesday' => 'Tuesday',
                                'wednesday' => 'Wednesday',
                                'thursday' => 'Thursday',
                                'friday' => 'Friday',
                                'saturday' => 'Saturday',
                                'sunday' => 'Sunday',
                            ];
                        @endphp

                        <p>Select recurring days</p>

                        <div class="space-y-3 mb-4">
                            @foreach($weekdays as $dayValue => $dayLabel)
                                <div class="flex items-center gap-3">
                                    <input
                                        type="checkbox"
                                        x-model="recurringDays"
                                        value="{{ $dayValue }}"
                                    >

                                    <span class="w-24">{{ $dayLabel }}</span>

                                    <input type="time" name="recurring_days[{{ $dayValue }}][start_time]"
                                        class="border rounded px-3 py-2"
                                        :disabled="!recurringDays.includes('{{ $dayValue }}')"
                                        :required="recurring && recurringDays.includes('{{ $dayValue }}')">
                                    <span>to</span>
                                    <input type="time" name="recurring_days[{{ $dayValue }}][end_time]"
                                        class="border rounded px-3 py-2"
                                        :disabled="!recurringDays.includes('{{ $dayValue }}')"
                                        :required="recurring && recurringDays.includes('{{ $dayValue }}')">
                                
                                </div>
                            @endforeach
                        </div>
                        <label>Repeat until</label>
                        <input type="date" name="repeat_until"
                            class="w-full border rounded px-3 py-2 mb-4"
                            :required="recurring">
                    </div>     
                    
                <div class="flex gap-2">

                    <button type="submit" class="px-4 py-2 bg-teal-950 text-white rounded">Save</button>

                    <button type="button" @click="open = false" class="border rounded px-4 py-2">Close</button>
                </div>

            </form>        
        </div>
    </div>
    {{-- event show and edit popup--}}
    <div x-show="eventOpen" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
        <div @click.outside="eventOpen = false; editing = false"
            class="bg-white rounded-xl p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div x-show="!editing">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-xl font-semibold text-teal-950" 
                        x-text="selectedEvent.title"></h2>

                    <button type="button" @click="eventOpen = false"
                        class="text-gray-500 hover:text-gray-800 cursor-pointer">Close</button>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Type</p>
                        <p class="capitalize" x-text="selectedEvent.type"></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Course</p>
                        <p class="capitalize" x-text="selectedEvent.course"></p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Date</p>
                        <p class="capitalize" x-text="selectedEvent.date"></p>
                    </div>

                    {{-- lecture time --}}
                    <div x-show="selectedEvent.type === 'lecture'">
                        <p class="text-sm text-gray-500">Time</p>
                        <p>
                            <span x-text="selectedEvent.start_time"></span>
                            -
                            <span x-text="selectedEvent.end_time"></span>
                        </p>
                    </div>

                    {{-- assessments and tasks--}}

                    <div x-show="(selectedEvent.type === 'task' ||
                        selectedEvent.type === 'assessment') && selectedEvent.description">

                        <p class="text-sm text-gray-500">Description</p>
                        <p x-text="selectedEvent.description"></p>
                    </div>
                    <div x-show="(selectedEvent.type === 'task' ||
                        selectedEvent.type === 'assessment') && selectedEvent.link">

                        <p class="text-sm text-gray-500">Link</p>
                        <a :href="selectedEvent.link" x-text="selectedEvent.link" target="_blank" class="text-blue-600 hover:underline"
                            >   
                        </a>
                    </div>



                </div>
                <div class="flex items-center gap-3 mt-6">
                    <button type="button" @click="editing = true"
                        class="h-11 px-5 bg-teal-950 text-white rounded-lg hover:bg-teal-900 transition cursor-pointer">
                        Edit
                    </button>
                    <button type="button" title="Delete event"
                        class="h-11 px-5 bg-teal-950 text-white rounded-lg hover:bg-teal-900 transition cursor-pointer">
                        <i data-lucide="trash-2" class="w-4  h-4"></i>
                    </button>

                </div>
            </div>
            {{-- edit view --}}
            <div x-show="editing" x-cloak>

                <h2 class="text-xl font-semibold text-teal-950 mb-5">Edit event</h2>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" x-model="selectedEvent.title"
                        class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                    <select x-model="selectedEvent.course_id"
                        class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2">

                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>

                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" x-model="selectedEvent.date"
                        class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2">
                </div>

                {{-- Lecture comps --}}

                <div x-show="selectedEvent.type === 'lecture'">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start time</label>
                    <input type="time" x-model="selectedEvent.start_time"
                        class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2">

                
                    <label class="block text-sm font-medium text-gray-700 mb-1">End time</label>
                    <input type="time" x-model="selectedEvent.end_time"
                        class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2">

                </div>
                {{-- Task/ assessment comps --}}
                <div x-show="selectedEvent.type === 'task' || selectedEvent.type === 'assessment'">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea x-model="selectedEvent.description" rows="3"
                        class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2">
                    </textarea>

                    <label class="block text-sm font-medium text-gray-700 mb-1">Link</label>
                    <input type="text" x-model="selectedEvent.link"
                        class="w-full mb-3 border border-gray-300 rounded-lg px-3 py-2">



                </div>

                <div class="flex items-center gap-3 mt-4">
                    <button type="button" class="h-11 px-5 bg-teal-950 text-white rounded-lg hover:bg-teal-900 transition cursor-pointer">
                        Save changes
                    </button>

                    <button type="button" @click="editing= false"
                        class="h-11 px-5 bg-teal-950 text-white rounded-lg hover:bg-teal-900 transition cursor-pointer">
                        Cancel
                    </button>
                </div>





            </div>
        </div>


    </div>

</div>


@endsection