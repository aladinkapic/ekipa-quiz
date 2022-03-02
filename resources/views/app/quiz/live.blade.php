@extends('template.layout')

@section('content')
    <div class="lijevo">
        <div class="row">
            <input type="text" name="name" id="name" placeholder="Molimo Vas da unesete ime">
        </div>
        <div class="row">
            <select name="name" id="name">
                <option value="M">Muško</option>
                <option value="M">Žensko</option>
            </select>
        </div>
    </div>
    <div class="desno"><img class="logo" src="{{ asset('images/helem-nejse-znzkvi-1.svg') }}" alt="" ></div>
@endsection
