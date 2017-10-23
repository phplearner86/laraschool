{{-- Title --}}
<div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" name="title" id="title" placeholder="Enter event title">
</div>

{{-- Subject --}}
<div class="form-group">
    <label for="subject_id">Subject</label>
    <select name="subject_id" id="subject_id" class="form-control">
        <option selected disabled="">Select Subject</option>
        @foreach ($user->teacher->subjects->unique() as $subject)
            <option value="{{ $subject->id }}"> 
                {{ ucfirst($subject->name) }}
            </option>
        @endforeach
    </select>
</div>

{{-- Date --}}
<div class="form-group">
    <label for="eventDate">Date</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="text" class="form-control" name="eventDate" id="eventDate"  placeholder="yyyy-mm-dd">
    </div>
</div>

{{-- Start & End --}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="start">Start</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                <input type="text" class="form-control" name="start" id="start"  placeholder="hh:mm">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="end">End</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                <input type="text" class="form-control" name="end" id="end"  placeholder="hh:mm">
            </div>
        </div>
    </div>
</div>

