<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{env('APP_NAME')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Knewave" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Styles -->
        <style>
            html, body {

                background: url('{{custom_asset('images/app/inspire.jpg')}}') no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }

            .full-height {
                height: 50vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;

            }
            .title_block{

                position: fixed;
                background:rgba(0,0,0,0.4);
                border-radius: 20px;
                padding: 60px 60px;
                color: white;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                margin: 0;
            }
            .title_block span{

            }
            .info_block{
                font-family: 'Raleway', sans-serif;
                top: 70%;
                right: 10%;
                text-align: center;
                position: fixed;
                font-size: 45px;
                color:whitesmoke;
            }
            .info_block a{
                color:white;
                font-weight: bold;
                font-family: 'Knewave', cursive;
            }


            .title {
                font-size: 84px;
            }

            .links > a {
                color: #686868;
                padding: 0 25px;
                font-size: 20px;
                font-weight: 300;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            @if (Route::has('login'))
                <div class="top-right links">
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
                    @auth
                        <a href="{{URL::to('/'.LaravelLocalization::getCurrentLocale().'/admin/'.Auth::id().'/dashboard') }}">@lang('messages.home')</a>
                    @else
                        <a href="{{ URL::to('/'.LaravelLocalization::getCurrentLocale().'/login') }}">@lang('messages.login')</a>
                        <a href="{{ URL::to('/'.LaravelLocalization::getCurrentLocale().'/register') }}">@lang('messages.register')</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title_block">
                    <div class="title m-b-md ">
                        Inspire <span>CMS</span>
                    </div>
                </div>


            </div>


                <div class="info_block">
                        @lang('messages.want_website') <a href="{{ URL::to('/'.LaravelLocalization::getCurrentLocale().'/login') }}"><span>@lang('messages.just_build_it')</span></a>

                </div>
        </div>
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/5b6ad7bddf040c3e9e0c6717/default';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
    </body>
</html>
