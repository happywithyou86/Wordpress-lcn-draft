<?php
/*
Plugin Name: Udinra Image Sitemap Pro
Plugin URI: https://udinra.com/blog/udinra-image-sitemap
Description: Gives your Images Google Love.
Author: Udinra
Version: 1.0
Author URI: https://udinra.com
Copyright: Udinra.com (Esha Upadhyay)
*/

function UdinraAA_IMS() {

/* Check if the Form Variables are set or not */

if(!isset($_POST['udinra_ping_google'])){
$_POST['udinra_ping_google'] = "";
}
if(!isset($_POST['udinra_ping_bing'])){
$_POST['udinra_ping_bing'] = '';
}
if(!isset($_POST['udinra_ping_ask'])){
$_POST['udinra_ping_ask'] = "";
}
if(!isset($_POST['udinra_gzip'])){
$_POST['udinra_gzip'] = "";
}
if(!isset($_POST['udinra_autogen'])){
$_POST['udinra_autogen'] = "";
}
if(isset($_POST['udinra_img_site'])){
update_option('udinra_ping_google',$_POST['udinra_ping_google']);
update_option('udinra_ping_bing',$_POST['udinra_ping_bing']);
update_option('udinra_ping_ask',$_POST['udinra_ping_ask']);
update_option('udinra_gzip',$_POST['udinra_gzip']);
update_option('udinra_autogen',$_POST['udinra_autogen']);
}
$wp_udinra_ping_google = get_option('udinra_ping_google');
$wp_udinra_ping_bing  = get_option('udinra_ping_bing');
$wp_udinra_ping_ask = get_option('udinra_ping_ask');
$wp_udinra_gzip = get_option('udinra_gzip');
$wp_udinra_autogen = get_option('udinra_autogen');
$udinra_sitemap_response = "";
if(isset($_POST['udinra_img_site'])){
$udinra_sitemap_response = udinra_image_sitemap_loop(); 

/* End of the Section */

}
?>

<!-- Begin the HTML part which is displayed on Settings page of the plugin -->

<div class="wrap">
<h2>Udinra Image Sitemap Pro (Configuration)</h2>
<form method="post" id="UdinraAA_IMS">
<fieldset class="options">
<p><input type="checkbox" id="udinra_autogen" name="udinra_autogen" value="udinra_autogen" <?php if($wp_udinra_autogen == true) { echo('checked="checked"'); } ?> />Include eCommerce plugin product images</p>
<p><input type="checkbox" id="udinra_gzip" name="udinra_gzip" value="udinra_gzip" <?php if($wp_udinra_gzip == true) { echo('checked="checked"'); } ?> />Create gzip file sitemap-image.xml.gz (If Google indexing rate is slow disable this)</p>
<p><input type="checkbox" id="udinra_ping_google" name="udinra_ping_google" value="udinra_ping_google" <?php if($wp_udinra_ping_google == true) { echo('checked="checked"'); } ?> />Ping Search Engines (Recommended)</p>
<p><input type="checkbox" id="udinra_ping_bing" name="udinra_ping_bing" value="udinra_ping_bing" <?php if($wp_udinra_ping_bing == true) { echo('checked="checked"'); } ?> />Support Gallery plugin ( BestWebSoft ) </p>
<p><input type="checkbox" id="udinra_ping_ask" name="udinra_ping_ask" value="udinra_ping_ask" <?php if($wp_udinra_ping_ask == true) { echo('checked="checked"'); } ?> />Generate ALT Text for Images (Recommended)</p>
<p><input type="submit" name="udinra_img_site" value="Save Changes" /></p>
<p><?php echo "Status:"."<br><br>".$udinra_sitemap_response; ?></p>
</fieldset>
</form>
<p>You can report all bugs,feature requests and other queries related to this version of plugin at 
<a href="http://udinra.com/blog/udinra-image-sitemap">Support Forum</a></p>
<table>
<tr><td>
<!--<div id="fb-root"></div>-->
<!--<script>(function(d, s, id) {-->
<!--  var js, fjs = d.getElementsByTagName(s)[0];-->
<!--  if (d.getElementById(id)) return;-->
<!--  js = d.createElement(s); js.id = id;-->
<!--  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=238475612916304";-->
<!--  fjs.parentNode.insertBefore(js, fjs);-->
<!--}(document, 'script', 'facebook-jssdk'));</script>-->
<div class="fb-like-box" data-href="http://www.facebook.com/udinra" data-width="300" data-show-faces="false" data-stream="false" data-header="false"></div>
</td></tr></table>
</div>

<!-- End of the HTML Section. Now mail Logic part will begin -->

<?php

}

function udinra_image_sitemap_loop() {

/* Get values of all the options from database */

$wp_udinra_ping_google = get_option('udinra_ping_google');
$wp_udinra_ping_bing  = get_option('udinra_ping_bing');
$wp_udinra_ping_ask = get_option('udinra_ping_ask');
$wp_udinra_gzip = get_option('udinra_gzip');
$wp_udinra_autogen = get_option('udinra_autogen');
$udinra_img_pluginurl = plugin_dir_url( __FILE__ );

if ( preg_match( '/^https/', $udinra_img_pluginurl ) && !preg_match( '/^https/', get_bloginfo('url') ) )
	$udinra_img_pluginurl = preg_replace( '/^https/', 'http', $udinra_img_pluginurl );

define( 'UDINRA_IMG_FRONT_URL', $udinra_img_pluginurl );

global $wpdb;

$udinra_sql = "SELECT post_title,post_excerpt,post_parent,guid,id	FROM $wpdb->posts
				 			WHERE post_type = 'attachment'
							AND post_mime_type like 'image%'
							AND post_parent > 0
							ORDER BY post_parent,post_date asc";

$udinra_posts = @mysql_query($udinra_sql);

if (empty ($udinra_posts)) {
	return false;

} else {

/* Initialize the Variables and Set the XML part */
	
	$udinra_index_xml   = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
	$udinra_index_xml  .= '<?xml-stylesheet type="text/xsl" href='.'"'. UDINRA_IMG_FRONT_URL . 'xml-index-sitemap.xsl'. '"'.'?>' .PHP_EOL;
	$udinra_index_xml  .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
	$udinra_upload_dir = wp_upload_dir();
	$udinra_cur_post_id= 0;
	$udinra_prev_post_id= 0;		
	$udinra_first_time = 0;
	$udinra_url_count = 0;
	$udinra_sitemap_length = 10000;
	$udinra_is_gallery = 0;
	$udinra_sitemap_count = 0;
	$udinra_index_sitemap_url = ABSPATH . '/sitemap-index-image.xml'; 
	$udinra_date = Date(DATE_W3C);
	
	while ($udinra_post = mysql_fetch_object($udinra_posts)) { 
		if($udinra_url_count == 0)
		{ 
			$udinra_xml_mobile   = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
			$udinra_xml_mobile  .= '<?xml-stylesheet type="text/xsl" href='.'"'. UDINRA_IMG_FRONT_URL . 'xml-image-sitemap.xsl'. '"'.'?>' . PHP_EOL;
			$udinra_xml_mobile  .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . PHP_EOL;
		}
		$udinra_cur_post_id= $udinra_post->post_parent;
		$udinra_is_gallery = 0;
		if (ctype_space($udinra_post->guid) || $udinra_post->guid == '') {
			$udinra_is_gallery = 1;
			$udinra_sql_album = "SELECT ID FROM WP_POSTS WHERE POST_CONTENT LIKE '%[print_gllr id=".$udinra_cur_post_id."]%'";
			$udinra_album_id = @mysql_query($udinra_sql_album);
			$udinra_real_post_id = mysql_fetch_object($udinra_album_id);
			$udinra_cur_post_id= $udinra_real_post_id->ID;
			mysql_free_result($udinra_album_id);
		}
		$udinra_post_type = get_post_type($udinra_cur_post_id); 
		if ($wp_udinra_autogen == true && ($udinra_post_type == 'download' || $udinra_post_type == 'wpsc-product' || $udinra_post_type == 'product' || $udinra_post_type == 'post' || $udinra_post_type == 'page')) { $udinra_gen_sitemap = 1; 	}
		else if ($wp_udinra_autogen == false && ($udinra_post_type == 'post' || $udinra_post_type == 'page' )) { 	$udinra_gen_sitemap = 1; 	}
		else { 	$udinra_gen_sitemap = 0; 	}
		if(get_post_status($udinra_cur_post_id) == 'publish' && $udinra_gen_sitemap == 1) { 
		if($udinra_cur_post_id != 0) {
			if($udinra_cur_post_id != $udinra_prev_post_id) {
				
				if (ctype_space($udinra_post->guid) || $udinra_post->guid == '') {
					$udinra_is_gallery = 1;	
					$udinra_sql_album = "SELECT meta_key,meta_value	
										FROM wp_posts p inner join wp_postmeta pm on p.ID = pm.post_id
										where pm.post_id = ".$udinra_post->id . " and meta_key in ('gllr_image_text','gllr_image_alt_tag','gllr_link_url','_wp_attached_file')";
					$udinra_album_data = @mysql_query($udinra_sql_album);
					while ($udinra_album_row = mysql_fetch_object($udinra_album_data)) { 
						if ($udinra_album_row->meta_key == 'gllr_image_text' ) { $udinra_post->post_title = $udinra_album_row->meta_value; }
						if ($udinra_album_row->meta_key == 'gllr_image_alt_tag' ) { $udinra_post->post_excerpt = $udinra_album_row->meta_value;}
						if ($udinra_album_row->meta_key == 'gllr_link_url' ) { $udinra_post->guid = $udinra_album_row->meta_value; }
						if ($udinra_album_row->meta_key == '_wp_attached_file' ) { $udinra_post->guid = $udinra_upload_dir['baseurl'].'/'.$udinra_album_row->meta_value; }
						
					}
					mysql_free_result($udinra_album_data);
				}
				$udinra_real_post_id= $udinra_cur_post_id;

				$udinra_post_url = get_permalink($udinra_real_post_id); 
								
				if (($wp_udinra_ping_bing == true && $udinra_is_gallery == 1) ||
				    ($wp_udinra_ping_bing == true && $udinra_is_gallery == 0) ||
				    ($wp_udinra_ping_bing == false && $udinra_is_gallery == 0)) {

					if($udinra_first_time == 1) {
						$udinra_xml_mobile .= "\t"."</url>".PHP_EOL; 
						$udinra_first_time = 0;
					}
										
					$udinra_url_count = $udinra_url_count + 1; 
					$udinra_xml_mobile .= "\t"."<url>".PHP_EOL;
					$udinra_xml_mobile .= "\t\t"."<loc>".htmlspecialchars($udinra_post_url)."</loc>".PHP_EOL;
					$udinra_dateTime = get_post_modified_time('c',false,$udinra_real_post_id);
					$udinra_xml_mobile .= "\t\t"."<lastmod>".$udinra_dateTime."</lastmod>".PHP_EOL;

					if ( get_post_type($udinra_real_post_id) == 'page') {
						$udinra_xml_mobile .= "\t\t"."<priority>"."0.8"."</priority>".PHP_EOL;
					}
					if (get_post_type($udinra_real_post_id) == 'post') {
						$udinra_xml_mobile .= "\t\t"."<priority>"."0.6"."</priority>".PHP_EOL;
					}
					if (get_post_type($udinra_real_post_id) == 'product' or  get_post_type($udinra_real_post_id) == 'download' or  get_post_type($udinra_real_post_id) == 'wpsc-product') {
						$udinra_xml_mobile .= "\t\t"."<priority>"."0.75"."</priority>".PHP_EOL;
					}
					
					$udinra_xml_mobile .= "\t\t"."<image:image>".PHP_EOL;
					$udinra_post->post_title = preg_replace("/\.[^$]*/","",$udinra_post->post_title);
					$udinra_xml_mobile .= "\t\t\t"."<image:loc>".htmlspecialchars($udinra_post->guid)."</image:loc>".PHP_EOL;
					if ( ctype_space($udinra_post->post_excerpt) || $udinra_post->post_excerpt == '' ) {
						$udinra_xml_mobile .= "\t\t\t"."<image:caption>".htmlspecialchars($udinra_post->post_title)."</image:caption>".PHP_EOL;
					}
					else {
						$udinra_xml_mobile .= "\t\t\t"."<image:caption>".htmlspecialchars($udinra_post->post_excerpt)."</image:caption>".PHP_EOL;
					}
					$udinra_xml_mobile .= "\t\t\t"."<image:title>".htmlspecialchars($udinra_post->post_title)."</image:title>".PHP_EOL;
					$udinra_xml_mobile .= "\t\t"."</image:image>".PHP_EOL;
					
					$udinra_alt_text_value = get_post_meta($udinra_post->id,'_wp_attachment_image_alt',true);
					if ( ctype_space($udinra_alt_text_value) || $udinra_alt_text_value == '' ) {
						add_post_meta($udinra_post->id,'_wp_attachment_image_alt',$udinra_post->post_title,true);
					}
					
					$udinra_first_time = 1;
					$udinra_prev_post_id = $udinra_cur_post_id;
					}
				}
				else {
					if (ctype_space($udinra_post->guid) || $udinra_post->guid == '') {
						$udinra_is_gallery = 1;
						$udinra_sql_album = "SELECT meta_key,meta_value	
											FROM wp_posts p inner join wp_postmeta pm on p.ID = pm.post_id
											where pm.post_id = ".$udinra_post->id . " and meta_key in
											('gllr_image_text','gllr_image_alt_tag','gllr_link_url','_wp_attached_file')";
						$udinra_album_data = @mysql_query($udinra_sql_album);
						while ($udinra_album_row = mysql_fetch_object($udinra_album_data)) { 
							if ($udinra_album_row->meta_key == 'gllr_image_text' ) { $udinra_post->post_title = $udinra_album_row->meta_value; }
							if ($udinra_album_row->meta_key == 'gllr_image_alt_tag' ) { $udinra_post->post_excerpt = $udinra_album_row->meta_value;}
							if ($udinra_album_row->meta_key == 'gllr_link_url' ) { $udinra_post->guid = $udinra_album_row->meta_value; }
							if ($udinra_album_row->meta_key == '_wp_attached_file' ) { $udinra_post->guid = $udinra_upload_dir['baseurl'].'/'.$udinra_album_row->meta_value;  }
						}
						mysql_free_result($udinra_album_data);
					}
										
				if (($wp_udinra_ping_bing == true && $udinra_is_gallery == 1) ||
				    ($wp_udinra_ping_bing == true && $udinra_is_gallery == 0) ||
				    ($wp_udinra_ping_bing == false && $udinra_is_gallery == 0)) {
											
						$udinra_xml_mobile .= "\t\t"."<image:image>".PHP_EOL;
						$udinra_post->post_title = preg_replace("/\.[^$]*/","",$udinra_post->post_title);
						$udinra_xml_mobile .= "\t\t\t"."<image:loc>".htmlspecialchars($udinra_post->guid)."</image:loc>".PHP_EOL;
						if ( ctype_space($udinra_post->post_excerpt) || $udinra_post->post_excerpt == '' ) {
							$udinra_xml_mobile .= "\t\t\t"."<image:caption>".htmlspecialchars($udinra_post->post_title)."</image:caption>".PHP_EOL;
						}
						else {
							$udinra_xml_mobile .= "\t\t\t"."<image:caption>".htmlspecialchars($udinra_post->post_excerpt)."</image:caption>".PHP_EOL;
						}
						$udinra_xml_mobile .= "\t\t\t"."<image:title>".htmlspecialchars($udinra_post->post_title)."</image:title>".PHP_EOL;
						$udinra_xml_mobile .= "\t\t"."</image:image>".PHP_EOL;
						
						$udinra_alt_text_value = get_post_meta($udinra_post->id,'_wp_attachment_image_alt',true);
						if ( ctype_space($udinra_alt_text_value) || $udinra_alt_text_value == '' ) {
							add_post_meta($udinra_post->id,'_wp_attachment_image_alt',$udinra_post->post_title,true);
							}						
						}
					}
				}	 
			}

	 if ( $udinra_url_count == $udinra_sitemap_length) { 
		$udinra_xml_mobile .= "\t"."</url>".PHP_EOL;
		$udinra_xml_mobile .= "</urlset>"; 
		$udinra_first_time = 0;
		$udinra_sitemap_count = $udinra_sitemap_count + 1;
		$udinra_image_sitemap_url = ABSPATH . '/sitemap-image-'.$udinra_sitemap_count.'.xml'; 
		
		if (UdinraWritable(ABSPATH) || UdinraWritable($udinra_image_sitemap_url)) {
		if (file_put_contents ($udinra_image_sitemap_url, $udinra_xml_mobile)) {
			$udinra_tempurl = get_bloginfo('url').'/sitemap-image-'.$udinra_sitemap_count.'.xml'; 
			if ($wp_udinra_gzip != true) {			
			$udinra_index_xml .="\t"."<sitemap>".PHP_EOL."\t\t"."<loc>".htmlspecialchars($udinra_tempurl)."</loc>".PHP_EOL.
													  "\t\t"."<lastmod>".$udinra_date."</lastmod>".PHP_EOL.
								"\t"."</sitemap>".PHP_EOL;
			}	} 	}

		if ($wp_udinra_gzip == true) {
			$udinra_image_sitemap_url = ABSPATH . '/sitemap-image-'.$udinra_sitemap_count.'.xml.gz'; 
			
			if (UdinraWritable(ABSPATH) || UdinraWritable($udinra_image_sitemap_url)) {
			$udinra_gz = gzopen($udinra_image_sitemap_url,'w9');
			gzwrite($udinra_gz, $udinra_xml_mobile);
			gzclose($udinra_gz);
			$udinra_tempurl = get_bloginfo('url').'/sitemap-image-'.$udinra_sitemap_count.'.xml.gz'; 
			
			$udinra_index_xml .="\t"."<sitemap>".PHP_EOL."\t\t"."<loc>".htmlspecialchars($udinra_tempurl)."</loc>".PHP_EOL.
													  "\t\t"."<lastmod>".$udinra_date."</lastmod>".PHP_EOL.
								"\t"."</sitemap>".PHP_EOL;
			
			} 	} 
		$udinra_url_count = 0;
		$udinra_xml_mobile = '';
	} 
	} 
	
	if ( $udinra_url_count != 0 ) { 
		$udinra_xml_mobile .= "\t"."</url>".PHP_EOL;
		$udinra_xml_mobile .= "</urlset>"; 
		$udinra_sitemap_count = $udinra_sitemap_count + 1;
		$udinra_image_sitemap_url = ABSPATH . '/sitemap-image-'.$udinra_sitemap_count.'.xml'; 
		
		if (
		UdinraWritable(ABSPATH) || UdinraWritable($udinra_image_sitemap_url)) {
		if (file_put_contents ($udinra_image_sitemap_url, $udinra_xml_mobile)) {
			$udinra_tempurl = get_bloginfo('url').'/sitemap-image-'.$udinra_sitemap_count.'.xml'; 
			if ($wp_udinra_gzip != true) {
			$udinra_index_xml .="\t"."<sitemap>".PHP_EOL."\t\t"."<loc>".htmlspecialchars($udinra_tempurl)."</loc>".PHP_EOL.
													  "\t\t"."<lastmod>".$udinra_date."</lastmod>".PHP_EOL.
								"\t"."</sitemap>".PHP_EOL;
			}
			}
		}

		if ($wp_udinra_gzip == true) {
			$udinra_image_sitemap_url = ABSPATH . '/sitemap-image-'.$udinra_sitemap_count.'.xml.gz'; 
			
			if (UdinraWritable(ABSPATH) || UdinraWritable($udinra_image_sitemap_url)) {
			$udinra_gz = gzopen($udinra_image_sitemap_url,'w9');
			gzwrite($udinra_gz, $udinra_xml_mobile);
			gzclose($udinra_gz);
			$udinra_tempurl = get_bloginfo('url'). '/sitemap-image-'.$udinra_sitemap_count.'.xml.gz';
						
			$udinra_index_xml .="\t"."<sitemap>".PHP_EOL."\t\t"."<loc>".htmlspecialchars($udinra_tempurl)."</loc>".PHP_EOL.
													  "\t\t"."<lastmod>".$udinra_date."</lastmod>".PHP_EOL.
								"\t"."</sitemap>".PHP_EOL;
			
			}
		} 
	}
	mysql_free_result($udinra_posts);
	$udinra_index_xml .= "</sitemapindex>";	
	if (UdinraWritable(ABSPATH) || UdinraWritable($udinra_image_sitemap_url)) {
		file_put_contents ($udinra_index_sitemap_url, $udinra_index_xml);
	}
	if ($wp_udinra_ping_google == true) {
		$udinra_ping_url ='';
		$udinra_ping_url = "http://www.google.com/webmasters/tools/ping?sitemap=" . urlencode($udinra_index_sitemap_url);
		$udinra_response = wp_remote_get( $udinra_ping_url );
		if (is_wp_error($udinra_response)) {
		}
		else {
		if($udinra_response['response']['code']==200)
			{ $udinra_sitemap_response .= "Pinged Google Successfully"."<br>"; }
			else { $udinra_sitemap_response .= "Failed to ping Google.Please submit your image sitemap(sitemap-image.xml) at Google Webmaster."."<br>";}}
	
		$udinra_ping_url ='';
		$udinra_ping_url = "http://www.bing.com/webmaster/ping.aspx?sitemap=" . urlencode($udinra_index_sitemap_url);
		$udinra_response = wp_remote_get( $udinra_ping_url );
		if (is_wp_error($udinra_response)) {
		}
		else {
		if($udinra_response['response']['code']==200)
			{ $udinra_sitemap_response .= "Pinged Bing Successfully"."<br>"; }
			else { $udinra_sitemap_response .= "Failed to ping Bing.Please submit your image sitemap(sitemap-image.xml) at Bing Webmaster."."<br>";}}
	
		$udinra_ping_url ='';
		$udinra_ping_url = "http://submissions.ask.com/ping?sitemap=" . urlencode($udinra_index_sitemap_url);
		$udinra_response = wp_remote_get( $udinra_ping_url );
		if (is_wp_error($udinra_response)) {
		}
		else {
		if($udinra_response['response']['code']==200)
			{ $udinra_sitemap_response .= "Pinged Ask.com Successfully"."<br>"; }
			else { $udinra_sitemap_response .= "Failed to ping Ask.com."."<br>"; }}}
		
		}
		
		$udinra_tempurl = get_bloginfo('url'). '/sitemap-index-image.xml'; 
		
		$udinra_sitemap_response .= '<a href='.$udinra_tempurl.' target="_blank" title="Image Sitemap URL">View Image Sitemap</a>'; 
return $udinra_sitemap_response;
}

function udinra_image_sitemap_admin() {
	if (function_exists('add_options_page')) {
	add_options_page('Udinra Image Sitemap', 'Udinra Image Sitemap', 'manage_options', basename(__FILE__), 'UdinraAA_IMS');
	}
}

function UdinraWritable($udinra_filename) {
	if(!is_writable($udinra_filename)) {
		$udinra_sitemap_response = "The file sitemap-image.xml is not writable please check permission of the file for more details visit http://udinra.com/blog/udinra-image-sitemap";
		return false;
	}
	return true;
}

//add_action ('publish_post','udinra_image_sitemap_loop');
//add_action ('publish_page','udinra_image_sitemap_loop');
add_action('admin_menu','udinra_image_sitemap_admin');

function post_unpublished( $new_status, $old_status) {
    if ( $old_status != 'publish'  &&  $new_status == 'publish' ) {
        udinra_image_sitemap_loop();
    }
	if ( $old_status == 'publish'  &&  $new_status == 'publish' ) {
        udinra_image_sitemap_loop();
    }
}
add_action( 'transition_post_status', 'post_unpublished', 20, 2 );


?>
