<?php
/**
 * Plugin Name: Google Safe Search
 *
 * Description: Creates a separate uploads directory for adult content to comply with the Google SafeSearch system.
 *
 * This plugin does not make any permanent changes.
 *
 * Plugin URI: http://blogyul.miqrogroove.com/about/
 * Author URI: http://www.miqrogroove.com/
 *
 * @author: Robert Chapin (miqrogroove)
 * @version: 1.0
 * @copyright Copyright © 2010 by Robert Chapin
 * @license GPL
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
/* Plugin Bootup */

add_action('admin_init', 'miqro_safesearch_init');


/* Plugin Functions */

/**
 * Hooks the media upload system.
 */
function miqro_safesearch_init() {
    define('MIQRO_ADULT_SUBDIR', 'screen'); // The hard-coded default is /wp-content/uploads/screen/yyyy/mm/
    
	add_action('pre-upload-ui', 'miqro_upload_options', 10, 0); // See wp-admin/includes/media.php
    add_action('pre-flash-upload-ui', 'miqro_flash_js', 10, 0);
	add_filter('upload_dir', 'miqro_upload_dir', 10, 1); // See wp-includes/functions.php
}

/**
 * Prefixes the upload subdir value when the expected $_POST value is included
 * with the upload request.
 *
 * @param array $uploads The array provided by wp_upload_dir()
 * @return array
 */
function miqro_upload_dir($uploads) {
	if (isset($_POST['miqro_dir']) and current_user_can('upload_files')) {
        $rawinput = stripslashes($_POST['miqro_dir']);

        if ($rawinput == MIQRO_ADULT_SUBDIR) {
            $folder = '/'.MIQRO_ADULT_SUBDIR.$uploads['subdir'];

            // Filter logic by dd32
        	$uploads['path'] = str_replace($uploads['subdir'], $folder, $uploads['path']);
        	$uploads['url'] = str_replace($uploads['subdir'], $folder, $uploads['url']);
        	$uploads['subdir'] = $folder;

        	// Make sure we have an uploads dir
        	if ( ! wp_mkdir_p( $uploads['path'] ) ) {
        		return array( 'error' => sprintf( __( 'Unable to create directory %s. Is its parent directory writable by the server?' ), $folder ) );
        	}
        }
    }

	return $uploads;
}

/**
 * Adds extra input elements to the media upload form.
 */
function miqro_upload_options() {
    ?>
    <div><?php _e('Upload Content Rating:'); ?><br />
     <label><input type="radio" name="miqro_dir" id="pu_upload-post" value="" checked="checked" /> <strong> Safe for all audiences.</strong></label>
     <label><input type="radio" name="miqro_dir" id="pu_upload-current" value="<?php echo MIQRO_ADULT_SUBDIR; ?>" /> Save it in the /<?php echo MIQRO_ADULT_SUBDIR; ?>/ subdirectory.</label>
    </div>
    <?php
}

/**
 * Adds extra javascript to the Flash uploader to force inclusion of input(s).
 */
function miqro_flash_js() {
	?>
	<script type="text/javascript">
	<!--//--><![CDATA[//><!--
	miqro_old_uploadStart = uploadStart;
	uploadStart = function(obj){
		var pu_upload = false;
		if( jQuery("#pu_upload-post").attr('checked') )
			pu_upload = jQuery("#pu_upload-post").val();

		else if( jQuery("#pu_upload-current").attr('checked') )
			pu_upload = jQuery("#pu_upload-current").val();

		if( pu_upload )
			swfu.addFileParam(obj.id, 'miqro_dir', pu_upload );

        if(typeof miqro_old_uploadStart != 'function') return true;
		return miqro_old_uploadStart(obj);
	}
	//--><!]]>
	</script>
	<?php
}

?>
