# foundation-nav-walker
Mega menu foundation nav walker for sage roots

1. Create new file in app folder "navigation-top.php" and paste walker class

2. In functions.php add to array map new file "navigation-top.php" 

`['helpers', 'setup', 'filters', 'navigation-top', 'admin']);`

3. Register new walker

        @php
        $mainNavArgs = [
          'container' => 'ul',
          'menu' => __('Primary Navigation', 'sage'),
          'menu_class' => 'mega-menu-top-menu',
          'theme_location' => 'primary_navigation',
          'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          'fallback_cb' => false,
          'walker' => new WH_Foundation_Mega_Menu_Walker()
          ];
        @endphp

        {!! wp_nav_menu($mainNavArgs) !!}

4. Create new menu in wordpress
5. Menu structure
   - Home
   - Shop   
     - col1 with class "wh-col-mm-span"
        - Category name 1     
        - Bananas
        - Apples
        - Oranges
     - col1 with class "wh-col-mm-span"
        - Category name 2      
        - Cars
        - Bikes
        - Boats
     - col1 with class "wh-col-mm-span"
        - Category name 3      
        - Women
        - Men
        - Kids
     - col1 with class "wh-col-mm-span"
        - Category name 4      
        - Rugby
        - Football
        - Boxing 

6. In css file set "display:none!important;" for class wh-col-mm-span to keeping columns properly


        
