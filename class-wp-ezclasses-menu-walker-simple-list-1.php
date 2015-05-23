<?php
/**
 * Class Name: Class_WP_ezClasses_Menu_Walker_Simple_List_1
 * GitHub URI: https://github.com/WPezClasses/class-wp-ezclasses-menu-walker-simple-list-1
 * Description: Take a menu and generates a simple list of <li>s. Parents and children are noted as classes but _el is not implemented.
 * Version: 0.5.0
 * Author: 
 * License: MIT
 * License URI: TODO
 *
 *
 * @package WPezClasses
 * @author Mark Simchock <mark.simchock@alchemyunited.com>
 * @since 0.5.0
 * @license MIT
 */
 
/**
 * == Change Log == 
 *
 */
 
/**
 * == TODOs ==
 *
 * 
 */

if ( !defined('ABSPATH') ) {
	header('HTTP/1.0 403 Forbidden');
    die();
}


class Class_WP_ezClasses_Menu_Walker_Simple_List_1 extends Walker_Nav_Menu {

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */

    public function start_lvl( &$output, $depth = 0, $args = array() ) {

        $output .= '';


    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {

        $output .= '';

    }
	
	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0 ){

        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $class_names = $value = '';

        $classes_all = empty($item->classes) ? array() : (array)$item->classes;
        $classes[0] = $classes_all[0];

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

        // has children?
        if ($args->walker->has_children) {
            $class_names .= ' parent has-children';
        } else {
            $class_names.= ' not-parent no-children';
        }

        // is a child?
        if ( $item->menu_item_parent == 0 ){
            $class_names .= ' not-a-child';
        } else{
            $class_names .= ' is-a-child';
        }

        if ( in_array( 'current-menu-item', $classes_all ) ){
            $class_names .= ' active';
        }

        // NOTE: item_class is a special / custom arg and is not part of the standard wp menu fare
        $str_item_class = 'simple-list-li';
        if (isset($args->item_class) && ! empty($args->item_class) && $args->item_class !== false ){
            $str_item_class = esc_attr($args->item_class);
        }

		$class_names = $class_names ? ' class="' . $str_item_class. ' ' . esc_attr( $class_names ) . '"' :  ' class="' . $str_item_class . '"';

        // if item_class === false then don't use class
        if (isset($args->item_class) && $args->item_class === false ){
            $class_names = '';
        }

        // fallback for id_slug
        $str_id_slug = 'simple-list-li-';
        if (isset($args->menu_id) && ! empty($args->menu_id) ){
            $str_id_slug = $args->menu_id . '-';
        }
        // NOTE: item_id_slug is a special / custom arg and is not part of the standard wp menu fare
        if (isset($args->item_id_slug) && ! empty($args->item_id_slug) && $args->item_id_slug !== false ){
            $str_id_slug = $args->item_id_slug;
        }

		$id = apply_filters( 'nav_menu_item_id', $str_id_slug . $item->ID, $item, $args );
		$id = $id ? $indent . esc_attr( $id ) . '"' : '';

        // if item_id_slug === false then we don't use the id at all.
        if (isset($args->item_id_slug) && $args->item_id_slug === false ){
            $id = '';
        }

        $arr_valid_item_tags = $this->valid_item_tags();

        // NOTE: item_tag is a special / custom arg and is not part of the standard wp menu fare
        $this->_str_item_tag = 'li';
        if ( isset($args->item_tag) && in_array($args->item_tag, $arr_valid_item_tags) ){
            $this->_str_item_tag = $args->item_tag;

        }

		$output .=  $indent . '<' . $this->_str_item_tag . ' ' . $id . $value . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )	? $item->target	: '';
		$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
		$atts['data-description'] = ! empty( $item->description ) ? $item->description : '';

        $atts['href'] = ! empty( $item->url ) ? $item->url : '';

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;

			$item_output .= '<a '. $attributes .'>';

			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		//	$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
			$item_output .= '</a>';

			$item_output .= $args->after;

			$output .=  apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
	public function end_el(&$output, $item, $depth=0, $args=array()) {
        $output .= '</' . $this->_str_item_tag . '>'. "\n";
    }

    public function valid_item_tags(){

        return array(
            'li'    => true,
            'span'  => true,
            'div'   => true,

        );

    }

}