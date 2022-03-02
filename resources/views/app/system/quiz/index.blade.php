@extends('template.layout.layout')

<!----------------------------------------------- Define page header -------------------------------------------------->

@section('ph-icon') <i class="fas fa-feather"></i> @endsection
@section('ph-main') {{ __('Kviz') }} @endsection
@section('ph-short') {{__('Pregled svih kvizova')}} | <a href="{{ route('system.quiz.create') }}"> {{ __('Unesite novi kviz') }} </a> @endsection

@section('ph-navigation')
    / <a href="#"> {{ __('Kviz') }} </a>
@endsection

<!--------------------------------------------------------------------------------------------------------------------->


@section('content')
    <div class="content-wrapper content-wrapper">
        <table class="table table-bordered m-0">
            <thead>
            <tr>
                <th scope="col" width="60px" class="text-center">#</th>
                <th scope="col"> {{ __('Datum') }} </th>
                <th scope="col"> {{ __('Broj setova') }} </th>
                <th scope="col" width="120px" class="text-center"> {{ __('Akcije') }} </th>
            </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp
                @foreach($quizzes as $quiz)
                    <tr>
                        <th class="text-center"> {{ $counter++ }} </th>
                        <td> {{ $quiz->dateFormat() }} </td>
                        <td> {{ $quiz->setRel->count() }} </td>
                        <td class="text-center">
                            <a href="{{route('system.quiz.preview', ['id' => $quiz->id])}}" title="{{ __('Pregled setova pitanja') }}">
                                <button class="btn-dark btn-xs"> {{ __('Pregled') }} </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
