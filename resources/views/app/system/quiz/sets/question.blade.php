@extends('template.layout.layout')

<!----------------------------------------------- Define page header -------------------------------------------------->

@section('ph-icon') <i class="fas fa-question"></i> @endsection
@section('ph-main') {{ __('Pitanja') }} @endsection
@section('ph-short') {{__('Molimo da unesete pitanja vezana za ovaj set')}} @endsection

@section('ph-navigation')
    / <a href="#"> {{ __('Kviz') }} </a>
    / <a href="{{ route('system.quiz.preview', ['id' => $set->quiz_id ]) }}"> {{ __('Pregled kviza') }} </a>
    / <a href="{{ route('system.quiz.sets.preview', ['id' => $set->id ]) }}"> {{ __('Set pitanja') }} </a>
@endsection

<!--------------------------------------------------------------------------------------------------------------------->


@section('content')
    <div class="content-wrapper p-3">
        <div class="row">
            <div class="col-md-12">

                {!! Form::open(array('route' => 'system.quiz.sets.save-question', 'id' => 'js-form', 'method' => 'POST')) !!}

                    {!! Form::hidden('set_id', $set->id, ['class' => 'form-control', 'id' => 'set_id']) !!}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="question"> <b>{{ __('Pitanje') }}</b> </label>
                                {!! Form::text('question', $question->question ?? '', ['class' => 'form-control required', 'id' => 'question', 'aria-describedby' => 'questionHelp']) !!}
                                <small id="questionHelp" class="form-text text-muted"> {{ __('Unesite željeno pitanje') }} </small>
                            </div>
                        </div>
                    </div>

                    <div class="questions-wrapper mt-2">
                        <div class="row pt-3 pb-0">
                            <div class="col-md-10">
                                <h6><b>{{ __('Unesite odgovore za pitanja') }}</b></h6>
                            </div>
                            @if(!isset($preview))
                                <div class="col-md-2 d-flex justify-content-end">
                                    <div class="btn btn-xs btn-xs-v2 bg-success text-white add-question"> <i class="fas fa-plus"></i> {{ __('Novi odgovor') }} </div>
                                </div>
                                <hr class="mt-2">
                            @endif
                        </div>
                        <div class="questions p-3 pt-0 mt-0">
                            <div class="row" id="question-zero">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        {!! Form::text('answer[]', '', ['class' => 'form-control', 'id' => 'answer', 'aria-describedby' => 'areaHelp', isset($preview) ? 'readonly' : '']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::select('correct[]', ['0' => 'Netačno', '1' => 'Tačan odgovor'], '', ['class' => 'form-control', 'id' => 'correct', 'aria-describedby' => 'areaHelp', isset($preview) ? 'disabled => true' : '']) !!}
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    {!! Form::text('delete[]', 'X', ['class' => 'form-control text-center text-danger', 'title' => 'Obrišite', 'readonly']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-secondary"> <b>{{__('Ažurirajte informacije')}}</b> </button>
                        </div>
                    </div>

                {!! Form::close(); !!}
            </div>
        </div>
    </div>
@endsection



