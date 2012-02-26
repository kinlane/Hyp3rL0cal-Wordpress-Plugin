<?php get_header(); ?>

<div id="primary" style="border: 0px solid #000; width: 650px;">
	<div id="content" role="main" style="border: 0px solid #000; width: 640px;">

	<?php
	
	require 'cg-places.php';
	require 'cg-advertising.php';
	
	$where = get_option('where');
	$what = get_option('what');
	
	$publishercode = get_option('publishercode');

	// page_id
	if(isset($_REQUEST['page_id'])){ $id = $_REQUEST['page_id'];} elseif(isset($_POST['page_id'])){$id = $_POST['page_id']; }

	// id
	if(isset($_REQUEST['id'])){ $id = $_REQUEST['id'];} elseif(isset($_POST['id'])){$id = $_POST['id']; } else { $id=''; }

	// what
	if(isset($_REQUEST['what'])){ $what = $_REQUEST['what'];} elseif(isset($_POST['what'])){$what = $_POST['what']; }
	// type
	if(isset($_REQUEST['type'])){ $type = $_REQUEST['type'];} elseif(isset($_POST['type'])){$type = $_POST['type']; } else { $type=''; }
	// where
	if(isset($_REQUEST['where'])){ $where = $_REQUEST['where'];} elseif(isset($_POST['where'])){$where = $_POST['where']; } 
	
	// page
	if(isset($_REQUEST['page'])){ $page = $_REQUEST['page'];} elseif(isset($_POST['page'])){$page = $_POST['page']; } else { $page=1; }
	// rpp
	if(isset($_REQUEST['rpp'])){ $rpp = $_REQUEST['rpp'];} elseif(isset($_POST['rpp'])){$rpp = $_POST['rpp']; } else { $rpp=10; }
	// sort
	if(isset($_REQUEST['sort'])){ $sort = $_REQUEST['sort'];} elseif(isset($_POST['sort'])){$sort = $_POST['sort']; } else { $sort='dist'; }
	
	if($id!='') 
		{
		?>	

		<strong>
			<a href="#">Places</a> /
			<a href="#"><?php echo $where;?></a> / 
			<?php if($what!='') {?>
				<a href="#"><?php echo $what;?></a>
			<?php } ?>
		</strong>
		
		<br />
	
		<?php
		
		$phone=null;
		$customer_only=null;
		$placement = null;
		$all_results=null;
		$review_count=null;
		$i=null;
		$format='json';
		$callback=null;
		$id_type='cg';
	
		//Get Place Detail
		$citygrid = new citygridplaces($publishercode);
		$search = $citygrid->places_detail($id,$id_type,$phone,$customer_only,$all_results,$review_count,$placement,$format,$callback,$i);
						
		// locations
		$locations = $search->locations[0];
		
		$id = $locations->id;
		$public_id = $locations->public_id;
		$infousa_id = $locations->infousa_id;
		$reference_id = $locations->reference_id;
		$impression_id = $locations->impression_id;
		$name = $locations->name;
		$display_ad = $locations->display_ad;
		if($display_ad==1) { $display_ad = 1; } else { $display_ad = 0; }
		$teaser = $locations->teaser;
		$business_operation_status = $locations->business_operation_status;
		$address = $locations->address;
		$years_in_business = $locations->years_in_business;
		$last_update_time = $locations->last_update_time;
		
		// address
		$address = $locations->address;
		$street = $address->street;
		$city = $address->city;
		$state = $address->state;
		$postal_code = $address->postal_code;
		$cross_street = $address->cross_street;
		$latitude = $address->latitude;
		$longitude = $address->longitude;
		
		// contact_info
		$contact_info = $locations->contact_info;
		$display_phone = $contact_info->display_phone;
		$display_url = $contact_info->display_url;
	    ?>
		<br />
		<address>
			<strong><?php echo $name; ?></strong><br />
			<?php echo $street; ?><br />
			<?php echo $city; ?>, <?php echo $state; ?> <?php echo $postal_code; ?><br />
			<abbr title="Phone">P:</abbr> <?php echo $display_phone; ?>
		</address>	
			
		<?php
		// Only Display Ads if this record allows, otherwise against TOS / Usage Requirements
		if($display_ad==1 && get_option('show_ads') == 'no') 
			{
			// Display a Web Ad that is 630 x 100
			$adid = 4;
			$publisher = 'citysearch';
			$citygridad = new citygridads($publishercode);
			?>
			<div id="detail_ad_slot_<?php echo $adid; ?>" align="center"></div>
			<?php
			echo $citygridad->display_web_ad_630_100('detail_ad_slot_'.$adid,$publisher,$what,$where);						
			?>
			<br />
			<?php		
			}
	
	    if(isset($search->locations[0]->neighborhoods) && count($search->locations[0]->neighborhoods) > 0) {
	    	?>
			<div class="page-header">
				<strong>Neighborhoods</strong>
			</div>  
			<ul>
		     <?php
		     $neighborhoods = $search->locations[0]->neighborhoods;
		     foreach($neighborhoods as $neighborhood) {
				 ?><li><?php echo $neighborhood;?></li><?php 
			     }
		     ?>
		     </ul>
		     <?php
	    	}
	
	    if(isset($search->locations[0]->urls) && count($search->locations[0]->urls) > 0) {
	    	?>
			<center>
			<table width="100%">
				<tr>
				     <?php
			    	 $urls = $search->locations[0]->urls;
			    	 
					 $profile_url = $urls->profile_url;
					 $reviews_url = $urls->reviews_url;
					 $video_url = $urls->video_url;
					 $website_url = $urls->website_url;
					 $menu_url = $urls->menu_url;
					 $reservation_url = $urls->reservation_url;
					 $map_url = $urls->map_url;
					 $send_to_friend_url = $urls->send_to_friend_url;
					 $email_link = $urls->email_link;
					 $custom_link_1 = $urls->custom_link_1;
					 $custom_link_2 = $urls->custom_link_2;
					 $web_comment_url = $urls->web_comment_url;
					 $web_article_url = $urls->web_article_url;
					 $web_profile_url = $urls->web_profile_url;
					 $web_rates_url = $urls->web_rates_url;
					 $gift_url = $urls->gift_url;
					 $request_quote_url = $urls->request_quote_url;
					 $virtual_tour_url = $urls->virtual_tour_url;
					 $book_limo_url = $urls->book_limo_url;
					 $order_url = $urls->order_url;
					 $custom_link_3 = $urls->custom_link_3;
					 $custom_link_4 = $urls->custom_link_4;
			    	 
			    	 foreach($urls as $key => $urlvalue) {
			    	 	if($urlvalue!='') {
			    	 		
			    	 		$key = str_replace("_"," ",$key);
			    	 		$key = str_replace("url","",$key);
			    	 		$key = ucfirst($key);
			    	 		
			    	 		if(is_string($urlvalue) && trim($key) != 'Profile' && trim($key) != 'Reviews') 
			    	 			{	    	 				
			    	 			?>
			    	 			<td style="background-color: #000; padding: 10px; text-align: center;">
			    	 				<a href="<?php echo $urlvalue; ?>" target="_blank" style="color:#FFF;"><?php echo $key; ?></a>
			    	 			</td>
			    	 			<?php
			    	 			}
			    	 		}
			    	 }
				     ?>
		     	</tr>
		     </table>
		     </center>
		     <?php    	 	
	    	}
	
	    if(isset($search->locations[0]->customer_content) && count($search->locations[0]->customer_content) > 0) {
	    	
		     $customer_content = $search->locations[0]->customer_content;
		     //var_dump($customer_content);
			 $customer_message = $customer_content->customer_message;	 	 
			 
			 $attribution_source = $customer_message->attribution_source;
			 $attribution_logo = $customer_message->attribution_logo;
			 $attribution_text = $customer_message->attribution_text;
			 $attribution_url = $customer_message->attribution_url;
			 $attribution_value = $customer_message->value;
	 
			if($attribution_text != '') {
		    	?>
				<div class="page-header">
					<strong>Customer Content</strong>
				</div>     
				<p>
					<?php if($attribution_logo!='') { ?><img src="<?php echo $attribution_logo; ?>" width="150" align="left" style="padding: 15px;" /><?php } ?>
					<strong>From <a href="<?php echo $attribution_url; ?>"><?php echo $attribution_text;?></a></strong> - <?php echo $attribution_value;?>
				</p>
			    <?php
		    	}
	    	
	    	}
	    	
	    if(isset($search->locations[0]->customer_content->bullets) && count($search->locations[0]->customer_content->bullets) > 0) {     	
	    	 $bullets = $search->locations[0]->customer_content->bullets;
		 
	    	 foreach($bullets as $key => $value) {
	    	 	if($value!='') {
	    	 		$key = str_replace("_"," ",$key);
	    	 		$key = str_replace("url","URL",$key);
	    	 		$key = ucfirst($key);
		 			?><li><a href="<?php echo $value;?>" target="_blank"><?php echo $value;?></a></li><?php 
	    	 		}
	    	 	}		 
	    	}
		 
	    if(isset($search->locations[0]->offers) && count($search->locations[0]->offers) > 0) {
	    	?>
	    	<br />
			<div class="page-header">
				<strong>Offers</strong>
			</div>     
		     <?php	 
	     $offers = $search->locations[0]->offers;
	     ?>
	     <ul>
	     <?php
		 foreach($offers as $offer) {
		 	if($value!='') {
	
				$offer_id = $offer->offer_id;
				$offer_name = $offer->offer_name;
				$offer_text = $offer->offer_text;
				$offer_description = $offer->offer_description;
				$offer_url = $offer->offer_url;
				$offer_expiration_date = $offer->offer_expiration_date;
				$attribution_source = $offer->attribution_source;
				$attribution_logo = $offer->attribution_logo;
				$attribution_text = $offer->attribution_text;
				$attribution_url = $offer->attribution_url;
	
	 			?>
	 			<li>
	 				<a href="<?php echo $offer_url;?>" target="_blank">
	 				<?php echo $offer_name;?></a>
	 				<?php if($offer_text!='') { ?>- <?php echo $offer_text; }?>
	 				<?php if($offer_description!='') { ?>- <?php echo $offer_description; }?>
	 				<?php if($offer_expiration_date!='') { ?>(<?php echo $offer_description;?>)<?php } ?>
	 			</li>
	 			<?php 
		 		}
		 	} 
		 	?>
		 </ul>
		 <?php
	     }
	    
	    if(isset($search->locations[0]->categories) && count($search->locations[0]->categories) > 0) {
	    	?>
	    	<br />
			<div class="page-header">
				<strong>Categories</strong>
			</div> 
			<ul>
		     <?php   
	     $categories = $search->locations[0]->categories;
		 foreach($categories as $category) {
		 	
		 	//var_dump($category);
		 	
		 	$name_id = $category->name_id;
		 	$name = $category->name;
		 	$parent_id = $category->parent_id;
		 	$parent = $category->parent;
		 	$primary = $category->primary;
		 	
			 ?>
			 <li><?php echo $name;?></li>
		     <?php	 		 	
		 	}
		 	?>
		 	</ul>
		 	<?php
	      }
	    
	    if(isset($search->locations[0]->attributes) && count($search->locations[0]->attributes) > 0) {
	    	
	    	 $IsAtribute = false;
	    	 $attributes = $search->locations[0]->attributes;
	    	 foreach($attributes as $key => $value) {
	    	 	if($value!=''&&is_string($value)) {	
					$IsAtribute = true;
	    	 	}
	    	 }    	
	    	
	    	if($IsAtribute==true) 
	    		{
		    	?>
				<div class="page-header">
					<strong>Attributes</strong>
				</div>    
				<ul>
			     <?php  
		    	 $attributes = $search->locations[0]->attributes;
		    	 foreach($attributes as $key => $value) {
		    	 	if($value!=''&&is_string($value)) {	
						$attribute_id = $value->attribute_id;
						$name = $value->name;
						$value = $value->value;
			 			?><li><?php echo $name;?> = <?php echo $value;?></li><?php 	
		    	 	}
		    	 }
		    	 ?>
		    	 </ul>
		    	 <?php
	    	}
	    }
	    
	    if(isset($search->locations[0]->tips) && count($search->locations[0]->tips) > 0) {
	    	?>
			<div class="page-header">
				<strong>Tips</strong>
			</div>    
			<ul>
		     <?php 
			$tips = $search->locations[0]->tips;
			foreach($tips as $tip){
				$tip_name = $tip->tip_name;
				$tip_text = $tip->tip_text;
				
				?><li><strong><?php echo $tip_name;?></strong> - <?php echo $tip_text;?></li><?php	
				} 
			?>
			</ul>
			<?php
	    	}
	    
	    if(isset($search->locations[0]->images) && count($search->locations[0]->images) > 0) {
	 		$images = $search->locations[0]->images;
	 		if(count($images)>0)
	 			{
	 			?>
				<div class="page-header">
					<strong>Images</strong>
				</div>  
				<center>	 			
	 			<?php
		 		foreach($images as $image){
		 			$type = $image->type;
		 			$height = $image->height;
		 			$width = $image->width;
		 			if($width>200||$width==0){ $width = 200; }
		 			$image_url = $image->image_url;
		 			$primary = $image->primary;
		 			
		 			$attribution_source = $image->attribution_source;
		 			$attribution_logo = $image->attribution_logo;
		 			$attribution_text = $image->attribution_text;
		 			?><img src="<?php echo $image_url;?>" width="<?php echo $width;?>" style="padding: 15px;" /><?php	
		 			} 
		 			?>
		 		</center>
		 		<?php
	 			}
	 			?>
	 			
	 		<?php
	    	}
	    
	    if(isset($search->locations[0]->editorials) && count($search->locations[0]->editorials) > 0) {
	    	?>
			<div class="page-header">
				<strong>Editorials</strong>
			</div>     
			<ul>
		     <?php
		     $editorials = $search->locations[0]->editorials;
		    foreach($editorials as $editorial) {
		     	
		     	//var_dump($editorial);
		     	
		     	$attribution_source = $editorial->attribution_source;
		     	$attribution_logo = $editorial->attribution_logo;
		     	$editorial_review = $editorial->editorial_review;
		     	$editorial_id = $editorial->editorial_id;
		     	$editorial_url = $editorial->editorial_url;
		     	$editorial_title = $editorial->editorial_title;
		     	$editorial_author = $editorial->editorial_author;
		     	
			 	?><li><a href="<?php echo $editorial_url;?>"><strong><?php echo $editorial_title; ?></strong></a> = <?php echo $editorial_review; ?></li><?php
		     	}
		     ?>
		     </ul>
		     <?php
		    }
	    
	    if(isset($search->locations[0]->review_info) && count($search->locations[0]->review_info) > 1) {
	    	
		    $rating = $search->locations[0]->review_info;
		     
			$overall_review_rating = $rating->overall_review_rating;
			$total_user_reviews = $rating->total_user_reviews;
			$total_user_reviews_shown = $rating->total_user_reviews_shown;
			
			$reviews = $rating->reviews;    	
	    	
	    	?>
			<div class="page-header">
				<strong>Reviews (<?php echo $total_user_reviews;?>)</strong>
			</div>  
			<ul>
		     <?php   
		    foreach($reviews as $review) {
		     	
		     	//var_dump($reviews);
		     	
		     	$attribution_source = $review->attribution_source;
		     	$attribution_logo = $review->attribution_logo;
		     	$attribution_text = $review->attribution_text;
		     	$review_id = $review->review_id;
		     	$review_url = $review->review_url;
		     	$review_title = $review->review_title;
		     	$review_author = $review->review_author;
		     	$review_text = $review->review_text;
		     	
			 	?><li><a href="<?php echo $review_url;?>"><strong><?php echo $review_title; ?></strong></a> = <?php echo $review_text; ?></li><?php
		     	}
		     ?>
		     </ul>
		     <?php
		    }	
	     ?>
	     
		<br />
		<?php
		// Only Display Ads if this record allows, otherwise against TOS / Usage Requirements
		if($display_ad==1 && get_option('show_ads') == 'no') 
			{	    
			// Display a Web Ad that is 630 x 100
			$adid = 3;
			$publisher = 'citysearch';
			$citygridad = new citygridads($publishercode);
			?>
			<div id="detail_ad_slot_<?php echo $adid; ?>" align="center"></div>
			<?php
			echo $citygridad->display_web_ad_630_100('detail_ad_slot_'.$adid,$publisher,$what,$where);
			?>
			<br />
			<?php
			}						
		?>		     
		<p align="center"><a href="?page_id=<?php echo $page_id;?>&what=<?php echo $what; ?>" class="btn large primary">Return to Main Page</a></p>
				
		<?php
		}
	else
		{

		// Search
		?>
		
		<strong>
			<a href="#">Places</a> /
			<a href="#"><?php echo $where;?></a> / 
			<?php if($what!='') {?>
				<a href="#"><?php echo $what;?></a>
			<?php } ?>
		</strong>
		
		<br />
		<?php
		// Only Display Ads if this record allows, otherwise against TOS / Usage Requirements
		if(get_option('show_ads') == 'no') 
			{	    
			// Display a Web Ad that is 630 x 100
			$adid = 4;
			$publisher = 'citysearch';
			$citygridad = new citygridads($publishercode);
			?>
			<div id="detail_ad_slot_<?php echo $adid; ?>" align="center"></div>
			<?php
			echo $citygridad->display_web_ad_630_100('detail_ad_slot_'.$adid,$publisher,$what,$where);
			?>
			<br />
			<?php
			}					
		?>
		<center>
		<table cellpadding="2" cellspacing="2" width="90%" border="0">
			<tbody>
			<?php
	
				$placement=null;
				$has_offers=false;
				$histograms=false;
				$i=null;
				$type=null;
				$format='json';
				
				//Get All Active APIs
				$citygrid = new citygridplaces($publishercode);
				$search = $citygrid->srch_places_where($what,$type,$where,$page,$rpp,$sort,$format,$placement,$has_offers,$histograms,$i);
				
				$NumberOfPlaces = count($search);
				
				foreach($search as $place) 
					{
						
			        $total_hits = $place->total_hits;
			        $first_hit = $place->first_hit;
			        $last_hit = $place->last_hit;
			        $page = $place->page;
			        $maxpage = $total_hits / $rpp;
			        $rpp = $place->rpp;;			        
			       
					foreach($place->locations as $location) 
						{
	
						$featured = $location->featured;
						$public_id = $location->public_id;
						$name = $location->name;
						$address = $location->address;
						$street = $address->street;
						$city = $address->city;
						$state = $address->state;
						$postal_code = $address->postal_code;
						$neighborhood = $location->neighborhood;
						$latitude = $location->latitude;
						$longitude = $location->longitude;
						$distance = $location->distance;
						$image = $location->image;
						$phone_number = $location->phone_number;
						$fax_number = $location->fax_number;
						$rating = $location->rating;
						$tagline = $location->tagline;
						$profile = $location->profile;
						$website = $location->website;
						$has_video = $location->has_video;
						$has_offers = $location->has_offers;
						$offers = $location->offers;
						if(isset($location->user_reviews_count))
							{
							$user_reviews_count = $location->user_reviews_count;
							}
						$sample_categories = $location->sample_categories;
						$impression_id = $location->impression_id;
						$expansion  = $location->expansion;
						
				        ?>
						<tr>
							<td align="left">
						        <address>
						            <a href="?page_id=<?php echo $page_id;?>&id=<?php echo $public_id; ?>&what=<?php echo $what; ?>&where=<?php echo $where; ?>" class="btn small primary"><strong><?php echo $name; ?></strong></a><br />
						            <?php echo $street; ?><br />
						            <?php echo $city; ?>, <?php echo $state; ?><br />
						         </address>							
							</td>
							<td align="left" valign="middle" width="15%" style="padding-top: 40px;">
								<br style="padding-top: 15px;" />
								<a href="?page_id=<?php echo $page_id;?>&id=<?php echo $public_id; ?>&what=<?php echo $what; ?>&where=<?php echo $where; ?>" class="btn small primary">View Detail</a>
							</td>
						</tr>				        
				        <?php					
						
						}					
					 } 													
				?>	
			<tbody>
		</table>
		</center>
		<center>
			<table cellpadding="5" cellspacing="5" width="100%">
				<tr>
					<?php
					if($maxpage>15) { $maxpage = 15; }
					?>
					<?php if($maxpage>1){?>
					<td width="25%" align="left" style="text-align:left;">
						<a href="?page_id=<?php echo $page_id;?>&what=<?php echo $what; ?>&page=<?php echo $page-1;?>">&larr; Previous</a>
					</td>
					<?php } ?>
					<?php
					for ( $counter = 1; $counter <= $maxpage; $counter += 1) 
						{
						?>  
						<td style="width: 10px; text-align: center;">	
							<a href="?page_id=<?php echo $page_id;?>&what=<?php echo $what; ?>&page=<?php echo $counter;?>"><?php echo $counter;?></a>
						</td>
						<?php
						}		
					?>
					<?php if(round($page)!=round($maxpage)){?>
						<td width="25%" align="right" style="text-align:right;">
							<a href="?page_id=<?php echo $page_id;?>&what=<?php echo $what; ?>&page=<?php echo $page+1;?>">Next &rarr;</a>
						</td>
					<?php } ?>
					</tr>
			</table>
		</center>	
		
		<br />
		<?php
		// Only Display Ads if this record allows, otherwise against TOS / Usage Requirements
		if(get_option('show_ads') == 'no') 
			{	    
			// Display a Web Ad that is 630 x 100
			$adid = 5;
			$publisher = 'citysearch';
			$citygridad = new citygridads($publishercode);
			?>
			<div id="detail_ad_slot_<?php echo $adid; ?>" align="center"></div>
			<?php
			echo $citygridad->display_web_ad_630_100('detail_ad_slot_'.$adid,$publisher,$what,$where);
			?>
			<br />
			<?php
			}
			
		}
		?>		

	<center>
	<table cellpadding="5" cellspacing="5">
		<tr>
			<td width="175">
			
				<!---CityGrid Attribution-->
				<span style="margin-left: 5px;"><strong>Powered by</strong>&nbsp;&nbsp;&nbsp;</span><br />
				<a href="http://citygrid.com/">
					<img src="http://kinlane-productions.s3.amazonaws.com/citygrid/citygrid_logo.jpg" width="150" />
				</a>
				
			</td>		
			<td width="175">
			
				<!---InfoGroup Attribution-->
				<span style="margin-left: 5px;"><strong>Data from</strong>&nbsp;&nbsp;&nbsp;</span><br />
				<a href="http://www.infogroup.com/">
					<img src="http://kinlane-productions.s3.amazonaws.com/citygrid/infogroup_logo_250.png" width="150" />
				</a>
				
			</td>
			<td valign="middle">
				<!---CopyRight--> 
				<?php 
				$Current_Year = date('Y');
				?>
				<br />
				<span><strong>&copy;&nbsp;<?php echo $Current_Year; ?></strong></span>
		
			</td>			
		</tr>
	</table>
	</center>
	<br />
	</div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>