<?php

/*
 * Nav Walker mix with foundation framework.
 * Mega Menu based on drop down pane function.
*/

/*
 * Class .wh-col-mm-span added as container ul in admin panel should be set display: none; in css
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
            $output .= "\n$indent<ul class=\"dropdown2 menu cell medium-3\">\n";
        }
    }

    /*  start el */
    function start_el( &$output, $item, $depth=0, $args = array(), $id = 0) {
        $class_toggle = 'example-dropdown-';
        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        // Get ID of start_lvl
        $this->curItem = $item;

        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        /*
        * 1. Check li, if have parent class add data-toggle attribute.
        * 2. If depth is 0 but no childs elements add li
        */
        if ( $depth == 0 && in_array('menu-item-has-children', $item->classes) ) {

            $output .= '<li' . $class_names . ' data-toggle=' . $class_toggle . $item->ID . '>';
        }

        if ( $depth == 0 && in_array('menu-item-has-children', $item->classes) == false ) {
            $output .= $indent . '<li' . $id . $class_names . '>';
        }

        $atts           = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        if ( '_blank' === $item->target && empty( $item->xfn ) ) {
            $atts['rel'] = 'noopener noreferrer';
        } else {
            $atts['rel'] = $item->xfn;
        }

        $atts['href']         = ! empty( $item->url ) ? $item->url : '';
        $atts['aria-current'] = $item->current ? 'page' : '';

        /**
         * Filters the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title        Title attribute.
         *     @type string $target       Target attribute.
         *     @type string $rel          The rel attribute.
         *     @type string $href         The href attribute.
         *     @type string $aria_current The aria-current attribute.
         * }
         * @param WP_Post  $item  The current menu item.
         * @param stdClass $args  An object of wp_nav_menu() arguments.
         * @param int      $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        /** This filter is documented in wp-includes/post-template.php */
        $title = apply_filters( 'the_title', $item->title, $item->ID );

        /**
         * Filters a menu item's title.
         *
         * @since 4.4.0
         *
         * @param string   $title The menu item's title.
         * @param WP_Post  $item  The current menu item.
         * @param stdClass $args  An object of wp_nav_menu() arguments.
         * @param int      $depth Depth of menu item. Used for padding.
         */
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );


        /* Add custom classes to a elements */
        $item_output  = $args->before;
        $item_output .= '<a' . $class_names . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        /**
         * Filters a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string   $item_output The menu item's starting HTML output.
         * @param WP_Post  $item        Menu item data object.
         * @param int      $depth       Depth of menu item. Used for padding.
         * @param stdClass $args        An object of wp_nav_menu() arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

    }

    /* end el */
    function end_el( &$output, $item, $depth=0, $args = array(), $id = 0) {
        $output .= "</li>";
    }

}

