<div class="s-top-menu">
    <div class="app-name">
        <a href="#" target="_blank" title="{{__('Naslovna strana')}}">
            <h1> Dobrodošli </h1>
        </a>
        <i class="fas fa-bars t-3 system-m-i-t" title="{{__('Otvorite / zatvorite MENU')}}"></i>
    </div>

    <div class="top-menu-links">
        <!-- Left top icons -->
        <div class="left-icons">
{{--            <div class="single-li">--}}
{{--                <a href="#" target="_blank" title="">--}}
{{--                    <i class="fas fa-shopping-cart"></i>--}}
{{--                    <div class="number-of"><p> 2 </p></div>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--            <div class="single-li" title="Odaberite jezik">--}}
{{--                <i class="fas fa-globe-americas"></i>--}}
{{--                <div class="number-of"><p>3</p></div>--}}
{{--            </div>--}}

            <a href="#" target="_blank">
                <div class="single-li">
                    <p> {{__('Additional link')}} </p>
                </div>
            </a>

            <a href="#">
                <div class="single-li">
                    <p> {{__('More links')}} </p>
                </div>
            </a>
        </div>

        <!-- Right top icons -->
        <div class="right-icons">
{{--            <div class="single-li main-search-w" title="">--}}
{{--                <i class="fas fa-search main-search-t" title="{{__('Pretražite')}}"></i>--}}
{{--                @include('system.template.menu.menu-includes.search')--}}
{{--            </div>--}}
            <div class="single-li m-show-notifications" title="Pregled obavijesti">
                <a href="{{ route('system.quiz.restart-sets') }}" title="{{ __('Restartujte sve setove') }}">
                    <i class="fas fa-power-off"></i>
                </a>
            </div>
            <a href="#">
                <div class="single-li user-name">
                    <p><b> Root Admin </b></p>
                </div>
            </a>
        </div>
    </div>
</div>
