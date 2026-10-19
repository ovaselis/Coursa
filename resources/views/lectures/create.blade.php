<h1>Add lecture to {{ $course->name }}</h1>

<form method="POST" action="{{ route('courses.lectures.store', $course) }}">
    @csrf

    <div>
        <label for="title">Lecture title</label>
        <input 
            type="text"
            name="title"
            id="title"
            value="{{ old('title') }}"
        >
    </div>

    <div>
        <label for="date">Date</label>
        <input 
            type="date"
            name="date"
            id="date"
            value="{{ old('date') }}"
        >
    </div>

    <div>
        <label for="info">Additional info</label>
        <textarea name="info" id="info">{{ old('info') }}</textarea>
    </div>

    <button type="submit">Save lecture</button>

</form>
