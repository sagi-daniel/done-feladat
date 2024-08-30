<h1>New Class</h1>

<form action="{{ route('classes.store') }}" method="POST">
    @csrf
    <fieldset>
        <label for="class_name">Class Name</label>
        <input type="text" name="class_name" id="class_name">
    </fieldset>
    <fieldset>
        <label for="classroom">Classroom</label>
        <input type="number" name="classroom" id="classroom">
    </fieldset>
    <fieldset>
        <label for="teacher">Teacher</label>
        <input type="text" name="teacher" id="teacher">
    </fieldset>
    <fieldset>
        <label for="teacher_email">Teacher Email</label>
        <input type="text" name="teacher_email" id="teacher_email">
    </fieldset>
    <button type="submit">Save</button>
</form>