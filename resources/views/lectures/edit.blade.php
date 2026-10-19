<h1>Edit lecture</h1>

<form method="POST" action="{{ route('courses.lectures.update', [$course, $lecture]) }}">
    @csrf
    @method('PUT')

    <div>
        <label for="title">Lecture title</label>
        <input
            type="text"
            name="title"
            id="title"
            value="{{ old('title', $lecture->title) }}"
        >
    </div>

    <div>
        <label for="date">Date</label>
        <input
            type="date"
            name="date"
            id="date"
            value="{{ old('date', $lecture->date) }}"
        >
    </div>

    <div>
        <label for="info">Additional info</label>
        <textarea name="info" id="info">{{ old('info', $lecture->info) }}</textarea>
    </div>

    <button type="submit">Save changes</button>
</form>



