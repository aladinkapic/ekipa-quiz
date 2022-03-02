@extends('template.layout.layout')

<!----------------------------------------------- Define page header -------------------------------------------------->

@section('ph-icon') <i class="fas fa-feather"></i> @endsection
@section('ph-main') {{ __('Set pitanja : ') }} {{ $set->id  }} @endsection
@section('ph-short')
    {{__('Molimo da unesete pitanja vezana za ovaj set')}}
    - <a href="{{ route('system.quiz.sets.new-question', ['set_id' => $set->id ]) }}">{{ __('Novo pitanje') }}</a>
@endsection

@section('ph-navigation')

    / <a href="{{ route('system.quiz.preview', ['id' => $set->quiz_id ]) }}"> {{ __('Pregled kviza') }} </a>
    / <a href="#"> {{ __('Set pitanja') }} </a>
@endsection

<!--------------------------------------------------------------------------------------------------------------------->

@section('content')
    <div class="content-wrapper p-3">
        <div class="card">
            @foreach($set->questionRel as $question)
                <div class="card-body">
                    <h5 class="card-title"> {{ $question->question }} </h5>
                    <p class="card-text">
                    <ul>
                        @foreach($question->answerRel as $answer)
                            @if($answer->correct == 0)
                                <li> <b> {{ $answer->answer }} </b> </li>
                            @else
                                <li class="text-primary"> <b> {{ $answer->answer }} </b> </li>
                            @endif
                        @endforeach
                    </ul>
                    </p>
                    <a href="{{ route('system.quiz.sets.delete-question', ['id' => $question->id ]) }}" class="btn btn-danger btn-sm">
                        <small>
                            {{ __('Obrišite') }}
                            <i class="fas fa-trash"></i>
                        </small>
                    </a>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
@endsection
