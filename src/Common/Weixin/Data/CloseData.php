<?php
/**
 * @author: helei
 * @createTime: 2016-08-03 15:14
 * @description:
 */

namespace Payment\Common\Weixin\Data;

use Payment\Common\PayException;
use Payment\Utils\ArrayUtil;

/**
 * 用户关闭交易
 * @property string $out_trade_no  商户侧传给微信的订单号
 * author biker
 */
class CloseData extends WxBaseData{
    protected function buildData(){
        $this->retData = [
            'appid' => $this->appId,
            'mch_id'    => $this->mchId,
            'out_trade_no' => $this->out_trade_no,
            'nonce_str' => $this->nonceStr,
            'sign_type' =>  $this->signType
        ];
        $this->retData = ArrayUtil::paraFilter($this->retData);
    }

    /**
     * 检查参数
     * @author helei
     */
    protected function checkDataParam(){
        $outTradeNo = $this->out_trade_no;

        // 二者不能同时为空
        if (empty($outTradeNo)) {
            throw new PayException('必须提供商户系统内部订单号');
        }
    }
}
