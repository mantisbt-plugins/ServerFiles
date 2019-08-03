<?php

form_security_validate( 'plugin_ServerFiles_serverfiles_edit' );
auth_reauthenticate();

access_ensure_global_level(config_get('manage_plugin_threshold'));
access_ensure_global_level(config_get('edit_threshold_level'));

$f_file = gpc_get_string('file');
$f_file_content = gpc_get_string('file_content');

#
# Make sure proper OS line endings are used
#
$f_file_content = str_replace("\r\n", PHP_EOL, $f_file_content);

$t_file = fopen($f_file , "w") or die("Unable to open file for writing");
if (false === $t_file) {
    trigger_error( ERROR_FILE_DISALLOWED, ERROR );
}
$t_bytes = fwrite($t_file, $f_file_content, strlen($f_file_content));
fclose($t_file);

form_security_purge( 'plugin_ServerFiles_config_edit' );

$t_redirect_url = plugin_page('serverfiles', TRUE);

layout_page_header( null, $t_redirect_url );
layout_page_begin();
html_operation_successful( $t_redirect_url );
layout_page_end();
