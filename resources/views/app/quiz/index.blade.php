@extends('template.layout')

@section('content')
    <div class="lijevo">
        <ul>
            @foreach($quizzes as $quiz)
                <li>
                    <a href="{{ route('quiz.live', ['id' => $quiz->id  ]) }}"> {{ $quiz->dateFormat() }} </a>
                </li>
            @endforeach

            <br>

            <li>
                <a href="{{ route('system.quiz.index') }}"> {{ __('Admin panel') }} </a>
            </li>
        </ul>
    </div>
    <div class="desno"><img class="logo" src="{{ asset('images/helem-nejse-znzkvi-1.svg') }}" alt="" ></div>
@endsection
