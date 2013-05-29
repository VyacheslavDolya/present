
<div id="smartslider_tinymce_dialog">
	<p>Choose a Smarts Slider from the list below to embed in your post:</p>
	<?php if( isset( $smartsliders ) && !empty( $smartsliders ) ): ?>
		<table class="widefat post fixed" cellspacing="0">
			<thead>
				<tr>
					<th class="manage-column column-title" scope="col">Title</th>
					<th width="90" class="manage-column column-date" scope="col">Slides</th>
				</tr>
			</thead>
			<tbody>
				<?php $alternate = 0; ?>
				<?php foreach( (array) $smartsliders as $smartslider ): ?>
					<tr id="smartslider_id_<?php echo $smartslider['id']; ?>" class="author-self status-publish iedit<?php echo ( $alternate & 1 ) ? ' alternate' : ''; ?><?php echo ( $smartslider['dynamic'] == '1' ) ? ' dynamic' : ''; ?>" valign="top">
						<td class="post-title column-title">
							<?php if( $smartslider['dynamic'] == '1' ): ?>
								<img src="<?php echo smartslider_url( '/images/icon_dynamic.png' ); ?>" alt="Dynamic smartslider" />
							<?php endif; ?>
							<?php echo $smartslider['name']; ?>
						</td>
						<td clsss="date column-date"><?php echo $smartslider['slides']; ?></td>
					</tr>
					<?php $alternate++; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
	<div class="message">
		<p><a href="admin.php?page=smartslider.php/slider&task=add">Create a New Smart Slider</a></p>
	</div>
	
</div>
