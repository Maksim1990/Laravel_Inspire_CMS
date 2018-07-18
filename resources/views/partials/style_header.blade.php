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
        padding-top: 10px;
        padding-bottom: 10px;
        height: 50px;
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
        font-size: 20px;
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
        padding-top: 10px;
        padding-bottom: 10px;
        height: 50px;
    }
    .tooltip_menu_side .tooltiptext a:hover{
        background-color: rgba(50, 166, 54, 0.55);
    }


</style>