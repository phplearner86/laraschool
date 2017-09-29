<div class="row">

    <div class="col-md-8">
        <div class="form-group">
            <label for="subject_id">Subject</label>
            <select name="subject_id" id="subject_id" class="form-control">
                <option selected disabled="">Select Subject</option>
                @foreach ($user->teacher->subjects->unique() as $subject)
                    <option value="{{ $subject->id }}"
                        {{ selected($subject->id, $subject_id) }}
                    > 
                        {{ ucfirst($subject->name) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="year">Academic Year</label>
            <select name="year" id="year" class="form-control">
                <option selected disabled="">Select Year</option>
                @foreach (Year::all() as $label=>$name)
                    <option value="{{ $label }}"
                    {{ selected($label, $year) }}
                    > 
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" name="title" placeholder="Enter lesson title" value="{{ $title }}">
</div>

<div class="form-group">
    <label for="topic">Topic</label>
    <input type="text" class="form-control" name="topic" placeholder="Enter topic" value="{{ $topic }}">
</div>

<div class="form-group">
    <label for="goals">Goals</label>
    <textarea name="goals" id="goals" class="form-control" cols="10" rows="5">{{ $goals }}</textarea>
</div>

<div class="form-group">
    <button class="btn btn-success">{{ $button }}</button>
</div>