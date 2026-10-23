<aside class="w-56 bg-teal-950 text-teal-50 flex flex-col min-h-screen px-7 py-7">
     <a href="{{ route('dashboard') }}" class="block mb-10">
        <span class="font-bright-retro text-6xl">
            Coursa
        </span>
    </a>

    <nav class="flex flex-col gap-4">
        
        <a href="{{route('dashboard')}}" class="hover:bg-teal-900 rounded-xl px-4 py-3">Dashboard</a>
        <a href="{{route('courses.index')}}" class="hover:bg-teal-900 rounded-xl px-4 py-3">Courses</a>
        <a href="{{route('courses.index')}}" class="hover:bg-teal-900 rounded-xl px-4 py-3">Tasks</a>
        <a href="{{route('courses.index')}}" class="hover:bg-teal-900 rounded-xl px-4 py-3">Calendar</a>

    </nav>
    
    <div class="mt-auto">
        <!-- Name display -->
        <p>{{ Auth::user()->name }}</p> 
        
        <!-- Logout button -->
        <form method="POST" action=" {{route('logout')}}">
            @csrf
            <button type="submit" class="text-sm hover:text-white cursor-pointer">Log out</button>
        </form>

    </div>

</aside>

