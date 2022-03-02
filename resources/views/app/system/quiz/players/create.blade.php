@extends('template.layout.layout')

<!----------------------------------------------- Define page header -------------------------------------------------->

@section('ph-icon') <i class="fas fa-user"></i> @endsection
@section('ph-main') @if(isset($create)) {{ __('Dodajte novog igrača') }} @else {{ $player->name }}  @endif @endsection
@section('ph-short')
    {{__('Molimo da unesete i/ili uredite informacije o igraču')}}
@endsection

@section('ph-navigation')
    / <a href="#"> {{ __('Kviz') }} </a>
    / <a href="{{ route('system.quiz.preview', ['id' => $set->quiz_id ]) }}"> {{ __('Pregled kviza') }} </a>
    / <a href="#"> {{ __('Novi igrač') }} </a>
@endsection

<!--------------------------------------------------------------------------------------------------------------------->


@section('content')
    <div class="content-wrapper p-3">
        @if(isset($edit))
            {!! Form::open(array('route' => 'system.quiz.sets.players.update', 'id' => 'js-form', 'method' => 'PUT')) !!}
            {!! Form::hidden('id', $player->id ?? '', ['class' => 'form-control']) !!}
        @else
            {!! Form::open(array('route' => 'system.quiz.sets.players.save', 'id' => 'js-form', 'method' => 'POST')) !!}
        @endif
            {!! Form::hidden('set_id', $set->id, ['class' => 'form-control', 'id' => 'set_id']) !!}

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name"> <b>{{ __('Ime i prezime') }}</b> </label>
                        {!! Form::text('name', $player->name ?? '', ['class' => 'form-control required', 'id' => 'name', 'aria-describedby' => 'nameHelp', isset($preview) ? 'readonly' : '']) !!}
                        <small id="nameHelp" class="form-text text-muted"> {{ __('Puno ime i prezime igrača') }} </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone"> <b>{{ __('Broj telefona') }}</b> </label>
                        {!! Form::text('phone', $player->phone ?? '', ['class' => 'form-control required', 'id' => 'phone', 'aria-describedby' => 'phoneHelp', isset($preview) ? 'readonly' : '']) !!}
                        <small id="phoneHelp" class="form-text text-muted"> {{ __('Broj telefona +387 6X XXX XXX') }} </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="gender"> <b>{{ __('Spol') }}</b> </label>
                        {!! Form::select('gender', ['M' => 'Muško', 'F' => 'Žensko'], $player->avatarRel->gender ?? '', ['class' => 'form-control required', 'id' => 'gender', 'aria-describedby' => 'genderHelp', isset($preview) ? 'disabled => true' : '']) !!}
                        <small id="genderHelp" class="form-text text-muted"> {{ __('Odaberite pol igrača') }} </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email"> <b>{{ __('Email') }}</b> </label>
                        {!! Form::text('email', $player->email ?? '', ['class' => 'form-control', 'id' => 'email', 'aria-describedby' => 'emailHelp', isset($preview) ? 'readonly' : '']) !!}
                        <small id="emailHelp" class="form-text text-muted"> {{ __('Email') }} </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address"> <b>{{ __('Adresa stanovanja') }}</b> </label>
                        {!! Form::text('address', $player->address ?? '', ['class' => 'form-control', 'id' => 'address', 'aria-describedby' => 'addressHelp', isset($preview) ? 'readonly' : '']) !!}
                        <small id="addressHelp" class="form-text text-muted"> {{ __('Unesite ulicu i broj stanovanja') }} </small>
                    </div>
                </div>
            </div>


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
