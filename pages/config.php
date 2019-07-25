<?php
auth_reauthenticate();
access_ensure_global_level(config_get('manage_plugin_threshold'));

layout_page_header(plugin_lang_get('title'));
layout_page_begin(__FILE__);

$edit_threshhold = plugin_config_get('edit_threshold_level');
$view_threshhold = plugin_config_get('view_threshold_level');

?>

<br />

<div class="col-xs-12 col-md-8 col-md-offset-2">
	<div class="space-10"></div>
	<div id="config-div" class="form-container">
		<form id="config-form" method="post" action="<?php echo plugin_page('config_edit') ?>">
			<div class="widget-box widget-color-blue2">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title lighter">
						<i class="ace-icon fa fa-cogs"></i>
						<?php echo plugin_lang_get('title') . ': ' . plugin_lang_get('config') ?>
					</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main no-padding">
						<div class="form-container">
							<div class="table-responsive">
								<table class="table table-bordered table-condensed table-striped">
									<fieldset>
										<tr>
											<td class="category">
												<?php echo lang_get('custom_field_access_level_r') ?>
											</td>
											<td>
												<select name="view_threshold_level">
													<?php print_enum_string_option_list('access_levels', $view_threshhold) ?>
												</select>
											</td>
										</tr>
										<tr>
											<td class="category">
												<?php echo lang_get('custom_field_access_level_rw') ?>
											</td>
											<td>
												<select name="edit_threshold_level">
													<?php print_enum_string_option_list('access_levels', $edit_threshhold) ?>
												</select>
											</td>
										</tr>
									</fieldset>
								</table>

							</div>
						</div>
					</div>

					<div class="widget-toolbox padding-8 clearfix">
						<input type="submit" name="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get('update_config') ?>" />
					</div>
				</div>
			</div>

		</form>
		<br><br>

		<form id="newfile-form" method="post" action="<?php echo plugin_page('config_edit') ?>">
			<div class="widget-box widget-color-blue2">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title lighter">
						<i class="ace-icon fa fa-plus"></i>
						<?php echo plugin_lang_get('title') . ': ' . plugin_lang_get('config_new_file') ?>
					</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main no-padding">
						<div class="form-container">
							<div class="table-responsive">
								<table class="table table-bordered table-condensed table-striped">
									<tr>
										<td class="category">
											<?php echo plugin_lang_get('new_file_title') ?>
										</td>
										<td>
											<input name="file_title" maxlength="30" size="30" value="" />
										</td>
									</tr>
									<tr>
										<td class="category">
											<?php echo plugin_lang_get('new_file_location') ?>
										</td>
										<td>
											<input name="file_diskfile" maxlength="250" size="100" value="" />
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<div class="widget-toolbox padding-8 clearfix">
						<input type="submit" name="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get('config_new_file') ?>" />
					</div>

				</div>
			</div>
		</form>
		<br><br>

		<div class="widget-box widget-color-blue2">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title lighter">
					<i class="ace-icon fa fa-file"></i>
					<?php echo plugin_lang_get('title') . ': ' . plugin_lang_get('config_existing') ?>
				</h4>
			</div>
			<div class="widget-body">
				<div class="widget-main no-padding">
					<div class="form-container">
						<div class="table-responsive">
							<table class="table table-bordered table-condensed table-striped">

								<tr>
									<th><?php echo plugin_lang_get( 'config_file_title' ); ?></th>
									<th><?php echo plugin_lang_get( 'config_file_location' ); ?></th>
									<th><?php echo plugin_lang_get( 'config_file_action' ); ?></th>
								</tr>

								<?php
								$i = 0;
								$query = 'SELECT title,diskfile FROM ' . plugin_table('file');
								$result = db_query($query);
								while( $t_row = db_fetch_array( $result ) ) {
									$i++;
									extract( $t_row, EXTR_PREFIX_ALL, 'v' );
									$v_diskfile = string_display_line( $v_diskfile );
									$v_title = string_display_line( $v_title );
								?>
								<form id="editfile-form-<?php echo $i; ?>" method="post" action="<?php echo plugin_page('config_edit') ?>">
									<tr>
										<input type="hidden" name="file_title_orig" maxlength="30" size="30" value="<?php echo $v_title; ?>" />
										<input type="hidden" name="file_diskfile_orig" maxlength="250" size="60" value="<?php echo $v_diskfile; ?>" />
										<td>
											<input name="file_title" maxlength="30" size="30" value="<?php echo $v_title; ?>" />
										</td>
										<td>
											<input name="file_diskfile" maxlength="250" size="60" value="<?php echo $v_diskfile; ?>" />
										</td>
										<td>
											<span class="pull-right">
											<?php
												if (access_has_global_level( plugin_config_get('edit_threshold_level'))) 
												{
													echo '<input type="submit" name="submit" class="btn btn-primary btn-white btn-round btn-xs" value="' . plugin_lang_get('config_save_file') . '" />';
													echo '&#160;';
													echo '<input type="submit" name="submit" class="btn btn-primary btn-white btn-round btn-xs" value="' . plugin_lang_get('config_delete_file') . '" />';
												}
											?>
											</span>
										</td>
									</tr>
								</form>
								<?php
								} # end for loop

								if ($i == 0)
								{
									echo '<tr><td colspan="2">'. plugin_lang_get('no_files_configured').'</td></tr>';
								}
								?>
							</table>
						</div>
					</div>
				</div>

				<div class="widget-toolbox padding-8 clearfix"></div>
			</div>
		</div>
	</div>
	<div class="space-10"></div>
</div>

<?php
layout_page_end();
