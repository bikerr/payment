<?php
/**
 * Created by PhpStorm.
 * User: biker
 * Date: 2019/6/28
 * Time: 17:18
 */

namespace Payment\Close;
# by biker 2019/6/28 17:18

use Payment\Common\Weixin\Data\CloseData;
use Payment\Common\Weixin\WxBaseStrategy;
use Payment\Common\WxConfig;
use Payment\Config;

class WxClose extends WxBaseStrategy {

    /**
     * 交易关闭接口
     * @var string
     */
    protected $reqUrl = WxConfig::CLOSE_URL;

    public function getBuildDataClass(){
        return CloseData::class;
    }

    protected function retData(array $ret){
        if ($this->config->returnRaw) {
            $ret['channel'] = Config::WX_CLOSE;
            return $ret;
        }

        // 请求失败，可能是网络
        if ($ret['return_code'] != 'SUCCESS') {
            return $retData = [
                'is_success'    => 'F',
                'error' => $ret['return_msg']
            ];
        }

        // 业务失败
        if ($ret['result_code'] != 'SUCCESS') {
            return $retData = [
                'is_success'    => 'F',
                'error' => $ret['err_code_des']
            ];
        }
        return $this->createBackData($ret);
    }

    protected function createBackData(array $data){
        $retData = [
            'is_success'    => 'T',
            'response'  => [
                'transaction_id'   => $data['transaction_id'],
                'order_no'  => $data['out_trade_no'],
                'channel'   => Config::WX_CLOSE,
            ],
        ];
        return $retData;
    }
}