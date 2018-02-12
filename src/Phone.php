<?php

namespace Baijunyao\Phone;

/**
* 获取手机号归属地
*/
class Phone
{
    /**
     * 获取手机号服务商以及归属地
     *
     * @param int $phone
     *
     * @return array|mixed
     */
    public static function find(int $phone)
    {
        $url = 'https://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel='.$phone."&t=".time();
        $gbkStr = file_get_contents($url);
        $utf8Str = iconv("GBK", "UTF-8", $gbkStr);
        $jsonStr = preg_replace(["/__GetZoneResult_ = /", "/([a-zA-Z_]+[a-zA-Z0-9_]*)\s*:/", "/:\s*'(.*?)'/"], ['', '"\1":', ': "\1"'], $utf8Str);
        $data = json_decode($jsonStr, true);
        // 如果手机号有误 或者其他情况未查出数据 则全赋值为空
        if (empty($data['province'])) {
            $data = [
                'mts' => '',
                'province' => '',
                'catName' => '',
                'telString' => '',
                'areaVid' => '',
                'ispVid' => '',
                'carrier' => ''
            ];
        }
        return $data;
    }
}
