<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
	
	update_option( 'publishercode', $_POST['publishercode']);
	update_option( 'what', $_POST['what']);
	update_option( 'where', $_POST['where']);
	
	// Get the old directory page ID
	$parent_page = get_page_by_title( get_option('directory_label') );	
	$parent_page_id = $parent_page->ID;
	update_option( 'directory_label', trim($_POST['directory_label']));	
	
	if ( $parent_page ) 
		{
	    $parent_page->post_title = trim($_POST['directory_label']);
	    
	    wp_update_post( $parent_page );

		}
		
	$parent_page = get_page_by_title( get_option('directory_label') );	
	$parent_page_id = $parent_page->ID;	
		
	// Bust out each what and build a page
	$what = explode(",", $_POST['what']);
	
	$the_page = get_page_by_title( $the_page_title );
	
	foreach( $what as $page){

		$the_page_title = trim($page);
		$the_page = get_page_by_title( $the_page_title );
		$the_page_body = "";
		
		if ( ! $the_page ) {
		
		    $_p = array();
		    $_p['post_title'] = $the_page_title;
		    $_p['post_content'] = '';
		    $_p['post_status'] = 'publish';
		    $_p['post_type'] = 'page';
		    $_p['post_parent'] = $parent_page_id;
		    $_p['comment_status'] = 'closed';
		    
		    // Insert the post into the database
		    $the_page_id = wp_insert_post( $_p );
		    
		    update_post_meta( $the_page_id, '_wp_page_template', 'cg-search.php' );
		    update_post_meta( $the_page_id, 'what', $page ); 
		
		}
		else {
	
		    $the_page_id = $the_page->ID;
		
		    $the_page->post_status = 'publish';

		    update_post_meta( $the_page_id, '_wp_page_template', 'cg-search.php' );
		    update_post_meta( $the_page_id, 'what', $page ); 
		
		}
		
	}	
	
	update_option( 'show_ads', $_POST['show_ads']);
	
	}
?>

<div class="wrap">

<script type="text/javascript" src="http://static.citygridmedia.com/ads/scripts/v2/loader.js"></script>

<h2>CityGrid Wordpress Plugin</h2>

<form method="post" action="">
    <?php
		settings_fields( 'cg-settings-group' );
	?>
    <table class="form-table">
    
        <tr valign="top">
        <th scope="row">CityGrid Publisher Code</th>
        <td>
        	<input type="text" name="publishercode" value="<?php echo get_option('publishercode'); ?>" />
        	A unique code assigned to you for tracking your calls to CityGrid API.  Obtain a publisher code by <a href="http://developer.citygridmedia.com/dashboard/registration">registering at CityGrid Developer Center</a>.
        </td>
        </tr>  
        
        <tr valign="top">
        <th scope="row">Directory Label</th>
        <td>
        	<input type="text" name="directory_label" value="<?php echo get_option('directory_label'); ?>" />
        	The name of the page that will be the top level menu name of your local directory.
        </td>
        </tr>    
        
        <tr valign="top">
        <th scope="row">Where</th>
        <td>
        	<input type="text" name="where" value="<?php echo get_option('where'); ?>" />
        	A location of "where" you want to provide a search for, this can include:  Cities, Neighborhoods, Zip Codes, Metro Areas, Addresses and Intersections.
        </td>
        </tr>        
         
        <tr valign="top">
        <th scope="row">What</th>
        <td>
        
        	<textarea name="what" cols="40" rows="3"><?php echo get_option('what'); ?></textarea>
	        Keywords separated by commas (pizza, pubs, hair salon, auto parts).  Each keyword or phrase will create new page and directory.
	        
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Show Ads</th>
        <td>
        	<select name="show_ads">
        		<option value="yes"<?php if(get_option('show_ads')=='yes'){ ?> selected<?php } ?>>yes</option>
        		<option value="no"<?php if(get_option('show_ads')=='no'){ ?> selected<?php } ?>>no</option>
        	</select>
        	Whether you would like to show advertisements on your directory page.
        </td>
        </tr>        
        
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>