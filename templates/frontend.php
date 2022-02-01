<?php
namespace CWRemote\Lib\Templates;

use CWRemote\Lib\Storage;
use CWRemote\Lib\Template;

$data = Storage::get_data_array();

// Set the $saved_data['data'] part to $t_data
$t_data = Template::set_data( $data );
?>
<h2><?php _e( $t_data['title'], CWREMOTE_TEXT_DOMAIN ); ?></h2>
<table class="cwremote-table">
	<?php
	// Render table header
	Template::render_table_header( $t_data['data']['headers'] );
	?>
    <tbody>
	<?php if ( empty( $t_data['data']['rows'] ) ): ?>
        <tr>
            <td><?php _e( 'An error occurred while pulling the data. Please contact the administrator.', CWREMOTE_TEXT_DOMAIN ); ?></td>
        </tr>
	<?php else: ?>

		<?php foreach ( $t_data['data']['rows'] as $row ): ?>
            <tr>
				<?php Template::render_row( $row ); ?>
            </tr>
		<?php endforeach; ?>
	<?php endif; ?>
    </tbody>
</table>