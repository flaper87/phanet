<?php
/**
* Written by Flavio Percoco Premoli, started January 2008.
*            Samuele Santi
*            Francesco Angelo Brisa
*
* Copyright (C) 2008 Flavio Percoco Premoli - http://www.flaper87.org
*
* This file is part of Phanet.
*
* Phanet is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public Licenseur as published by
* the Free Software Foundation, either version 2 of the License, or
* (at your option) any later version.
*
* Foobar is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/
?><?php

// defined('_MODE_') or die('access denied');
@session_start();

$TABLES = array();
// settings
$TABLES['settings']['name']='settings';
$TABLES['settings']['keys']='';
$TABLES['settings']['fields'][]=array( "name"=>"keyid", "type"=>"varchar 32", "null"=>"NOT NULL", "extra"=>"", );
$TABLES['settings']['fields'][]=array( "name"=>"value", "type"=>"varchar 1024", "null"=>"NULL", "extra"=>"", );

$TABLES['settings']['rows'][]=array( "keyid"=>"'sitename'", "value"=>"'Phanet'");
$TABLES['settings']['rows'][]=array( "keyid"=>"'sitedescription'", "value"=>"'Just an aggregator of feeds..'");
$TABLES['settings']['rows'][]=array( "keyid"=>"'default_action'", "value"=>"'display'");
$TABLES['settings']['rows'][]=array( "keyid"=>"'default_theme'", "value"=>"'phanet_dark'");
$TABLES['settings']['rows'][]=array( "keyid"=>"'delete_posts'", "value"=>"'0'");
$TABLES['settings']['rows'][]=array( "keyid"=>"'web_update'", "value"=>"'enabled'");
$TABLES['settings']['rows'][]=array( "keyid"=>"'rewrite_url'", "value"=>"'disabled'");
$TABLES['settings']['rows'][]=array( "keyid"=>"'feed_refresh'", "value"=>"'3600'");// Time to check for new feed
$TABLES['settings']['rows'][]=array( "keyid"=>"'feed_timeout'", "value"=>"'30'");// Timeout time to download a feed
$TABLES['settings']['rows'][]=array( "keyid"=>"'reader_debug'", "value"=>"'disabled'");// echo debug information when loading feeds
$TABLES['settings']['rows'][]=array( "keyid"=>"'widgetizer'", "value"=>"'disabled'");
$TABLES['settings']['rows'][]=array( "keyid"=>"'sidebar_widgets'", "value"=>"'{}'");
$TABLES['settings']['rows'][]=array( "keyid"=>"'dashboard_widgets'", "value"=>"'{(1)[phanetStats](2)[lastLogs](3)[]}'");

// modules
$TABLES['modules']['name']='modules';
$TABLES['modules']['keys']='primary id';
$TABLES['modules']['fields'][]=array( "name"=>"id", "type"=>"int unsigned", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
$TABLES['modules']['fields'][]=array( "name"=>"name", "type"=>"varchar 32", "null"=>"NULL");
$TABLES['modules']['fields'][]=array( "name"=>"path", "type"=>"varchar 64", "null"=>"NOT NULL");
$TABLES['modules']['fields'][]=array( "name"=>"enabled", "type"=>"int unsigned", "null"=>"NOT NULL");
$TABLES['modules']['fields'][]=array( "name"=>"weight", "type"=>"int", "null"=>"NULL");

$TABLES['modules']['rows'][]=array( "id"=>"1", "name"=>"'viewer'", "path"=>"'viewer'", "enabled"=>"1", "weight"=>"-5");
$TABLES['modules']['rows'][]=array( "id"=>"2", "name"=>"'rewrite'", "path"=>"'rewrite'", "enabled"=>"1", "weight"=>"-5");
$TABLES['modules']['rows'][]=array( "id"=>"3", "name"=>"'reader'", "path"=>"'reader'", "enabled"=>"1", "weight"=>"-5");
$TABLES['modules']['rows'][]=array( "id"=>"4", "name"=>"'admin'", "path"=>"'admin'", "enabled"=>"1", "weight"=>"-5");
$TABLES['modules']['rows'][]=array( "id"=>"5", "name"=>"'feed'", "path"=>"'feed'", "enabled"=>"1", "weight"=>"-5");
$TABLES['modules']['rows'][]=array( "id"=>"6", "name"=>"'users'", "path"=>"'users'", "enabled"=>"1", "weight"=>"-5");
$TABLES['modules']['rows'][]=array( "id"=>"7", "name"=>"'pages'", "path"=>"'pages'", "enabled"=>"1", "weight"=>"-5");
$TABLES['modules']['rows'][]=array( "id"=>"8", "name"=>"'search'", "path"=>"'search'", "enabled"=>"1", "weight"=>"-5");
$TABLES['modules']['rows'][]=array( "id"=>"9", "name"=>"'widgets'", "path"=>"'widgets'", "enabled"=>"1", "weight"=>"-5");



// users
$TABLES['users']['name']='users';
$TABLES['users']['keys']='primary id';
$TABLES['users']['fields'][]=array( "name"=>"id", "type"=>"int unsigned", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
$TABLES['users']['fields'][]=array( "name"=>"nickname", "type"=>"varchar 32", "null"=>"NOT NULL");
$TABLES['users']['fields'][]=array( "name"=>"password", "type"=>"varchar 32", "null"=>"NOT NULL");
$TABLES['users']['fields'][]=array( "name"=>"fullname", "type"=>"varchar 255", "null"=>"NOT NULL");
$TABLES['users']['fields'][]=array( "name"=>"email", "type"=>"varchar 32", "null"=>"NULL");
$TABLES['users']['fields'][]=array( "name"=>"website", "type"=>"varchar 64", "null"=>"NULL");
$TABLES['users']['fields'][]=array( "name"=>"author_id", "type"=>"int unsigned", "null"=>"NULL");
$TABLES['users']['fields'][]=array( "name"=>"status", "type"=>"char 1", "null"=>"NULL");// B=BLOCKED
$TABLES['users']['fields'][]=array( "name"=>"usertype", "type"=>"char 1", "null"=>"NULL");// A=ADMIN

// watchdog
$TABLES['watchdog']['name']='watchdog';
$TABLES['watchdog']['keys']='primary wid';
$TABLES['watchdog']['fields'][]=array( "name"=>"wid", "type"=>"int 11", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
$TABLES['watchdog']['fields'][]=array( "name"=>"uid", "type"=>"int 11", "null"=>"NOT NULL");
$TABLES['watchdog']['fields'][]=array( "name"=>"type", "type"=>"varchar 16", "null"=>"NOT NULL");
$TABLES['watchdog']['fields'][]=array( "name"=>"message", "type"=>"longtext", "null"=>"NOT NULL");
$TABLES['watchdog']['fields'][]=array( "name"=>"function", "type"=>"varchar 50", "null"=>"NOT NULL");
$TABLES['watchdog']['fields'][]=array( "name"=>"severity", "type"=>"tinyint 3", "null"=>"NOT NULL");
$TABLES['watchdog']['fields'][]=array( "name"=>"file", "type"=>"varchar 50", "null"=>"NOT NULL");
$TABLES['watchdog']['fields'][]=array( "name"=>"link", "type"=>"varchar 250", "null"=>"NOT NULL");
$TABLES['watchdog']['fields'][]=array( "name"=>"timestamp", "type"=>"int 11", "null"=>"NOT NULL");


// == TABELLE IMMAGAZZINAMENTO DATI ==
// posts
$TABLES['posts']['name']='posts';
$TABLES['posts']['keys']='primary id';
$TABLES['posts']['fields'][]=array( "name"=>"id", "type"=>"int unsigned", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
$TABLES['posts']['fields'][]=array( "name"=>"title", "type"=>"varchar 255", "null"=>"NULL");
$TABLES['posts']['fields'][]=array( "name"=>"text", "type"=>"text", "null"=>"NULL");
$TABLES['posts']['fields'][]=array( "name"=>"date", "type"=>"char 20", "null"=>"NULL");
$TABLES['posts']['fields'][]=array( "name"=>"author", "type"=>"int unsigned", "null"=>"NULL");
$TABLES['posts']['fields'][]=array( "name"=>"blog", "type"=>"int unsigned", "null"=>"NULL");
$TABLES['posts']['fields'][]=array( "name"=>"link", "type"=>"varchar 128", "null"=>"NULL");
$TABLES['posts']['fields'][]=array( "name"=>"tags", "type"=>"varchar 255", "null"=>"NULL");
$TABLES['posts']['fields'][]=array( "name"=>"state", "type"=>"char 8", "null"=>"NOT NULL");

// authors
$TABLES['authors']['name']='authors';
$TABLES['authors']['keys']='primary id';
$TABLES['authors']['fields'][]=array( "name"=>"id", "type"=>"int unsigned", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
$TABLES['authors']['fields'][]=array( "name"=>"nickname", "type"=>"varchar 50", "null"=>"NULL");
$TABLES['authors']['fields'][]=array( "name"=>"email", "type"=>"varchar 32", "null"=>"NULL");
$TABLES['authors']['fields'][]=array( "name"=>"website", "type"=>"varchar 64", "null"=>"NULL");
$TABLES['authors']['fields'][]=array( "name"=>"state", "type"=>"char 8", "null"=>"NULL");
$TABLES['authors']['rows'][]  =array( "id"=>"1", "nickname"=>"'anonymous'", "email"=>"'NONE'", "website"=>"'NONE'", "state"=>"'enabled'");

// blogs
$TABLES['blogs']['name']='blogs';
$TABLES['blogs']['keys']='primary id';
$TABLES['blogs']['fields'][]=array( "name"=>"id", "type"=>"int unsigned", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
$TABLES['blogs']['fields'][]=array( "name"=>"name", "type"=>"varchar 32", "null"=>"NULL");
$TABLES['blogs']['fields'][]=array( "name"=>"description", "type"=>"varchar 128", "null"=>"NULL");
$TABLES['blogs']['fields'][]=array( "name"=>"owner_id", "type"=>"int unsigned", "null"=>"NULL");
$TABLES['blogs']['fields'][]=array( "name"=>"url", "type"=>"varchar 128", "null"=>"NULL");
$TABLES['blogs']['fields'][]=array( "name"=>"feed_url", "type"=>"varchar 128", "null"=>"NULL");
$TABLES['blogs']['fields'][]=array( "name"=>"last_update", "type"=>"char 19", "null"=>"NULL");
$TABLES['blogs']['fields'][]=array( "name"=>"last_post_id", "type"=>"int unsigned", "null"=>"NOT NULL");
$TABLES['blogs']['fields'][]=array( "name"=>"state", "type"=>"char 8", "null"=>"NOT NULL");
$TABLES['blogs']['fields'][]=array( "name"=>"categories", "type"=>"char 250", "null"=>"NOT NULL");
$TABLES['blogs']['fields'][]=array( "name"=>"language", "type"=>"char 2", "null"=>"NOT NULL");


$TABLES['pages']['name']='pages';
$TABLES['pages']['keys']='primary id';
$TABLES['pages']['fields'][]=array( "name"=>"id", "type"=>"int unsigned", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
$TABLES['pages']['fields'][]=array( "name"=>"page_title", "type"=>"varchar 128", "null"=>"NULL");
$TABLES['pages']['fields'][]=array( "name"=>"page_content", "type"=>"text", "null"=>"NULL");
$TABLES['pages']['fields'][]=array( "name"=>"page_date", "type"=>"char 20", "null"=>"NULL");
$TABLES['pages']['fields'][]=array( "name"=>"user_id", "type"=>"int unsigned", "null"=>"NULL");
$TABLES['pages']['fields'][]=array( "name"=>"state", "type"=>"varchar 8", "null"=>"NULL");


/*
$TABLES['blogs']['rows'][]=array( 
    "id"=>"1", 
    "name"=>"'FlaPer87'", 
    "description"=>"'import freedom; print everything'", 
    "owner_id"=>"1", 
    "url"=>"'http://www.flaper87.org'", 
    "feed_url"=>"'http://www.flaper87.org/feed/atom'", 
    "last_update"=>"'2000/01/01 00:00:00'", 
    "last_post_id"=>"0",
    "state"=>"''",
    "categories"=>"':3:'",
    "language"=>"'es'"
);

$TABLES['blogs']['rows'][]=array( "id"=>"2", "name"=>"'Divilinux Lost Blog'", "description"=>"'A new Dharma station'", "owner_id"=>"2", "url"=>"'http://divilinux.netsons.org/'", "feed_url"=>"'http://divilinux.netsons.org/index.php/feed/'", "last_update"=>"'2000/01/01 00:00:00'", "last_post_id"=>"0","state"=>"''","categories"=>"':3:'","language"=>"'it'");

$TABLES['blogs']['rows'][]=array( 
    "id"=>"3", 
    "name"=>"'FlaPer87\'s Gallery'", 
    "description"=>"'FlaPer87\'s Photo Gallery'", 
    "owner_id"=>"1", 
    "url"=>"'http://gallery.flaper87.org/'", 
    "feed_url"=>"'http://gallery.flaper87.org/rss.php'", 
    "last_update"=>"'2000/01/01 00:00:00'", 
    "last_post_id"=>"0",
    "state"=>"''",
    "categories"=>"':2:'",
    "language"=>"'es'"
);*/

// owners
$TABLES['owners']['name']='owners';
$TABLES['owners']['keys']='primary id';
$TABLES['owners']['fields'][]=array( "name"=>"id", "type"=>"int unsigned", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
$TABLES['owners']['fields'][]=array( "name"=>"nickname", "type"=>"varchar 32", "null"=>"NOT NULL");
$TABLES['owners']['fields'][]=array( "name"=>"fullname", "type"=>"varchar 32", "null"=>"NULL");
$TABLES['owners']['fields'][]=array( "name"=>"email", "type"=>"varchar 32", "null"=>"NULL");

/*
$TABLES['owners']['rows'][]=array( "id"=>"1", "nickname"=>"'FlaPer87'", "fullname"=>"'Flavio'", "email"=>"NULL");
$TABLES['owners']['rows'][]=array( "id"=>"2", "nickname"=>"'Divilinux'", "fullname"=>"'Nicola'", "email"=>"NULL");
*/
// categories
$TABLES['categories']['name']='categories';
$TABLES['categories']['keys']='primary id';
$TABLES['categories']['fields'][]=array( "name"=>"id", "type"=>"int unsigned", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
$TABLES['categories']['fields'][]=array( "name"=>"label", "type"=>"varchar 255", "null"=>"NOT NULL");

/*$TABLES['categories']['rows'][]=array( "id"=>"1", "label"=>"'Unclassified'");
$TABLES['categories']['rows'][]=array( "id"=>"2", "label"=>"'Comics'");
$TABLES['categories']['rows'][]=array( "id"=>"3", "label"=>"'GNU/Linux'");*/

// themes
$TABLES['themes']['name']='themes';
$TABLES['themes']['keys']='primary id';
$TABLES['themes']['fields'][]=array( "name"=>"id", "type"=>"int unsigned", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
$TABLES['themes']['fields'][]=array( "name"=>"name", "type"=>"varchar 32", "null"=>"NULL");
$TABLES['themes']['fields'][]=array( "name"=>"path", "type"=>"varchar 64", "null"=>"NOT NULL");
$TABLES['themes']['fields'][]=array( "name"=>"enabled", "type"=>"int unsigned", "null"=>"NOT NULL");

$TABLES['themes']['rows'][]=array( "id"=>"1", "name"=>"'phanet_dark'", "path"=>"'phanet_dark'", "enabled"=>"1");


// actions
$TABLES['actions']['name']='actions';
$TABLES['actions']['keys']='primary id';
$TABLES['actions']['fields'][]=array( "name"=>"id", "type"=>"int unsigned", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
$TABLES['actions']['fields'][]=array( "name"=>"name", "type"=>"varchar 32", "null"=>"NOT NULL");
$TABLES['actions']['fields'][]=array( "name"=>"fname", "type"=>"varchar 32", "null"=>"NULL");

$TABLES['actions']['rows'][]=array( "id"=>"1", "name"=>"'display'", "fname"=>"'viewer_display'");
$TABLES['actions']['rows'][]=array( "id"=>"2", "name"=>"'read'", "fname"=>"'reader_read'");
$TABLES['actions']['rows'][]=array( "id"=>"3", "name"=>"'admin'", "fname"=>"'admin_adminpanel'");
$TABLES['actions']['rows'][]=array( "id"=>"4", "name"=>"'feed'", "fname"=>"'showFeed'");
$TABLES['actions']['rows'][]=array( "id"=>"5", "name"=>"'user'", "fname"=>"'loadUser'");
$TABLES['actions']['rows'][]=array( "id"=>"7", "name"=>"'openSearch'", "fname"=>"'showSearchEngine'");


// tags
$TABLES['tags']['name']='tags';
$TABLES['tags']['keys']='primary id';
$TABLES['tags']['fields'][]=array( "name"=>"id", "type"=>"int unsigned", "null"=>"NOT NULL", "extra"=>"AUTO_INCREMENT");
$TABLES['tags']['fields'][]=array( "name"=>"label", "type"=>"varchar 255", "null"=>"NOT NULL");
    

// languages
$TABLES['languages']['name']='languages';
$TABLES['languages']['keys']='primary id';
$TABLES['languages']['fields'][]=array( "name"=>"id", "type"=>"char 2", "null"=>"NOT NULL");
$TABLES['languages']['fields'][]=array( "name"=>"en_name", "type"=>"varchar 255", "null"=>"NOT NULL");
$TABLES['languages']['fields'][]=array( "name"=>"name", "type"=>"varchar 255", "null"=>"NOT NULL");
/*
$TABLES['languages']['rows'][]=array( 'id'=>"'aa'",'en_name'=>"'Afar'"  ,'name'=>"'Afaraf'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ab'",'en_name'=>"'Abkhazian'"  ,'name'=>"'Аҧсуа'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ae'",'en_name'=>"'Avestan'"  ,'name'=>"'avesta'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'af'",'en_name'=>"'Afrikaans'"  ,'name'=>"'Afrikaans'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ak'",'en_name'=>"'Akan'"  ,'name'=>"'Akan'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'am'",'en_name'=>"'Amharic'"  ,'name'=>"'አማርኛ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'an'",'en_name'=>"'Aragonese'"  ,'name'=>"'Aragonés'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ar'",'en_name'=>"'Arabic'"  ,'name'=>"'‫العربية'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'as'",'en_name'=>"'Assamese'"  ,'name'=>"'অসমীয়া'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'av'",'en_name'=>"'Avaric'"  ,'name'=>"'авар мацӀ; магӀарул мацӀ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ay'",'en_name'=>"'Aymara'"  ,'name'=>"'aymar aru'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'az'",'en_name'=>"'Azerbaijani'"  ,'name'=>"'azərbaycan dili'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ba'",'en_name'=>"'Bashkir'"  ,'name'=>"'башҡорт теле'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'be'",'en_name'=>"'Belarusian'"  ,'name'=>"'Беларуская'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'bg'",'en_name'=>"'Bulgarian'"  ,'name'=>"'български език'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'bh'",'en_name'=>"'Bihari'"  ,'name'=>"'भोजपुरी'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'bi'",'en_name'=>"'Bislama'"  ,'name'=>"'Bislama'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'bm'",'en_name'=>"'Bambara'"  ,'name'=>"'bamanankan'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'bn'",'en_name'=>"'Bengali'"  ,'name'=>"'বাংলা'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'bo'",'en_name'=>"'Tibetan'"  ,'name'=>"'བོད་ཡིག'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'br'",'en_name'=>"'Breton'"  ,'name'=>"'brezhoneg'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'bs'",'en_name'=>"'Bosnian'"  ,'name'=>"'bosanski jezik'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ca'",'en_name'=>"'Catalan'"  ,'name'=>"'Català'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ce'",'en_name'=>"'Chechen'"  ,'name'=>"'нохчийн мотт'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ch'",'en_name'=>"'Chamorro'"  ,'name'=>"'Chamoru'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'co'",'en_name'=>"'Corsican'"  ,'name'=>"'corsu; lingua corsa'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'cr'",'en_name'=>"'Cree'"  ,'name'=>"'ᓀᐦᐃᔭᐍᐏᐣ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'cs'",'en_name'=>"'Czech'"  ,'name'=>"'česky; čeština'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'cu'",'en_name'=>"'Church Slavic'"  ,'name'=>"''"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'cv'",'en_name'=>"'Chuvash'"  ,'name'=>"'чӑваш чӗлхи'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'cy'",'en_name'=>"'Welsh'"  ,'name'=>"'Cymraeg'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'da'",'en_name'=>"'Danish'"  ,'name'=>"'dansk'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'de'",'en_name'=>"'German'"  ,'name'=>"'Deutsch'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'dv'",'en_name'=>"'Divehi'"  ,'name'=>"'‫ދިވެހި'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'dz'",'en_name'=>"'Dzongkha'"  ,'name'=>"'རྫོང་ཁ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ee'",'en_name'=>"'Ewe'"  ,'name'=>"'Ɛʋɛgbɛ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'el'",'en_name'=>"'Greek'"  ,'name'=>"'Ελληνικά'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'en'",'en_name'=>"'English'"  ,'name'=>"'English'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'eo'",'en_name'=>"'Esperanto'"  ,'name'=>"'Esperanto'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'es'",'en_name'=>"'Spanish'"  ,'name'=>"'español; castellano'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'et'",'en_name'=>"'Estonian'"  ,'name'=>"'Eesti keel'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'eu'",'en_name'=>"'Basque'"  ,'name'=>"'euskara'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'fa'",'en_name'=>"'Persian'"  ,'name'=>"'‫فارسی'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ff'",'en_name'=>"'Fulah'"  ,'name'=>"'Fulfulde'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'fi'",'en_name'=>"'Finnish'"  ,'name'=>"'suomen kieli'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'fj'",'en_name'=>"'Fijian'"  ,'name'=>"'vosa Vakaviti'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'fo'",'en_name'=>"'Faroese'"  ,'name'=>"'Føroyskt'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'fr'",'en_name'=>"'French'"  ,'name'=>"'français; langue française'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'fy'",'en_name'=>"'Western Frisian'"  ,'name'=>"'Frysk'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ga'",'en_name'=>"'Irish'"  ,'name'=>"'Gaeilge'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'gd'",'en_name'=>"'Scottish Gaelic'"  ,'name'=>"'Gàidhlig'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'gl'",'en_name'=>"'Galician'"  ,'name'=>"'Galego'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'gn'",'en_name'=>"'Guaraní'"  ,'name'=>"'Avañe'ẽ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'gu'",'en_name'=>"'Gujarati'"  ,'name'=>"'ગુજરાતી'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'gv'",'en_name'=>"'Manx'"  ,'name'=>"'Ghaelg'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ha'",'en_name'=>"'Hausa'"  ,'name'=>"'‫هَوُسَ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'he'",'en_name'=>"'Hebrew'"  ,'name'=>"'‫עברית'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'hi'",'en_name'=>"'Hindi'"  ,'name'=>"'हिन्दी; हिंदी'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ho'",'en_name'=>"'Hiri Motu'"  ,'name'=>"'Hiri Motu'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'hr'",'en_name'=>"'Croatian'"  ,'name'=>"'Hrvatski'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ht'",'en_name'=>"'Haitian'"  ,'name'=>"'Kreyòl ayisyen'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'hu'",'en_name'=>"'Hungarian'"  ,'name'=>"'Magyar'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'hy'",'en_name'=>"'Armenian'"  ,'name'=>"'Հայերեն'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'hz'",'en_name'=>"'Herero'"  ,'name'=>"'Otjiherero'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'id'",'en_name'=>"'Indonesian'"  ,'name'=>"'Bahasa Indonesia'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ie'",'en_name'=>"'Interlingue'"  ,'name'=>"'Interlingue'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ig'",'en_name'=>"'Igbo'"  ,'name'=>"'Igbo'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ii'",'en_name'=>"'Sichuan Yi'"  ,'name'=>"'ꆇꉙ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ik'",'en_name'=>"'Inupiaq'"  ,'name'=>"'Iñupiaq; Iñupiatun'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'io'",'en_name'=>"'Ido'"  ,'name'=>"'Ido'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'is'",'en_name'=>"'Icelandic'"  ,'name'=>"'Íslenska'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'it'",'en_name'=>"'Italian'"  ,'name'=>"'Italiano'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'iu'",'en_name'=>"'Inuktitut'"  ,'name'=>"'ᐃᓄᒃᑎᑐᑦ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ja'",'en_name'=>"'Japanese'"  ,'name'=>"'日本語 (にほんご／にっぽんご)'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'jv'",'en_name'=>"'Javanese'"  ,'name'=>"'basa Jawa'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ka'",'en_name'=>"'Georgian'"  ,'name'=>"'ქართული'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'kg'",'en_name'=>"'Kongo'"  ,'name'=>"'KiKongo'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ki'",'en_name'=>"'Kikuyu'"  ,'name'=>"'Gĩkũyũ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'kj'",'en_name'=>"'Kwanyama'"  ,'name'=>"'Kuanyama'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'kk'",'en_name'=>"'Kazakh'"  ,'name'=>"'Қазақ тілі'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'kl'",'en_name'=>"'Kalaallisut'"  ,'name'=>"'kalaallisut; kalaallit oqaasii'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'km'",'en_name'=>"'Khmer'"  ,'name'=>"'ភាសាខ្មែរ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'kn'",'en_name'=>"'Kannada'"  ,'name'=>"'ಕನ್ನಡ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ko'",'en_name'=>"'Korean'"  ,'name'=>"'한국어 (韓國語); 조선말 (朝鮮語)'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'kr'",'en_name'=>"'Kanuri'"  ,'name'=>"'Kanuri'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ks'",'en_name'=>"'Kashmiri'"  ,'name'=>"'कश्मीरी; كشميري‎'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ku'",'en_name'=>"'Kurdish'"  ,'name'=>"'Kurdî; كوردی‎'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'kv'",'en_name'=>"'Komi'"  ,'name'=>"'коми кыв'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'kw'",'en_name'=>"'Cornish'"  ,'name'=>"'Kernewek'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ky'",'en_name'=>"'Kirghiz'"  ,'name'=>"'кыргыз тили'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'la'",'en_name'=>"'Latin'"  ,'name'=>"'latine; lingua latina'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'lb'",'en_name'=>"'Luxembourgish'"  ,'name'=>"'Lëtzebuergesch'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'lg'",'en_name'=>"'Ganda'"  ,'name'=>"'Luganda'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'li'",'en_name'=>"'Limburgish'"  ,'name'=>"'Limburgs'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ln'",'en_name'=>"'Lingala'"  ,'name'=>"'Lingála'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'lo'",'en_name'=>"'Lao'"  ,'name'=>"'ພາສາລາວ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'lt'",'en_name'=>"'Lithuanian'"  ,'name'=>"'lietuvių kalba'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'lu'",'en_name'=>"'Luba-Katanga'"  ,'name'=>"''"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'lv'",'en_name'=>"'Latvian'"  ,'name'=>"'latviešu valoda'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'mg'",'en_name'=>"'Malagasy'"  ,'name'=>"'Malagasy fiteny'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'mh'",'en_name'=>"'Marshallese'"  ,'name'=>"'Kajin M̧ajeļ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'mi'",'en_name'=>"'Māori'"  ,'name'=>"'te reo Māori'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'mk'",'en_name'=>"'Macedonian'"  ,'name'=>"'македонски јазик'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ml'",'en_name'=>"'Malayalam'"  ,'name'=>"'മലയാളം'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'mn'",'en_name'=>"'Mongolian'"  ,'name'=>"'Монгол'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'mo'",'en_name'=>"'Moldavian'"  ,'name'=>"'лимба молдовеняскэ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'mr'",'en_name'=>"'Marathi'"  ,'name'=>"'मराठी'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ms'",'en_name'=>"'Malay'"  ,'name'=>"'bahasa Melayu; بهاس ملايو‎'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'mt'",'en_name'=>"'Maltese'"  ,'name'=>"'Malti'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'my'",'en_name'=>"'Burmese'"  ,'name'=>"'ဗမာစာ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'na'",'en_name'=>"'Nauru'"  ,'name'=>"'Ekakairũ Naoero'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'nb'",'en_name'=>"'Norwegian Bokmål'"  ,'name'=>"'Norsk bokmål'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'nd'",'en_name'=>"'North Ndebele'"  ,'name'=>"'isiNdebele'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ne'",'en_name'=>"'Nepali'"  ,'name'=>"'नेपाली'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ng'",'en_name'=>"'Ndonga'"  ,'name'=>"'Owambo'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'nl'",'en_name'=>"'Dutch'"  ,'name'=>"'Nederlands'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'nn'",'en_name'=>"'Norwegian Nynorsk'"  ,'name'=>"'Norsk nynorsk'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'no'",'en_name'=>"'Norwegian'"  ,'name'=>"'Norsk'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'nr'",'en_name'=>"'South Ndebele'"  ,'name'=>"'Ndébélé'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'nv'",'en_name'=>"'Navajo'"  ,'name'=>"'Diné bizaad; Dinékʼehǰí'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ny'",'en_name'=>"'Chichewa'"  ,'name'=>"'chiCheŵa; chinyanja'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'oc'",'en_name'=>"'Occitan'"  ,'name'=>"'Occitan'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'oj'",'en_name'=>"'Ojibwa'"  ,'name'=>"'ᐊᓂᔑᓈᐯᒧᐎᓐ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'om'",'en_name'=>"'Oromo'"  ,'name'=>"'Afaan Oromoo'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'or'",'en_name'=>"'Oriya'"  ,'name'=>"'ଓଡ଼ିଆ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'os'",'en_name'=>"'Ossetian'"  ,'name'=>"'Ирон æвзаг'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'pa'",'en_name'=>"'Panjabi'"  ,'name'=>"'ਪੰਜਾਬੀ; پنجابی‎'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'pi'",'en_name'=>"'Pāli'"  ,'name'=>"'पाऴि'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'pl'",'en_name'=>"'Polish'"  ,'name'=>"'polski'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ps'",'en_name'=>"'Pashto'"  ,'name'=>"'‫پښتو'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'pt'",'en_name'=>"'Portuguese'"  ,'name'=>"'Português'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'qu'",'en_name'=>"'Quechua'"  ,'name'=>"'Runa Simi; Kichwa'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'rm'",'en_name'=>"'Raeto-Romance'"  ,'name'=>"'rumantsch grischun'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'rn'",'en_name'=>"'Kirundi'"  ,'name'=>"'kiRundi'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ro'",'en_name'=>"'Romanian'"  ,'name'=>"'română'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ru'",'en_name'=>"'Russian'"  ,'name'=>"'русский язык'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'rw'",'en_name'=>"'Kinyarwanda'"  ,'name'=>"'Kinyarwanda'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sa'",'en_name'=>"'Sanskrit'"  ,'name'=>"'संस्कृतम्'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sc'",'en_name'=>"'Sardinian'"  ,'name'=>"'sardu'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sd'",'en_name'=>"'Sindhi'"  ,'name'=>"'सिन्धी; ‫سنڌي، سندھی‎'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'se'",'en_name'=>"'Northern Sami'"  ,'name'=>"'Davvisámegiella'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sg'",'en_name'=>"'Sango'"  ,'name'=>"'yângâ tî sängö'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sh'",'en_name'=>"'Serbo-Croatian'"  ,'name'=>"'Srpskohrvatski; Српскохрватски'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'si'",'en_name'=>"'Sinhalese'"  ,'name'=>"'සිංහල'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sk'",'en_name'=>"'Slovak'"  ,'name'=>"'slovenčina'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sl'",'en_name'=>"'Slovenian'"  ,'name'=>"'slovenščina'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sm'",'en_name'=>"'Samoan'"  ,'name'=>"'gagana fa'a Samoa'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sn'",'en_name'=>"'Shona'"  ,'name'=>"'chiShona'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'so'",'en_name'=>"'Somali'"  ,'name'=>"'Soomaaliga; af Soomaali'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sq'",'en_name'=>"'Albanian'"  ,'name'=>"'Shqip'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sr'",'en_name'=>"'Serbian'"  ,'name'=>"'српски језик'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ss'",'en_name'=>"'Swati'"  ,'name'=>"'SiSwati'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'st'",'en_name'=>"'Sotho'"  ,'name'=>"'seSotho'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'su'",'en_name'=>"'Sundanese'"  ,'name'=>"'Basa Sunda'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sv'",'en_name'=>"'Swedish'"  ,'name'=>"'Svenska'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'sw'",'en_name'=>"'Swahili'"  ,'name'=>"'Kiswahili'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ta'",'en_name'=>"'Tamil'"  ,'name'=>"'தமிழ்'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'te'",'en_name'=>"'Telugu'"  ,'name'=>"'తెలుగు'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'tg'",'en_name'=>"'Tajik'"  ,'name'=>"'тоҷикӣ; toğikī; ‫تاجیکی‎'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'th'",'en_name'=>"'Thai'"  ,'name'=>"'ไทย'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ti'",'en_name'=>"'Tigrinya'"  ,'name'=>"'ትግርኛ'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'tk'",'en_name'=>"'Turkmen'"  ,'name'=>"'Türkmen; Түркмен'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'tl'",'en_name'=>"'Tagalog'"  ,'name'=>"'Tagalog'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'tn'",'en_name'=>"'Tswana'"  ,'name'=>"'seTswana'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'to'",'en_name'=>"'Tonga'"  ,'name'=>"'faka Tonga'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'tr'",'en_name'=>"'Turkish'"  ,'name'=>"'Türkçe'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ts'",'en_name'=>"'Tsonga'"  ,'name'=>"'xiTsonga'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'tt'",'en_name'=>"'Tatar'"  ,'name'=>"'татарча; tatarça; ‫تاتارچا‎'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'tw'",'en_name'=>"'Twi'"  ,'name'=>"'Twi'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ty'",'en_name'=>"'Tahitian'"  ,'name'=>"'Reo Mā`ohi'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ug'",'en_name'=>"'Uighur'"  ,'name'=>"'Uyƣurqə; ‫ئۇيغۇرچ ‎'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'uk'",'en_name'=>"'Ukrainian'"  ,'name'=>"'Українська'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ur'",'en_name'=>"'Urdu'"  ,'name'=>"'‫اردو'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'uz'",'en_name'=>"'Uzbek'"  ,'name'=>"'O'zbek; Ўзбек; أۇزبېك‎'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'ve'",'en_name'=>"'Venda'"  ,'name'=>"'tshiVenḓa'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'vi'",'en_name'=>"'Vietnamese'"  ,'name'=>"'Tiếng Việt'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'vo'",'en_name'=>"'Volapük'"  ,'name'=>"'Volapük'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'wa'",'en_name'=>"'Walloon'"  ,'name'=>"'Walon'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'wo'",'en_name'=>"'Wolof'"  ,'name'=>"'Wollof'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'xh'",'en_name'=>"'Xhosa'"  ,'name'=>"'isiXhosa'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'yi'",'en_name'=>"'Yiddish'"  ,'name'=>"'‫ייִדיש'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'yo'",'en_name'=>"'Yoruba'"  ,'name'=>"'Yorùbá'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'za'",'en_name'=>"'Zhuang'"  ,'name'=>"'Saɯ cueŋƅ; Saw cuengh'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'zh'",'en_name'=>"'Chinese'"  ,'name'=>"'中文, 汉语, 漢語'"   );
$TABLES['languages']['rows'][]=array( 'id'=>"'zu'",'en_name'=>"'Zulu'"  ,'name'=>"'isiZulu'"   );
*/
