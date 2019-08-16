<?php

form_security_validate( 'plugin_ServerFiles_config_edit' );
auth_reauthenticate();

access_ensure_global_level(config_get('manage_plugin_threshold'));
access_ensure_global_level(config_get('edit_threshold_level'));

$f_submit_type = gpc_get_string('submit');
$rows_affected = 0;

if ($f_submit_type == plugin_lang_get('update_config')) 
{
    $f_edit_threshold_level = gpc_get_int('edit_threshold_level');
    $f_view_threshold_level = gpc_get_int('view_threshold_level');
    plugin_config_set('edit_threshold', $f_edit_threshold_level);
    plugin_config_set('view_threshold', $f_view_threshold_level);
    $rows_affected = 2;
}
else if ($f_submit_type == plugin_lang_get('config_new_file')) 
{
    $f_file_diskfile = gpc_get_string('file_diskfile');
    $f_file_title = gpc_get_string('file_title');
    $query = "INSERT INTO " . plugin_table('file') . " (title, diskfile) VALUES (?, ?)";
    $rows = db_query($query, array($f_file_title, $f_file_diskfile));
    $rows_affected = db_num_rows($rows);
}
else if ($f_submit_type == plugin_lang_get('config_save_file')) 
{
    $f_file_diskfile = gpc_get_string('file_diskfile');
    $f_file_title = gpc_get_string('file_title');
    $f_file_title_orig = gpc_get_string('file_title_orig');
    $f_file_diskfile_orig = gpc_get_string('file_diskfile_orig');
    $query = "UPDATE " . plugin_table('file') . " SET title=?, diskfile=? WHERE title=? AND diskfile=?";
    $rows = db_query($query, array($f_file_title, $f_file_diskfile, $f_file_title_orig, $f_file_diskfile_orig));
    $rows_affected = db_num_rows($rows);
}
else if ($f_submit_type == plugin_lang_get('config_delete_file')) 
{
    $f_file_diskfile = gpc_get_string('file_diskfile');
    $f_file_title = gpc_get_string('file_title');
    $f_file_title_orig = gpc_get_string('file_title_orig');
    $f_file_diskfile_orig = gpc_get_string('file_diskfile_orig');
    $query = "DELETE FROM " . plugin_table('file') . " WHERE title=? AND diskfile=?";
    $rows = db_query($query, array($f_file_title_orig, $f_file_diskfile_orig));
    $rows_affected = db_num_rows($rows);
}
else {
    trigger_error('Invalid submit value', ERROR_INVALID_REQUEST_METHOD);
}

if ($rows_affected == 0) {
    trigger_error('Query succeeded but no records affected', ERROR_DB_QUERY_FAILED);
}

form_security_purge( 'plugin_ServerFiles_config_edit' );

$t_redirect_url = plugin_page('config', TRUE);

layout_page_header( null, $t_redirect_url );
layout_page_begin();
html_operation_successful( $t_redirect_url );
layout_page_end();
