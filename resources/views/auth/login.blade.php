@extends('layouts.app')

@section('content')
<div class="container">
    <div class="top-left" style="display:inline;left: 5%;position: fixed;">
        @if(!empty($appFooter->getAppLanguages()))
            @foreach($appFooter->getAppLanguages() as $strLand=>$strFullLang)
                @if(strtolower($strLand)=='th')
                    @php $strImage='th'; @endphp
                @elseif(strtolower($strLand)=='fr')
                    @php $strImage='fr'; @endphp
                @elseif(strtolower($strLand)=='ru')
                    @php $strImage='ru'; @endphp
                @else
                    @php $strImage='en'; @endphp
                @endif
                <a rel="alternate" style="text-decoration: none;"
                   href="{{ LaravelLocalization::getLocalizedURL(strtolower($strLand), null, [], true) }}">
                    <img style="border-radius: 30px;" width="25" height="25"
                         src="{{custom_asset('images/includes/flags/'.$strImage.'.png')}}"
                         alt="">
                </a>
            @endforeach
        @endif
            <a class="navbar-brand" href="{{URL::to('/'.LaravelLocalization::getCurrentLocale())}}">
                <img style="margin-top: -35px;" height="100"
                     src="{{custom_asset('images/includes/inspire_2.png')}}" alt="">
            </a>
    </div>
    <div class="row justify-content-center" style="padding-top: 15%;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.login')</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf
                        @if ($errors->has('attempt_limit_alert'))
                            <div class="alert alert-danger" id="alert_limit">
                                <p class="text-center">{!!  $errors->first('attempt_limit_alert') !!}</p>
                            </div>
                        @endif
                        <br>
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">@lang('messages.email')</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                <br>
                                @if ($errors->has('email') || $errors->has('attempts_left'))
                                    <div class="alert alert-danger" id="alert">
                                        <ul>
                                            <li>{{  $errors->first('email') }}</li>
                                            <li>{!!  $errors->first('attempts_left') !!}</li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">@lang('messages.password')</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('messages.remember_me')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <ul>
                                <li class="nav-item">
                                    <a class="nav-link w3-text-white w3-large" href="{{ route('register') }}">@lang('messages.register')</a>
                                </li>
                            </ul>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" id="button" class="btn btn-success">
                               @lang('messages.login')
                                </button>

                                <a class="btn btn-link w3-text-white" href="{{ route('password.request') }}">
                                  @lang('messages.forgot_password')
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

            @if (!$errors->first('attempts'))
    var intTimeLeft = '{{$errors->first('seconds')}}';

    var loginTime = setInterval(function () {
        $("#seconds").text(--intTimeLeft);
        $("#button").prop("disabled", true);
        if (intTimeLeft <= 0) {
            clearInterval(loginTime);
            $("#alert_limit").remove();
            $("#button").prop("disabled", false);
        }
    }, 1000);
    @endif
</script>
@endsection
