<?php

class sbjobs_plugin extends WP_Widget {

	// constructor
	function sbjobs_plugin() {
        $widget_ops = array('classname' => 'sbjobs_plugin', 'description' => __('Lists jobs from StartupBrett', 'sbjobs' ));
        $this->WP_Widget('sbjobs_plugin', __('StartupBrett Job Widget', 'sbjobs'), $widget_ops);
	}

	// widget form creation
	function form($instance) {	
	    // Check values
        if( $instance) {
             $title = esc_attr($instance['title']);
             $affiliate_id = esc_attr($instance['affiliate_id']);
             
             $count = esc_attr($instance['count']);
             $hide_button = esc_attr($instance['hide_button']);
             $show_credit = esc_attr($instance['hide_credit']); 
             $hide_type = esc_attr($instance['hide_type']);
             $hide_location = esc_attr($instance['hide_location']);
             $order_by = esc_attr($instance['order_by']);
             $sbtypes = esc_attr($instance['sbtypes']);
             $categories = esc_attr($instance['categories']);
             $buttoncolor = esc_attr($instance['buttoncolor']);
        } else {
             $title = __('Jobs', 'sbjobs');
             $affiliate_id = '';
             $count = '5';
             $hide_button = '';
             $show_credit = '';
             $hide_type = '';
             $hide_location = '';
             $order_by = '';
             $sbtypes = 'all';
             $categories = 'all';
             $buttoncolor = '#4CAF50';
        }
        ?>
        
        <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'sbjobs'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id('affiliate_id'); ?>"><?php _e('Affiliate ID (optional - <a href="http://www.startupbrett.de/affiliate/" target="_blank">StartupBrett Affiliate-Partner Subscription</a>):', 'sbjobs'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('affiliate_id'); ?>" name="<?php echo $this->get_field_name('affiliate_id'); ?>" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $affiliate_id; ?>" />
        </p>
        
        <h3><?php echo __('Display preferences', 'sbjobs')?></h3>
        <p>
        <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Job listing count', 'sbjobs'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $count; ?>" />
        </p>
        <table>
        <tr>
        <p>
        <td><label for="<?php echo $this->get_field_id('sbtypes'); ?>"><?php _e('Select employment relationship', 'sbjobs'); ?></label></td>
        <td><select name="<?php echo $this->get_field_name('sbtypes'); ?>" id="<?php echo $this->get_field_id('sbtypes'); ?>" >
            <option value="all" <?php echo selected( $sbtypes, 'all', false ); ?>>Alle anzeigen</option>
            <option value="ausbildung" <?php echo selected( $sbtypes, 'ausbildung', false ); ?>>Ausbildung</option>
            <option value="freelancer" <?php echo selected( $sbtypes, 'freelancer', false ); ?>>Freelancer</option>
            <option value="hilfskraft" <?php echo selected( $sbtypes, 'hilfskraft', false ); ?>>Hilfskraft</option>
            <option value="praktikum" <?php echo selected( $sbtypes, 'praktikum', false ); ?>>Praktikum</option>
            <option value="teilzeit" <?php echo selected( $sbtypes, 'teilzeit', false ); ?>>Teilzeit</option>
            <option value="trainee" <?php echo selected( $sbtypes, 'trainee', false ); ?>>Trainee</option>
            <option value="vollzeit" <?php echo selected( $sbtypes, 'vollzeit', false ); ?>>Vollzeit</option>
            <option value="volontariat" <?php echo selected( $sbtypes, 'volontariat', false ); ?>>Volontariat</option>
        </select>
        </td>
        </p>
        </tr>
        <tr>
        <p>
        <td><label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Select category', 'sbjobs'); ?></label></td>
        <td><select name="<?php echo $this->get_field_name('categories'); ?>" id="<?php echo $this->get_field_id('categories'); ?>" >
            <option value="all" <?php echo selected( $categories, 'all', false ); ?>>Alle Kategorien</option>
            <option value="berater" <?php echo selected( $categories, 'berater', false ); ?>>Berater</option>
            <option value="business-development" <?php echo selected( $categories, 'business-development', false ); ?>>Business Development</option>
            <option value="co-founder" <?php echo selected( $categories, 'co-founder', false ); ?>>Co-Founder</option>
            <option value="customer-care" <?php echo selected( $categories, 'customer-care', false ); ?>>Customer Care</option>
            <option value="development" <?php echo selected( $categories, 'development', false ); ?>>Development</option>
            <option value="finanz" <?php echo selected( $categories, 'finanz', false ); ?>>Finanz</option>
            <option value="grafik" <?php echo selected( $categories, 'grafik', false ); ?>>Grafik</option>
            <option value="hr" <?php echo selected( $categories, 'hr', false ); ?>>HR</option>
            <option value="it" <?php echo selected( $categories, 'it', false ); ?>>IT</option>
            <option value="management" <?php echo selected( $categories, 'management', false ); ?>>Management</option>
            <option value="marketing" <?php echo selected( $categories, 'marketing', false ); ?>>Marketing</option>
            <option value="operations" <?php echo selected( $categories, 'operations', false ); ?>>Operations</option>
            <option value="prmedia" <?php echo selected( $categories, 'prmedia', false ); ?>>PR/Media</option>
            <option value="produktmanagement" <?php echo selected( $categories, 'produktmanagement', false ); ?>>Produktmanagement</option>
            <option value="projektmanagement" <?php echo selected( $categories, 'projektmanagement', false ); ?>>Projektmanagement</option>
            <option value="recht" <?php echo selected( $categories, 'recht', false ); ?>>Recht</option>
            <option value="sales" <?php echo selected( $categories, 'sales', false ); ?>>Sales</option>
            <option value="sonstige" <?php echo selected( $categories, 'sonstige', false ); ?>>Sonstige</option>
        </select>
        </td>
        </tr>
        </table>
        </p><p>
        <input class="widefat" id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>" type="checkbox" name="order_by" value="1" <?php echo checked( 1, $order_by, false);?> >
        <label for="<?php echo $this->get_field_id('order_by'); ?>"><?php _e('Random order', 'sbjobs'); ?></label>        
        </p>
        <p>
        <input class="widefat" id="<?php echo $this->get_field_id('hide_type'); ?>" name="<?php echo $this->get_field_name('hide_type'); ?>" type="checkbox" name="hide_type" value="1" <?php echo checked( 1, $hide_type, false);?> >
        <label for="<?php echo $this->get_field_id('hide_type'); ?>"><?php _e('Hide employment relationship', 'sbjobs'); ?></label>        
        </p>
        <p>
        <input class="widefat" id="<?php echo $this->get_field_id('hide_location'); ?>" name="<?php echo $this->get_field_name('hide_location'); ?>" type="checkbox" name="hide_location" value="1" <?php echo checked( 1, $hide_location, false);?> >
        <label for="<?php echo $this->get_field_id('hide_location'); ?>"><?php _e('Hide job location', 'sbjobs'); ?></label>        
        </p>
        <p>
        <input class="widefat" id="<?php echo $this->get_field_id('hide_button'); ?>" name="<?php echo $this->get_field_name('hide_button'); ?>" type="checkbox" name="hide_button" value="1" <?php echo checked( 1, $hide_button, false);?> >
        <label for="<?php echo $this->get_field_id('hide_button'); ?>"><?php _e('Hide "Submit job"-button', 'sbjobs'); ?></label>        
        </p>
        <p>
        <input class="widefat" id="<?php echo $this->get_field_id('show_credit'); ?>" name="<?php echo $this->get_field_name('show_credit'); ?>" type="checkbox" name="show_credit" value="1" <?php echo checked( 1, $show_credit, false);?> >
        <label for="<?php echo $this->get_field_id('show_credit'); ?>"><?php _e('Show StartupBrett-Branding', 'sbjobs'); ?></label>        
        </p>
        <p>
        <label for="<?php echo $this->get_field_id('buttoncolor'); ?>"><?php _e('Button-color:', 'sbjobs'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('buttoncolor'); ?>" name="<?php echo $this->get_field_name('buttoncolor'); ?>" type="text" value="<?php echo $buttoncolor; ?>" />
        </p>
        
        <?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
      // Fields
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['affiliate_id'] = strip_tags($new_instance['affiliate_id']);
      $instance['count'] = strip_tags($new_instance['count']);
      $instance['hide_button'] = strip_tags($new_instance['hide_button']);
      $instance['show_credit'] = strip_tags($new_instance['show_credit']);
      $instance['hide_type'] = strip_tags($new_instance['hide_type']);
      $instance['hide_location'] = strip_tags($new_instance['hide_location']);
      $instance['sbtypes'] = strip_tags($new_instance['sbtypes']);
      $instance['categories'] = strip_tags($new_instance['categories']);
      $instance['order_by'] = strip_tags($new_instance['order_by']);
      $instance['buttoncolor'] = strip_tags($new_instance['buttoncolor']);
     return $instance;
	}

	// widget display
	function widget($args, $instance) {
        extract( $args );
        
        // these are the widget options
        $title = apply_filters('widget_title', $instance['title']);
        
        
        $affiliate_id = $instance['affiliate_id'];
        $buttoncolor = $instance['buttoncolor'];
        $hide_button = $instance['hide_button'];
        $show_credit = $instance['show_credit'];
        $hide_type = $instance['hide_type'];
        $hide_location = $instance['hide_location'];
        $types = $instance['sbtypes'];
        $categories = $instance['categories'];
        $count = $instance['count'];
        $order_by = $instance['order_by'];
        
        echo $before_widget;
        // Display the widget
        echo '<div class="widget-text wp_sb_plugin_box">';
        
        // Check if title is set
        if ( $title ) {
          echo $before_title . $title . $after_title;
        }
        
        $options = 'sb_jobs';
        // Check if text is set
        if( $affiliate_id ) {
          $options .= ' affiliate_id="' . $affiliate_id . '"';
        }
        if( $buttoncolor ) {
          $options .= ' button-color="' . $buttoncolor . '"';
        }
        if( $count ) {
          $options .= ' count="' . $count . '"';
        }
        if( $types != "all" ) {
          $options .= ' types="' . $types . '"';
        }
        if( $categories != "all" ) {
          $options .= ' categories="' . $categories . '"';
        }
        if( $hide_button ) {
          $options .= ' hide_button="1"';
        }
        if( $show_credit ) {
          $options .= ' show_credit="1"';
        }
        if( $hide_type ) {
          $options .= ' hide_type="1"';
        }
        if( $hide_location ) {
          $options .= ' hide_location="1"';
        }
        if( $order_by ) {
          $options .= ' order_by="rand"';
        }
        echo do_shortcode('[' . $options . ']');
        echo '</div>';
        echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("sbjobs_plugin");'));

?>