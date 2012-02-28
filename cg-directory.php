<?php get_header(); ?>

<div id="primary" style="border: 0px solid #000; width: 650px;">
	<div id="content" role="main" style="border: 0px solid #000; width: 640px;">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

			<?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>
		
		
		<?php
		$page_s = explode("</li>",wp_list_pages("title_li=&child_of=$id&show_date=modified&date_format=$date_format&echo=0&depth=1&style=none"));
		$page_n = count($page_s) - 1;
		$page_col = round($page_n / 2);
		for ($i=0;$i<$page_n;$i++){
		 if ($i<$page_col){
		  $page_left = $page_left.''.$page_s[$i].'</li>';
		 }
		 elseif ($i>=$page_col){
		  $page_right = $page_right.''.$page_s[$i].'</li>';
		 }
		}
		?>
		
		<ul style="float:left; width:200px;padding-left:75px;">
		<?php echo $page_left; ?>
		</ul>
		<ul style="float:left; width:200px;padding-left:75px;">
		<?php echo $page_right; ?>
		</ul>		
		

	</div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>