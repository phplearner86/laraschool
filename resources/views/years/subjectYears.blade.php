<option value="">Select Year</option>
@foreach ($subjectYears as $year)
    <option value="{{ $year }}"
    @if ($lesson)
        {{ $year == $lesson->year ? 'selected' : '' }}
    @endif
    >
        {{ $year }}
    </option>
@endforeach
