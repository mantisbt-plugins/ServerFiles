<?php
# Mantis - a php based bugtracking system
require_once('core.php');

auth_reauthenticate();
access_ensure_project_level(plugin_config_get('view_threshold_level'));

layout_page_header(plugin_lang_get('serverfiles_title'));
layout_page_begin(__FILE__);
print_manage_menu('ServerFiles/serverfiles');

$first_file = null;
$first_title = null;
$active_file = null;
$active_title = null;

echo '<ul class="nav nav-tabs padding-18" style="margin-top:5px;margin-left:5px;">' . "\n";

$query = 'SELECT title,diskfile FROM ' . plugin_table('file');
$result = db_query($query);
while( $row = db_fetch_array( $result ) ) 
{
    if (!$row){
        trigger_error( ERROR_FILE_NOT_FOUND, ERROR );
    }
    $menu_item = '<a href="' . plugin_page( 'serverfiles' ) . '%3Ffile=' . urlencode($row['diskfile']) . '">' . $row['title']. '</a>';
    $active = (strpos($_SERVER['QUERY_STRING'], urlencode($row['diskfile'])) !== false) || ($first_file == null && strpos($_SERVER['QUERY_STRING'], 'file=') == false) ? ' class="active"' : '';
    echo "<li{$active}>" . $menu_item . '</li>';
    if ($first_file == null) {
        $first_file = $row['diskfile'];
        $first_title = $row['title'];
    }
    if ($active) {
        $active_file = $row['diskfile'];
        $active_title = $row['title'];
    }
}

echo '</ul>' . "\n<br />";

if ($active_file == null) {
    $active_file = $first_file;
    $active_title = $first_title;
}

if ($active_file == null) {
    die('<br><br> &nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;<b>'. plugin_lang_get('no_files_configured').'<b>');
}

$import_page = plugin_page('serverfiles_edit');
$file = fopen($active_file , "r") or die("<br><br> &nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;<b>" . plugin_lang_get('cannot_open') . "</b>");
$file_content = fread($file, filesize($active_file));
fclose($file);

?>

<div class="col-xs-12 col-md-8 col-md-offset-2">
   <div class="space-10"></div>
   <div id="config-div" class="form-container">
      <form method="post" enctype="multipart/form-data" action="<?php echo $import_page ?>">
         <input type="hidden" name="file" value="<?php echo $active_file ?>">
         <div class="widget-box widget-color-blue2">
            <div class="widget-header widget-header-small">
               <h4 class="widget-title lighter">
                  <?php echo $active_file ?>
               </h4>
            </div>
            <div class="widget-body">
               <div class="widget-main no-padding">
                  <div class="form-container">
                     <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-striped">
                           <fieldset>
                              <tr>
                                 <td>
                                    <textarea name="file_content" rows="25" spellcheck="false" style="width:100%" /><?php echo $file_content ?></textarea>
                                 </td>
                              </tr>
                           </fieldset>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="widget-toolbox padding-8 clearfix">
                  <input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get('serverfiles_save_button') ?>" />
               </div>
            </div>
         </div>
      </form>
   </div>
   <div class="space-10"></div>
</div>

<?php
layout_page_end();
