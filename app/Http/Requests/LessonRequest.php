<?php

namespace App\Http\Requests;

use App\Rules\AlphaNumSpaces;
use App\Rules\AlphaNumSpacesPunctuation;
use App\Services\Utilities\Year;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //dd($this->method());

        $subject_ids = $this->user->teacher->subjects->unique()->pluck('id')->toArray();
        $subject_ids = implode(',', $subject_ids);

        $years = $this->user->teacher->subjects()->where('subject_id', $this->subject_id)->pluck('year')->unique()->toArray();
        $years = implode(',', $years);

        $titles = $this->user->teacher->lessons->pluck('title');

        switch ($this->method()) {
            case 'POST':
                return [
                    'subject_id' => [
                        'required',
                        'in:' . $subject_ids,
                    ],
                    'title' => [
                        'required',
                        'max:80',
                        Rule::unique('lessons')->where(function($query){
                            $query->where('teacher_id', $this->user->teacher->id);
                        }),
                        new AlphaNumSpaces,
                    ],
                    'topic' => [
                        'required',
                        'max:150',
                        new AlphaNumSpacesPunctuation,
                    ],
                    'year' => 'required|in:' . $years,
                    'goals' => [
                        'required',
                        'max:300'
                    ]
                ];
                break;

            case 'PUT':
            case 'PATCH':
                return [
                    'subject_id' => [
                        'required',
                        'in:' . $subject_ids,
                    ],
                    'title' => [
                        'required',
                        'max:80',
                        Rule::unique('lessons')->where(function($query){
                            $query->where('teacher_id', $this->user->teacher->id);
                        })->ignore($this->user->teacher->id, 'teacher_id'),
                        new AlphaNumSpaces,
                    ],
                    'topic' => [
                        'required',
                        'max:150',
                        new AlphaNumSpacesPunctuation,
                    ],
                    'year' => 'required|in:' . $years,
                    'goals' => [
                        'required',
                        'max:300'
                    ]
                ];
                break;
            
            
        }

        
    }
}
