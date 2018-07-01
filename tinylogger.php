<?php
/**
 * PHP Class for logging in PHP projects.
 *
 * @author Vladislav Borisenko
 * @copyright 2018 Vladislav Borisenko
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 */

class tinylogger
{
    public $config;
    public $dateTime;
    public $data;
    public $file;
    public $ram;
    public $cpu;

    public function __construct()
    {
        $this->config = parse_ini_file('config.ini');
        $this->file = $this->config[path];
    }

    public function convert($size)
    {
        $unit=array('B','KB','MB','GB','TB','PB');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

    public function makelog($message,$messageType='OK',$pattern='debug')
    {

        $data = '';

        $patterns = explode(']',$this->config[$pattern]);

        unset($patterns[count($patterns)-1]);

        foreach($patterns as $key => $value)
        {
            $patterns[$key] = substr($patterns[$key],1);
        }

        if (in_array('dateTime',$patterns)) $dateTime = date($this->config[dateTimestamp], time());
        if (in_array('cpu',$patterns)) $cpu = sys_getloadavg();
        if (in_array('ram',$patterns)) $ram = $this->convert(memory_get_usage());

        $cpu = "CPU: ".$cpu[0]."%";
        $ram = "RAM: ".$ram;

        foreach($patterns as $key => $value)
        {
            if ($patterns[$key] == 'messageType') $data = $data.$messageType.$this->config[splitter];
            else if ($patterns[$key] == 'message') $data = $data.$message.$this->config[splitter];
            else $data = $data.${$patterns[$key]}.$this->config[splitter];
        }
        $data = $data.PHP_EOL;

        file_put_contents($this->file, $data, FILE_APPEND | LOCK_EX);
    }
}