@extends('dashboard::layouts.master')

@section('styles')
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <style>
        .body_about{

            color: black;
            font-family: 'Raleway', sans-serif;
            font-weight: 300;
            text-align: center;


        }
        .body_about p{
           font-size: 19px;
            line-height: 35px;
        }
    </style>
@stop
@section('General')
    <h3 class="title">@lang('messages.about_us')</h3>
    <div id="title_shape"></div>

    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 w3-center body_about">
            <h2><b>Inspire CMS - Website builder</b></h2>
           <p> Inspire CMS is an application that allows easily to build your own dynamic website. Absolutely all blocks
            are easily customizable and extendable. You can add custom CSS blocks or write any valid HTML code to all
            default existing blocks or to all new custom website blocks. Inspire CMS also provides useful and powerful
            Label management system that allows you to use your own custom translation labels on any language that you
            want to use on your website. The only thing you need to do in order to add any (even exotic) language is to
            activate it in Languages setting section in Inspire CMS admin panel. Also one of powerful application
            functionality is Inspire Office that provides you powerful instruments for uploading and handling images and
            files, for import and export your custom data. Import and Export functionality is also fully customizable
            with ability to choose type of file, number of lines to import/export and also order of exporting data.
            Inspire CMS comes out of the box with powerful and useful functionality for each user to customize header
            menu in application. Change order or translation for each menu items in application. Activate/deactivate
            specific items or group some items in menu dropdowns.

            Current version of this application support English, Russian, French & Thai languages.
           </p>
            <img height="200"
                 src="{{custom_asset('images/includes/inspire_grey.png')}}" alt="">
        </div>
    </div>
@stop
