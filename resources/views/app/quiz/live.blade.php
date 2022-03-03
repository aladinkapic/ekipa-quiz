@extends('template.layout')

@section('content')
    <div class="desno">
        <!-- init variables -->
        {!! Form::hidden('quiz_id', $quiz->id, ['class' => 'form-control', 'id' => 'quiz_id']) !!}

        @if(!isset($player) or !isset($set))
            <img class="logo" src="{{ asset('images/joker.png') }}">
        @else
            <img class="logo" src="{{ asset('images/helem-nejse-znzkvi-1.svg') }}" alt="" style="display: none;">

            <div class="all-questions">

                <!-- Set ID -->
                <input type="hidden" value="{{ $set->id }}" id="set_id">

                <div class="header">
                    <ul class="avatari">
                        <li class="h-current-player">
                            <img class="badge" src="{{ asset('images/avatari/' . ($player->avatarRel->image ?? '')) }}" alt="" >
                            <div class="bodovi total-points">0</div>
                        </li>
                        @foreach($finished as $data)
                            <li class="h-current-player">
                                <img class="badge" src="{{ asset('images/avatari/' . ($data->playerRel->avatarRel->image ?? '')) }}" alt="" title="{{ $data->playerRel->name ?? '' }}">
                                <div class="bodovi"> {{ $data->getTotalPoints() }} </div>
                            </li>
                        @endforeach
                    </ul>
                    <ul class="joker">
                        <li>
                            <span class="pulse"></span>
                            <img class="badge" src="{{ asset('images/joker.png') }}" alt="" >
                            <div>Joker</div>
                        </li>
                    </ul>
                </div>
                <div class="pitanje question" attr-id="{{ $question->id ?? '' }}">
                    <p> {{ $question->question ?? 'Problem sa učitavanjem pitanja .. ' }} </p>
                </div>
                <div class="progress-wrapper">

                    <input type="radio" class="radio" name="progress" value="jedan" id="jedan">
                    <label for="jedan" class="label">1</label>

                    <input type="radio" class="radio" name="progress" value="dva" id="dva" >
                    <label for="dva" class="label">2</label>

                    <input type="radio" class="radio" name="progress" value="tri" id="tri" >
                    <label for="tri" class="label">3</label>

                    <input type="radio" class="radio" name="progress" value="cetiri" id="cetiri" >
                    <label for="cetiri" class="label">4</label>

                    <input type="radio" class="radio" name="progress" value="pet" id="pet" checked>
                    <label for="pet" class="label">5</label>

                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                </div>
                <ul class="odgovori">
                    @php $counter = 0 @endphp
                    @foreach($question->answerRel as $answer)
                        <li>
                            <div class="slovo"> {{ $letters[$counter] }} </div>
                            <div class="odgovor answer-{{ $letters[$counter++] }}" attr-id="{{ $answer->id }}">
                                {{ $answer->answer ?? '' }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="haj-skor">
            <img class="hs-logo" src="{{ asset('images/haj-skor.svg') }}" alt="" >
            <ul class="avatari high-score-avatars"> </ul>
        </div>
    </div>
    <div class="lijevo">
        <div class="row">
            <select name="name" id="name">
                <option value="{{ $player->id ?? '' }}"> {{ $player->name ?? '' }} </option>
            </select>
        </div>
        <div class="row">
            <input type="submit" class="submit-it start-quiz" value="{{ __('ZAPOČNITE KVIZ') }}">
        </div>

        <div class="controls">
            <div class="row start-counting-w">
                <input type="submit" class="submit-it start-counting" value="{{ __('ZAPOČNITE ODBROJAVANJE') }}">
            </div>
            <div class="row row-flex letter-commands">
                <input type="submit" class="pick-value" val-attr="A" value="{{ __('A') }}">
                <input type="submit" class="pick-value" val-attr="B" value="{{ __('B') }}">
                <input type="submit" class="pick-value" val-attr="C" value="{{ __('C') }}">
                <input type="submit" class="pick-value" val-attr="D" value="{{ __('D') }}">
            </div>

            <div class="row row-flex row-flex-half joker-next">
                <input type="submit" class="use-joker" val-attr="A" value="{{ __('JOKER') }}">
                <input type="submit" class="next-question" value="{{ __('SLJEDEĆE PITANJE') }}">
            </div>

            <div class="row well-done-w">
                <input type="submit" class="submit-it well-done" value="{{ __('BRAO BRAO') }}">
            </div>
            <div class="row go-home-w">
                <input type="submit" class="submit-it go-home" value="{{ __('KLEPI GA PO UŠIMA') }}">
            </div>
        </div>

        <div class="row row-flex row-flex-half">
            <input type="submit" class="high-score" value="{{ __('HIGH SCORE') }}">
            <input type="submit" class="start-over" value="{{ __('NOVI KVIZ') }}">
        </div>
    </div>
@endsection
