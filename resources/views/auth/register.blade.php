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
                <img style="margin-top: -15px;" height="50"
                     src="{{custom_asset('images/includes/logo_white.png')}}" alt="">
            </a>
    </div>
    <div class="row justify-content-center" style="padding-top: 15%;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.register')</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" aria-label="@lang('messages.register')">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">@lang('messages.name')</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">@lang('messages.email')</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">@lang('messages.confirm_password')</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div>
                            <ul>
                                <li class="nav-item">
                                    <a class="nav-link w3-text-white w3-large" href="{{ route('login') }}">@lang('messages.login')</a>
                                </li>
                            </ul>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    @lang('messages.register')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
