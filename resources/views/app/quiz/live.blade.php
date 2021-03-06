@extends('template.layout')

@section('content')
    <div class="desno">
        <!-- init variables -->
        {!! Form::hidden('quiz_id', $quiz->id, ['class' => 'form-control', 'id' => 'quiz_id']) !!}

        @if(!isset($player) or !isset($set))
            <img class="logo" src="{{ asset('images/helem-nejse-znzkvi-1.svg') }}" alt="">
        @else
            <img class="logo" src="{{ asset('images/helem-nejse-znzkvi-1.svg') }}" alt="">

            <div class="all-questions">

                <!-- Set ID -->
                <input type="hidden" value="{{ $set->id }}" id="set_id">

                <div class="header">
                    <ul class="avatari">
                        <li class="h-current-player">
                            <img class="badge" src="{{ asset('images/avatari/' . ($player->avatarRel->image ?? '')) }}" alt="" >
                            <div class="bodovi total-points">{{ $set->getTotalPoints() }}</div>
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
                            <span class="pulse" @if(isset($set) and $set->usedJoker() === 1) style="display: block;" @endif></span>
                            <img class="badge" src="{{ asset('images/joker.png') }}" alt="" >
                            <div>Joker</div>
                        </li>
                    </ul>
                </div>
                <div class="pitanje question" attr-id="{{ $question->id ?? '' }}">
                    <p> {{ $set->numberOfQuestion() }}. {{ $question->question ?? 'Problem sa u??itavanjem pitanja .. ' }} </p>
                </div>
                <div class="progress-wrapper">

                    <input type="radio" class="radio radio-0" name="progress" value="nula" id="nula" checked>
                    <label for="nula" class="label">0</label>

                    <input type="radio" class="radio radio-1" name="progress" value="jedan" id="jedan">
                    <label for="jedan" class="label">1</label>

                    <input type="radio" class="radio radio-2" name="progress" value="dva" id="dva" >
                    <label for="dva" class="label">2</label>

                    <input type="radio" class="radio radio-3" name="progress" value="tri" id="tri">
                    <label for="tri" class="label">3</label>

                    <input type="radio" class="radio radio-4" name="progress" value="cetiri" id="cetiri" >
                    <label for="cetiri" class="label">4</label>

                    <input type="radio" class="radio radio-5" name="progress" value="pet" id="pet">
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
            <input type="submit" class="submit-it start-quiz" value="{{ __('Zapo??nite kviz') }}">
        </div>

        <div class="controls">
            <div class="row start-counting-w">
                <input type="submit" class="submit-it start-counting" value="{{ __('ZAPO??NITE ODBROJAVANJE') }}">
            </div>
            <div class="row row-flex letter-commands">
                <input type="submit" class="pick-value" val-attr="A" value="{{ __('A') }}">
                <input type="submit" class="pick-value" val-attr="B" value="{{ __('B') }}">
                <input type="submit" class="pick-value" val-attr="C" value="{{ __('C') }}">
                <input type="submit" class="pick-value" val-attr="D" value="{{ __('D') }}">
            </div>

            <div class="row row-flex row-flex-half joker-next">
                @if(isset($set) and $set->usedJoker())
                    <input type="submit" class="next-question next-question-full" value="{{ __('Sljede??e pitanje') }}">
                @else
                    <input type="submit" class="use-joker" val-attr="A" value="{{ __('Joker') }}">
                    <input type="submit" class="next-question" value="{{ __('Sljede??e pitanje') }}">
                @endif
            </div>
            <div class="row reset-counter-w">
                <input type="submit" class="reset-counter" val-attr="A" value="{{ __('Ponovi odbrojavanje') }}">
            </div>

            <div class="row well-done-w">
                <input type="submit" class="submit-it well-done" value="{{ __('BRAO BRAO') }}">
            </div>
            <div class="row go-home-w">
                <input type="submit" class="submit-it go-home" value="{{ __('KLEPI GA PO U??IMA') }}">
            </div>
        </div>

        <div class="row row-flex row-flex-half">
            <input type="submit" class="high-score" value="{{ __('HIGH SCORE') }}">
            <input type="submit" class="start-over" value="{{ __('NOVI KVIZ') }}">
        </div>
        <div class="row">
            <input type="submit" class="reset-question" value="{{ __('Ponovi pitanje') }}">
        </div>
    </div>
@endsection
