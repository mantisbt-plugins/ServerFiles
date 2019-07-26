# ServerFiles MantisBT Plugin

[![app-type](https://img.shields.io/badge/category-mantisbt%20plugins-blue.svg)](https://github.com/spmeesseman)
[![app-lang](https://img.shields.io/badge/language-php-blue.svg)](https://github.com/spmeesseman)
[![app-publisher](https://img.shields.io/badge/%20%20%F0%9F%93%A6%F0%9F%9A%80-app--publisher-e10000.svg)](https://github.com/spmeesseman/app-publisher)

[![authors](https://img.shields.io/badge/authors-scott%20meesseman-6F02B5.svg?logo=visual%20studio%20code)](https://github.com/spmeesseman)
[![GitHub issues open](https://img.shields.io/github/issues-raw/spmeesseman/ServerFiles.svg?maxAge=2592000&logo=github)](https://github.com/spmeesseman/ServerFiles/issues)
[![GitHub issues closed](https://img.shields.io/github/issues-closed-raw/spmeesseman/ServerFiles.svg?maxAge=2592000&logo=github)](https://github.com/spmeesseman/ServerFiles/issues)

- [Server Files Editor MantisBT Plugin](#Server-Files-Editor-MantisBT-Plugin)
  - [Description](#Description)
  - [Installation](#Installation)
  - [Screenshots2](#Screenshots2)
    - [Editor Screen](#Editor-Screen)
  - [Future Maybes](#Future-Maybes)

## Description

This plugin allows the user to specify and edit any server file from a new tab in the MantisBT 'Management' section.  An example would be the SVN authz file.

Note the web server must have read access to view the file, and write access to be able to save the file.  Typically in Ubuntu Apache, this user would be `www-data`, for example:

    sudo chown root:www-data /path/to/file
    sudo chmod 770 /path/to/file

## Installation

Extract the release archive to the MantisBT installations plugins folder:

    cd /var/www/mantisbt/plugins
    wget -O ServerFiles.zip https://github.com/spmeesseman/Releases/releases/download/v1.0.0/ServerFiles.zip
    unzip ServerFiles.zip
    rm -f ServerFiles.zip

Ensure to use the latest released version number in the download url.

Install the plugin using the default installation procedure for a MantisBT plugin in `Manage -> Plugins`.

## Screenshots

### Editor Screen

![Editor Page](res/editor.png)

## Future Maybes

- Support for marking a file read-only
- Support for re-ordering display of files
