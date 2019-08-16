<?php

# Copyright (c) 2019 Scott Meesseman
# Licensed under GPL3 

class ServerFilesPlugin extends MantisPlugin
{
	function register() {
		$this->name = plugin_lang_get("title");
        $this->description = plugin_lang_get("description");
        $this->page = 'config';

        $this->version = "1.0.8";
        $this->requires = array(
            "MantisCore" => "2.0.0",
        );

        $this->author = "Scott Meesseman";
        $this->contact = "spmeesseman@gmail.com";
        $this->url = "https://github.com/mantisbt-plugins/ServerFiles";
	}

	function config() {
		return array(
			'edit_threshold_level'	=> ADMINISTRATOR ,
			'view_threshold_level'	=> MANAGER
		);
	}

	function hooks() {
		return array(
			'EVENT_MENU_MANAGE' => 'serverfiles_menu',
		);
	}

	function serverfiles_menu() {
		return array(
			'<a href="' . plugin_page( 'serverfiles' ) . '">' . plugin_lang_get( 'editor_title' ) . '</a>',
		);
	}

	function schema() 
    {
        return array(
            array('CreateTableSQL', 
                array( plugin_table('file', 'ServerFiles'), "
                    id                 I       NOTNULL UNSIGNED AUTOINCREMENT PRIMARY,
                    title              C(32)   NOTNULL DEFAULT '',
                    diskfile           C(250)  NOTNULL DEFAULT ''"
                )
            )/*,
            array('AddColumnSQL', 
                array( plugin_table('file', 'ServerFiles'), "
                    order              I       NOTNULL DEFAULT 0",
                    array( "mysql" => "DEFAULT CHARSET=utf8" ) 
                )
            )*/
        );
    }
}
