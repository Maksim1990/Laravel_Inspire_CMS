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
                <div class="card-header">@lang('messages.reset_password')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                        @csrf

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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    @lang('messages.send_password_reset_link')
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
