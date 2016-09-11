<?php

//Timezone
date_default_timezone_set('UTC');

//DATABASE CONFIGURATION
define('DB_HOST', '');
define('DB_TYPE', 'mysql');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', '');

define('API_URL', 'https://hacker-news.firebaseio.com/v0/item/{{id}}.json'); //{{id}} is replaced based on what id is passed

define('PROGRAMMING_LANGUAGES', 'php,python,javascript,java,node,c++,c#,ruby,swift,rust,golang,julia,elixir,scala,clojure,
    groovy,objective-c,perl,visual basic,delphi,pascal,assembly,matlab,cobol,dart,lisp,lua,haskell,erlang,vbscript,lisp');
define('FRAMEWORKS', 'rails,django,flask,angular,laravel,symfony,spring,express,codeigniter,ember,flex,cakephp,
    asp.net,backbone,meteor,sails,react,jquery');
define('PACKAGE_MANAGERS', 'bower,vundle,npm,alcatraz,cocoapods,composer,pypa,rubygems,homebrew,dpkg,rpm,joynet,nix,haiku');
define('DATABASES', 'postgres,mysql,mssql,ms sql,sql server,oracle,mongo,sqlite,cassandra,maria,hadoop,hypertable,
accumulo,simpledb,cloudata,informix,splice,concoursedb,druid,kudu,elasticsearch,elastic search,couchbase,couchdb,rethink,nosql,dynamo');
define('JOB_TYPES', 'remote,onsite,on-site,on site,freelance,intern,visa,full-time,full time,part-time,part time');
define('GRAPH_COLORS', '#727272,#f1595f,#79c36a,#599ad3,#f9a65a,#9e66ab,#cd7058,#d77fb3,#282dea,#c0c0c0');


