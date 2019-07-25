<?php

auth_reauthenticate();

access_ensure_global_level(config_get('manage_plugin_threshold'));
access_ensure_global_level(config_get('edit_threshold_level'));

$f_file = gpc_get_string('file');
$f_file_content = gpc_get_string('file_content');

$t_file = fopen($f_file , "w") or die("Unable to open file for writing");
if (false === $t_file) {
    trigger_error( ERROR_FILE_DISALLOWED, ERROR );
}
$t_bytes = fwrite($t_file, $f_file_content, strlen($f_file_content));
fclose($t_file);

print_successful_redirect(plugin_page('serverfiles', TRUE));
