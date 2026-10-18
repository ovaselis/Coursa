<h1>Edit course</h1>

<form method="POST" action=" {{ route('courses.update', $course) }} ">
    @csrf
    @method('PUT')
    
    <div>
        <label for="name">Course name</label>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $course->name) }}"
        >
    </div>

    <div>
        <label for="official_url">Course official page</label>
        <input
            type="url"
            name="official_url"
            id="official_url"
            value="{{ old('official_url', $course->official_url) }}"
        >
    </div>

    <div>
        <label for="lecturer">Lecturer</label>
        <input
            type="text"
            name="lecturer"
            id="lecturer"
            value="{{ old('lecturer', $course->lecturer) }}"
        >
    </div>
    
    <div>
        <label for="info">Additional info</label>
        <textarea name="info" id="info">{{ old('info', $course->info) }}</textarea>  

    </div>

    <button type="submit">Save changes</button>

</form>

