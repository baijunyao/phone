<?php

namespace Baijunyao\Phone;

/**
* 获取手机号归属地
*/
class Phone
{
    public static function find(int $phone)
    {
        $url = 'https://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel='.$phone."&t=".time();
        $gbkStr = file_get_contents($url);
        $utf8Str = iconv("GBK", "UTF-8", $gbkStr);
        $data = preg_replace(["/__GetZoneResult_ = /", "/([a-zA-Z_]+[a-zA-Z0-9_]*)\s*:/", "/:\s*'(.*?)'/"], ['', '"\1":', ': "\1"'], $utf8Str);
        return json_decode($data, true);
    }
}
