@extends('template.layout.layout')

<!----------------------------------------------- Define page header -------------------------------------------------->

@section('ph-icon') <i class="fas fa-feather"></i> @endsection
@section('ph-main') {{ __('Kviz') }} @endsection
@section('ph-short')
    @if(isset($preview))
        {{__('Pregled setova pitanja za kviz ')}} {{ isset($quiz) ? $quiz->dateFormat() : '' }}
        | <a href="{{ route('system.quiz.sets.create', ['quiz_id' => $quiz->id ]) }}"> {{ __('Unesite novi set') }} </a>
    @else
        {{__('Molimo da odaberete datum za održavanje kviza')}}
    @endif
@endsection

@section('ph-navigation')
    / <a href="#"> {{ __('Kviz') }} </a>
    @if(isset($preview))
        / <a href="#"> {{ __('Pregled kviza') }} </a>
    @else
        / <a href="#"> {{ __('Unos kviza') }} </a>
    @endif
@endsection

<!--------------------------------------------------------------------------------------------------------------------->


@section('content')
    <div class="content-wrapper p-3">
        @if(isset($edit))
            {!! Form::open(array('route' => 'system.users.update', 'id' => 'js-form', 'method' => 'PUT')) !!}
            {!! Form::hidden('id', $user->id ?? '', ['class' => 'form-control']) !!}
        @else
            {!! Form::open(array('route' => 'system.quiz.save', 'id' => 'js-form', 'method' => 'POST')) !!}
        @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="date"> <b>{{ __('Datum') }}</b> </label>
                        {!! Form::text('date', isset($quiz) ? $quiz->dateFormat() : '', ['class' => 'form-control required datepicker', 'id' => 'date', 'aria-describedby' => 'dateHelp', isset($preview) ? 'readonly' : '']) !!}
                        <small id="dateHelp" class="form-text text-muted"> {{ __('Unesite datum održavanja kviza') }} </small>
                    </div>
                </div>
            </div>

            @if(isset($preview))
                <hr>

                <div class="card">
                    <div class="card-header b-color">
                        <h5 class="m-0 text-white"> <b>{{ __('Setovi pitanja') }}</b> </h5>
                    </div>
                    @foreach($quiz->setRel as $set)
                        <div class="card-body">
                            <h5 class="card-title">
                                @if($set->player_id == null)
                                    {{ __('Nema igrača') }}
                                @else
                                    <a href="{{ route('system.quiz.sets.players.edit', ['id' => $set->playerRel->id ?? 0]) }}">
                                        {{ $set->playerRel->name ?? '' }}
                                    </a>
                                @endif
                            </h5>
                            <p class="card-text"> {{ __('U setu se nalazi ukupno ' . ( $set->questionRel->count() ) . ' pitanja!') }} </p>
                            <a href=" {{ route('system.quiz.sets.preview', ['id' => $set->id ]) }} " class="btn btn-secondary btn-sm">
                                <small>{{ __('Više informacija') }}</small>
                            </a>
                            @if($set->player_id == null)
                                <a href=" {{ route('system.quiz.sets.players.create', ['set_id' => $set->id ]) }} " class="btn btn-success btn-sm">
                                    <small>{{ __('Dodaj igrača') }} <i class="fas fa-user-plus"></i></small>
                                </a>
                            @endif
                        </div>
                        <hr>
                    @endforeach
                </div>
            @endif

            @if(!isset($preview))
                <div class="row mt-3">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-sm btn-secondary"> <b>{{__('Ažurirajte informacije')}}</b> </button>
                    </div>
                </div>
            @endif
        {!! Form::close(); !!}
    </div>
@endsection
