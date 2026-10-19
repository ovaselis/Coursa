<h1>Edit note</h1>

<form method="POST" action="{{ route('courses.lectures.notes.update', [$course, $lecture, $note]) }}">
    @csrf
    @method('PUT')

    <div>
        <label for="title">Note title</label>
        <input
            type="text"
            name="title"
            id="title"
            value="{{ old('title', $note->title) }}"
        >
    </div>

    <div>
        <label for="content">Content</label>
        <textarea
            name="content"
            id="content"
            rows="20"
        >{{ old('content', $note->content) }}</textarea>
    </div>

    <button type="submit">Save changes</button>
</form>