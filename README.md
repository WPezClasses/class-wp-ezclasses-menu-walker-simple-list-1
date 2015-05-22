# TODO

### class-wp-ezclasses-menu-walker-simple-list-1
Use wp_nav_menu() to generate a simple list. Adds a couple custom ez args because that's The ezWay.

custom args (to be passed with the rest of your menu definition are:

              'item_tag'        => 'li',                             			// default = li, span and div are also allowed
              'item_id_slug'    => 'blog-menu-recommended-id-',               	// false will remove the id="..." from the list item
              'item_class'      => 'blog-menu-item',                           	// false will remove the class="..." from the list item
           
while start_lvl / end_lvl does not add anything special (i.e., there are no nested <ul><li><ul>...), each li item is evaluated and the following classes are added:
- parent has-children / not-parent no-children
- not-a-child / is-a-child

for a simple list these feel unnecessary but in the name of "ya never know, so always be prepared" they are included.	   