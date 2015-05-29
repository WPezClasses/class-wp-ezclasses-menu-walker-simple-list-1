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
 * == v0.5.1 - Thur 28 May 2015
 * --- ADDED: Separator (e.g., comma) between list items to mimic a typical taxonomy list (e.g. get_the_category_list())
 * --- CHANGED: values for is parent and is child classes are now set in the markup_defaults(). they were hardcoded previously.
 *
 * == v0.5.0 - Thur 21 May 2015
 * --- It's on!
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

    /**
     * @param string $output
     * @param object $item
     * @param int $depth
     * @param array $args
     * @param int $id
     */
	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0 ){

        // where does the args obj interset the markup_defaults
        $arr_markup_defaults = array_intersect_key((array) $args, $this->markup_defaults() );
        // merge that intersection onto the markup defaults
        $arr_markup_defaults = array_merge($this->markup_defaults(), $arr_markup_defaults );

        // how many total elements in this list
        $int_ele_cnt = $this->elements_count($args);


        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $class_names = $value = '';

        $classes_all = empty($item->classes) ? array() : (array)$item->classes;
        $classes[0] = $classes_all[0];

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

        // has children?
        if ($args->walker->has_children) {
            $class_names .= ' ' .  $arr_markup_defaults['parent'];
        } else {
            $class_names .= ' ' .  $arr_markup_defaults['not_parent'];
        }

        // is a child?
        if ( $item->menu_item_parent == 0 ){
            $class_names .= ' ' . $arr_markup_defaults['not_child'];
        } else{
            $class_names .= ' ' . $arr_markup_defaults['child'];
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


        // what's up with the delimiter / separator?
        $str_delimit_in = '';
        $str_delimit_out = '';
        if ( $arr_markup_defaults['separator_active'] === true && $item->menu_order < $int_ele_cnt ){
            $str_delimit_temp = '<span class="' . esc_attr($arr_markup_defaults['separator_class']). '">';
            $str_delimit_temp .= sanitize_text_field($arr_markup_defaults['separator']);
            $str_delimit_temp .= '</span>';

            if ( $arr_markup_defaults['separator_outside'] === true ){
                $str_delimit_out = $str_delimit_temp;
            } else {
                $str_delimit_in = $str_delimit_temp;
            }
        }

		$item_output = $args->before;

		$item_output .= '<a '. $attributes .'>';

		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		//	$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
		$item_output .= $str_delimit_in . '</a>' . $str_delimit_out;

		$item_output .= $args->after;

		$output .=  apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

    /**
     * @param string $output
     * @param object $item
     * @param int $depth
     * @param array $args
     */
	public function end_el(&$output, $item, $depth=0, $args=array()) {
        $output .= '</' . $this->_str_item_tag . '>'. "\n";
    }

    /**
     * @return array
     */
    protected function valid_item_tags(){

        return array(
            'li'    => true,
            'span'  => true,
            'div'   => true,

        );
    }

    /**
     * @return array
     */
    protected function markup_defaults(){

        $arr_markup_defaults = array(

            'parent'            => 'is-parent',
            'not_parent'        => 'not-parent',
            'child'             => 'is-child',
            'not_child'         => 'not-child',

            'separator_active'  => true,
            'separator_outside' => true,    // is the delimited within the </a> or outside?
            'separator_class'   => 'simple-list-1-delimiter-wrap',
            'separator'         => ','

            //   'title_prefix'      => '',
            //  'target_default'    => '_blank',
        );

        return $arr_markup_defaults;
    }


    /**
     * Total number of elements in this menu list
     * 
     * @param $obj_args
     * @return int
     */
    public function elements_count($obj_args){

        $arr_nav_menus = get_theme_mod( 'nav_menu_locations' );

        if (  isset($arr_nav_menus[$obj_args->menu]) ){

            $arr_nav_menu_elements = wp_get_nav_menu_items($arr_nav_menus[$obj_args->menu]);
            return count($arr_nav_menu_elements);
        }
        return 0;
    }

}