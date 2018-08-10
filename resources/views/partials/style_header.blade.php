<style>
    .tooltip_header_menu {
        position: relative;
        display: inline-block;

    }

    .tooltip_header_menu .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: rgb(74, 74, 74);
        color: black;
        text-align: center;
        border-radius: 6px;
        border: 1px solid black;
        padding: 5px 0;


        /* Position the tooltip */
        position: absolute;
        z-index: 1;
    }
    .tooltip_header_menu:hover .tooltiptext {
        visibility: visible;
    }
    .tooltip_header_menu .tooltiptext::after {
        content: " ";
        position: absolute;
        bottom: 100%; /* At the top of the tooltip */
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: transparent transparent rgb(74, 74, 74) transparent;
    }
    .tooltip_header_menu .tooltiptext a{
        display: block;
        width: 100%;
        color: white;
        padding-top: 5px;
        padding-bottom: 5px;
        height: 30px;
    }
    .tooltip_header_menu .tooltiptext a:hover{
        background-color: rgba(50, 166, 54, 0.55);
    }


    .tooltip_menu_side {
        position: relative;
        display: block;
    }

    .tooltip_menu_side .tooltiptext {
        visibility: hidden;
        width: 320px;
        font-size: 15px;
        background-color: #061114;
        color: black;
        text-align: center;
        border-radius: 6px;
        border: 1px solid darkgray;
        padding: 5px 0;

        /* Position the tooltip */
        position: absolute;
        z-index: 2;
        top:-10px;
        left: 82px;
    }
    .tooltip_menu_side:hover .tooltiptext {
        visibility: visible;
    }
    .tooltip_menu_side .tooltiptext::after {
        content: " ";
        position: absolute;
        top: 20%;
        right: 100%; /* To the left of the tooltip */
        margin-top: -5px;
        border-width: 15px;
        border-style: solid;
        border-color: transparent #061114 transparent transparent;
    }
    .tooltip_menu_side .tooltiptext a{
        display: block;
        width: 100%;
        padding-top: 5px;
        padding-bottom: 5px;
        height: 30px;
    }
    .tooltip_menu_side .tooltiptext a:hover{
        background-color: rgba(50, 166, 54, 0.55);
    }


    .dropdown-menu > li.kopie > a {
        padding-left:5px;
    }

    .dropdown-submenu {
        position:relative;
    }
    .dropdown-submenu>.dropdown-menu {
        top:0;left:100%;
        margin-top:-6px;margin-left:-1px;
        -webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;
    }

    .dropdown-submenu > a:after {
        border-color: transparent transparent transparent #333;
        border-style: solid;
        border-width: 5px 0 5px 5px;
        content: " ";
        display: block;
        float: right;
        height: 0;
        margin-right: -10px;
        margin-top: 5px;
        width: 0;
    }

    .dropdown-submenu:hover>a:after {
        border-left-color:#555;
    }

    .dropdown-menu > li > a:hover, .dropdown-menu > .active > a:hover {
        text-decoration: underline;
    }

    @media (max-width: 767px) {
        .navbar-nav  {
            display: inline;
        }
        .navbar-default .navbar-brand {
            display: inline;
        }
        .navbar-default .navbar-toggle .icon-bar {
            background-color: #fff;
        }
        .navbar-default .navbar-nav .dropdown-menu > li > a {
            color: red;
            background-color: #ccc;
            border-radius: 4px;
            margin-top: 2px;
        }
        .navbar-default .navbar-nav .open .dropdown-menu > li > a {
            color: #333;
        }
        .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
        .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
            background-color: #ccc;
        }

        .navbar-nav .open .dropdown-menu {
            border-bottom: 1px solid white;
            border-radius: 0;
        }
        .dropdown-menu {
            padding-left: 10px;
        }
        .dropdown-menu .dropdown-menu {
            padding-left: 20px;
        }
        .dropdown-menu .dropdown-menu .dropdown-menu {
            padding-left: 30px;
        }
        li.dropdown.open {
            border: 0px solid red;
        }

    }

    @media (min-width: 768px) {
        ul.nav li:hover > ul.dropdown-menu {
            display: block;
        }
        #navbar {
            text-align: center;
        }
    }

</style>