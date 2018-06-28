<style>
    .tooltip_header_menu {
        position: relative;
        display: inline-block;

    }

    .tooltip_header_menu .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: white;
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
        border-color: transparent transparent white transparent;
    }
</style>