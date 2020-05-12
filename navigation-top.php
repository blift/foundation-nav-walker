<?php

/*
 * Nav Walker mix with foundation framework.
 * Mega Menu based on drop down pane function.
*/


class WH_Foundation_Mega_Menu_Walker extends Walker_Nav_Menu
{
    //save current item so it can be used in start level
    private $curItem;

    /* start lvl */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $class = 'example-dropdown-';
        $thisItem = $this->curItem;

        if( $depth <= 0 ) {
            $output .= "\n$indent<ul class=\"dropdown-pane\" id=" . $class . $thisItem->ID . " data-dropdown data-hover=\"true\" data-hover-pane=\"true\">
                <div class=\"grid-container\">
                    <div class=\"grid-x\">\n";
        } else {
            $output .= "\n$indent<ul class=\"dropdown2 menu\">
                <div class=\"cell auto\">\n";
        }
    }


    /*  start el */
    function start_el( &$output, $item, $depth=0, $args = array(), $id = 0) {
        // $object = $item->object;
        // $type = $item->type;
        $title = $item->title;
        $permalink = $item->url;
        $class = 'example-dropdown-';
        $sub_level_li = 'iam-sub';
        // Get ID of start_lvl
        $this->curItem = $item;

        /*
        * Check li, if have parent class and it's first depth in menu active pane
        */

        if ( !empty($item->classes) &&
            $depth == 0 &&
            is_array($item->classes) &&
            in_array('menu-item-has-children', $item->classes) ) {

            $output .= "<li class='" .  implode(" ", $item->classes) . "' data-toggle='" . $class . $item->ID . "'>";
        }

        /* Add SPAN if no Permalink - right now for test only there will be columns
         * Class .col-mm-span added as container ul in admin panel should be set display: none; in css
        */

        if( $permalink && $permalink != '#' ) {
            $output .= '<a href="' . $permalink . '">';
        } else {
            $output .= "<span class='" .  implode(" ", $item->classes) . "'>";
        }

        $output .= $title;

        if( $permalink && $permalink != '#' ) {
            $output .= '</a>';
        } else {
            $output .= '</span>';
        }
    }

    /* end el */
    function end_el( &$output, $item, $depth=0, $args = array(), $id = 0) {
        $output .= "</li>";
    }
}

