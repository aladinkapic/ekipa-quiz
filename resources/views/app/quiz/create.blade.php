@extends('system.layout.layout')

<!----------------------------------------------- Define page header -------------------------------------------------->

@section('ph-icon') <i class="fas fa-user"></i> @endsection
@section('ph-main') @if(isset($user)) {{ $user->name ?? '' }} @else {{ __('Unesite korisnika') }} @endif @endsection
@section('ph-short')
    {{__('Pregledajte / uredite osnovne informacije o korisnicima u sistemu !')}}

    @if(isset($preview))
        | <a href="{{route('system.users.edit', ['id' => $user->id])}}"> {{ __('Uredite') }} </a>
    @endif
@endsection

@section('ph-navigation')
    / <a href="{{route('system.users.index')}}"> {{ __('Korisnici') }} </a>
    @if(isset($profile))
        / <a href="{{ route('system.users.profile') }}"> {{ __('Moj profil') }}</a>
    @elseif(isset($user))
        / <a href="{{ route('system.users.preview', ['id' => $user->id]) }}"> {{ $user->name ?? '' }} </a>
    @else
        / <a href="#">{{ __('Unesite korisnika') }}</a>
    @endif
@endsection

<!--------------------------------------------------------------------------------------------------------------------->


@section('content')
    <div class="content-wrapper p-3">
        <div class="row">
            <div class="col-md-12">
                @if(isset($edit))
                    {!! Form::open(array('route' => 'system.users.update', 'id' => 'js-form', 'method' => 'PUT')) !!}
                    {!! Form::hidden('id', $user->id ?? '', ['class' => 'form-control']) !!}
                @elseif(isset($profile))
                    {!! Form::open(array('route' => 'system.users.update-profile', 'id' => 'js-form', 'method' => 'PUT')) !!}
                    {!! Form::hidden('id', $user->id ?? '', ['class' => 'form-control']) !!}
                @else
                    {!! Form::open(array('route' => 'system.users.save', 'id' => 'js-form', 'method' => 'POST')) !!}
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name"> <b>{{ __('Ime i prezime') }}</b> </label>
                            {!! Form::text('name', $user->name ?? '', ['class' => 'form-control required', 'id' => 'name', 'aria-describedby' => 'nameHelp', isset($preview) ? 'readonly' : '']) !!}
                            <small id="nameHelp" class="form-text text-muted"> {{ __('Puno ime i prezime korisnika') }} </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email"> <b>{{ __('Email') }}</b> </label>
                            {!! Form::email('email', $user->email ?? '', ['class' => 'form-control required', 'id' => 'email', 'aria-describedby' => 'emailHelp', isset($preview) ? 'readonly' : '']) !!}
                            <small id="emailHelp" class="form-text text-muted"> {{ __('Adresa e-Pošte') }} </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if(isset($create))
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password"> <b>{{ __('Lozinka / šifra') }}</b> </label>
                                {!! Form::password('password', ['class' => 'form-control required', 'id' => 'password', 'aria-describedby' => 'passwordHelp']) !!}
                                <small id="passwordHelp" class="form-text text-muted"> {{ __('Lozinka / šifra za pristup računu') }} </small>
                            </div>
                        </div>
                    @endif
                    <div class="{{isset($create) ? 'col-md-6' : 'col-md-12'}}">
                        <div class="form-group">
                            <label for="birth_date"> <b>{{ __('Datum rođenja') }}</b> </label>
                            {!! Form::text('birth_date', isset($user) ? $user->birtDate() : '', ['class' => 'form-control required'.(isset($preview) ? '' : ' datepicker'), 'id' => 'birth_date', 'aria-describedby' => 'birth_dateHelp', isset($preview) ? 'readonly' : '']) !!}
                            <small id="birth_dateHelp" class="form-text text-muted"> {{ __('Datum rođenja (dd.mm.yyyy)') }} </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for=phone"> <b>{{ __('Telefon') }}</b> </label>
                            {!! Form::text('phone', $user->phone ?? '', ['class' => 'form-control phone', 'id' => 'phone', 'aria-describedby' => 'phoneHelp', isset($preview) ? 'readonly' : '', 'maxlength' => '15']) !!}
                            <small id="phoneHelp" class="form-text text-muted"> {{ __('Broj telefona korisnika - mobilni ili kućni') }} </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job"> <b>{{ __('Radno mjesto') }}</b> </label>
                            {!! Form::text('job', $user->job ?? '', ['class' => 'form-control', 'id' => 'job', 'aria-describedby' => 'jobHelp', isset($preview) ? 'readonly' : '', 'maxlength' => '100']) !!}
                            <small id="jobHelp" class="form-text text-muted"> {{ __('Radno mjesto na koje je korisnik postavljen') }} </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for=address"> <b>{{ __('Adresa') }}</b> </label>
                            {!! Form::text('address', $user->address ?? '', ['class' => 'form-control', 'id' => 'address', 'aria-describedby' => 'addressHelp', isset($preview) ? 'readonly' : '', 'maxlength' => '100']) !!}
                            <small id="addressHelp" class="form-text text-muted"> {{ __('Adresa stanovanja korisnika') }} </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city"> <b>{{ __('Grad') }}</b> </label>
                            {!! Form::select('city', $municipalities, $user->city ?? '', ['class' => isset($preview) ? 'form-control' : 'form-control select-2', 'id' => 'city', 'aria-describedby' => 'cityHelp', isset($preview) ? 'disabled => true' : '', 'maxlength' => '100']) !!}
                            <small id="cityHelp" class="form-text text-muted"> {{ __('Grad stanovanja korisnika') }} </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=country"> <b>{{ __('Država') }}</b> </label>
                            {!! Form::select('country', $countries, $user->country ?? '30', ['class' => isset($preview) ? 'form-control' : 'form-control select-2', 'id' => 'country', 'aria-describedby' => 'countryHelp', isset($preview) ? 'disabled => true' : '']) !!}
                            <small id="countryHelp" class="form-text text-muted"> {{ __('Država stanovanja korisnika') }} </small>
                        </div>
                    </div>
                </div>

                @if($loggedUser->role == 0 and !isset($profile))
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role"> <b>{{ __('Nivo pristupa') }}</b> </label>
                                {!! Form::select('role', ['0' => 'Administrator', '1' => 'Korisnik'], $user->role ?? '1', ['class' => 'form-control', 'id' => 'role', 'aria-describedby' => 'roleHelp', isset($preview) ? 'disabled => true' : '']) !!}
                                <small id="roleHelp" class="form-text text-muted"> {{ __('Odaberite nivo pristupa za korisnika') }} </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="active"> <b>{{ __('Pristup sistemu') }}</b> </label>
                                {!! Form::select('active', ['0' => 'Ne', '1' => 'Da'], $user->active ?? '1', ['class' => 'form-control', 'id' => 'role', 'aria-describedby' => 'activeHelp', isset($preview) ? 'disabled => true' : '']) !!}
                                <small id="activeHelp" class="form-text text-muted"> {{ __('Da li korisnik ima pravo pristupa sistemu?') }} </small>
                            </div>
                        </div>
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
        </div>
    </div>
@endsection
