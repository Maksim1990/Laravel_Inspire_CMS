<div class="mainside col-xs-12 col-sm-11" id="mainside" >

    <div class="container-fluid maintabs">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <ul class="nav nav-tabs" role="tablist" id="main_tab">
                    @foreach($arrTabs as $title)
                        <li role="presentation" class="{{$title=="General" || $title=="Dashboard" ? $active : ""}}" ><a href="#{{$title}}" aria-controls="{{$title}}" role="tab" data-toggle="tab" class="tab_link">{{str_replace("_"," ",$title)}}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($arrTabs as $title)

                        <div role="tabpanel" class="tab-pane {{$title=="General" || $title=="Dashboard"? $active : ""}}" id="{{$title}}"> @yield($title)</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
