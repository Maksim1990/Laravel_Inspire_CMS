

<header >
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img style="margin-top: -15px;"  height="50" src="/images/includes/logo_white.png" alt="">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                        <li><a href="#">Link</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" ><i class="fa fa-group" style="font-size:20px;margin-right:10px;"></i>Community</a></li>
                            <li><a href="#" ><i class="fa fa-file-sound-o" style="font-size:20px;margin-right:10px;"></i>Advertisement</a></li>
                            <li><a href="#"><i class="fa fa-tasks" style="font-size:20px;margin-right:10px;"></i>Tasks management</a></li>
                            <li><a href="#" ><i class="material-icons" style="font-size:20px;margin-right:10px;">work</i>Job offers</a></li>
                            <li><a href="#" ><i class="material-icons" style="font-size:20px;margin-right:10px;">note</i>Notes</a></li>
                            <li><a href="#" ><i class="material-icons" style="font-size:20px;margin-right:10px;">monetization_on</i>Currency converter</a></li>
                            <li><a href="#" ><i class="fa fa-calendar" style="font-size:20px;margin-right:10px;"></i>Calendar</a></li>
                            <li><a href="#" ><i class="fa fa-globe" style="font-size:20px;margin-right:10px;"></i>Country module</a></li>
                            <li><a href="#" ><i class="fa fa-file-word-o" style="font-size:20px;margin-right:10px;"></i>Translator</a></li>
                            <li><a href="#"><i class="material-icons" style="font-size:20px;margin-right:10px;">email</i>Check Email module</a></li>
                            <li role="separator" class="divider"></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-user-circle" style="font-size:20px;margin-right:10px;"></i>Edit profile</a></li>
                            <li><a href="#"><i class="material-icons" style="font-size:20px;margin-right:10px;">edit</i>Change password</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="fa fa-info-circle" style="font-size:20px;margin-right:10px;"></i>About</a></li>
                            <li><a href="#"><i i class="material-icons" style="font-size:20px;margin-right:10px;">call</i>Contact Us</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route("website")}}">Visit website</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right" id="user_block_menu">
                    <li id="loggedName">
                        <p  data-placement="bottom" data-userid="{{Auth::id()}}" data-container="body" data-toggle="logged_user" data-placement="left" data-html="true" href="#">
                            <img data-imageid="{{Auth::user()->photo?Auth::user()->photo->id :'0'}}" data-imagepath="{{Auth::user()->photo ? Auth::user()->photo->path :"/images/noimage.png"}}" style="border-radius: 40px;" height="45" src="{{Auth::user()->photo ? Auth::user()->photo->path :"/images/includes/noimage.png"}}" alt="">
                            <span class="" style="color:white;display:inline;position: relative;top: 5px;"> Hello, {{ Auth::user()->name }} !</span>
                        </p>



                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>

                </ul>
                <ul class="nav navbar-nav navbar-right" style="margin:-10px 40px 0 0;">
                    <li ><a href="#">
                            <i class="fa fa-bell w3-xxlarge w3-text-yellow"   aria-hidden="true"></i>
                            <span class="w3-badge w3-large  w3-white" id="notification_number">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


</header>
