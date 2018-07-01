Tiny PHP Logger class
=====================

This class can generate log files from your PHP project. Its very lightweight and flexible. You can create your own log display patterns with elementary config file.

Installation:
------
Just clone this repo into your directory. After that you may replace config and class files as you want. Important! Make sure that config.ini and tinylogger.php places in the same directory, otherwise you will need change path to config file. 
```
git clone https://github.com/Borjia/tinylogger.git
cd tinylogger

*replace where you want*
```
Setting:
------
Initially make sure that config.ini and tinylogger.php placed at the same directory, but if you want to place config file in the other place, you should edit 21 line, and instead of config.ini write your path to file.
```php
public function __construct()
{
    $this->config = parse_ini_file('config.ini'); // 21 line
    $this->file = $this->config[path];
}
```
Сonfig.ini file contains configuration elements of this class. There are 2 sections: *general* and *log*. In general section you can edit path to log file if you want (be sure that all directories from path are already created, because tinylogger doesn't create directories). And timestamp parameter [docs](http://php.net/manual/ru/function.date.php).
```
[general]
path = '/var/log/tinylogger/tinylog.log'
dateTimestamp = H.i.s
```
The log section contains patterns witch can be used in your log files as display preset.
```
[log]
splitter = '|'
debug = '[dateTime][message]'
mainLogPattern = '[messageType][dateTime][message][cpu][ram]'
myCustomLogPattern = '[messageType][cpu][ram]'
```
Also you can create your own patterns yourself by combine a few strings in the right order:

- [messageType] - type of message (OK,System,Warning etc.) 
- [message] - text message
- [dateTime] - adds time or date depending on your timestamp configuration
- [cpu] - adds CPU usage statistics (by php)
- [ram] - adds RAM usage statistics (by php)

See following example:
```
myPattern = '[cpu][message]'
```
Usage:
------
First you need to include class to your project:
```php
require '{path}/tinylogger.php';
```
Now you can use tinylogger on your project.

makelog method witch creates a log file, uses 3 variables, but 2 of them optional;
```php
public function makelog($message,$messageType='OK',$pattern='debug')
```
As you can see, defaul valuse of $messageType and $pattern are defined and you can use **makelog** method with only *message* parameter. 

```php
$TL->makelog('Message');
```
See following example:
```php
<?php

require 'tinylogger.php';
$TL = new tinylogger();
$TL->makelog('Message','TYPE','myPattern');

?>
```
Notice:
------
Be sure that directory where you will save your log file must be writable.