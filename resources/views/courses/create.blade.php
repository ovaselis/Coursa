<h1>Add a course</h1>

<form method="POST" action="{{ route('courses.store') }}">
    @csrf

    <div>
        <label for="name">Course name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
    </div>

    <div>
        <label for="name">Course official page</label>
        <input type="url" name="official_url" id="official_url" value="{{ old('official_url') }}">
    </div>
    
    <div>
        <label for="name">Lecturer</label>
        <input type="text" name="lecturer" id="lecturer" value="{{ old('lecturer') }}">
    </div>

    <div>
        <label for="info">Additional info</label>
        <textarea name="info" id="info">{{ old('info') }}</textarea>
    </div>

    <button type="submit">Saglabāt</button>


</form>
