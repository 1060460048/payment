<?php
/**
 * @author: helei
 * @createTime: 2016-07-27 15:43
 * @description:
 */

namespace Payment\Trans;


use Payment\Common\Weixin\Data\TransferData;
use Payment\Common\Weixin\WxBaseStrategy;
use Payment\Common\WxConfig;
use Payment\Utils\Curl;

/**
 * 微信企业付款接口
 * Class WxTransfer
 * @package Payment\Trans
 * anthor helei
 */
class WxTransfer extends WxBaseStrategy
{

    protected function getBuildDataClass()
    {
        return TransferData::class;
    }

    /*
     * 返回转款的url
     */
    protected function getReqUrl()
    {
        return WxConfig::TRANSFERS_URL;
    }

    /**
     * 微信退款接口，需要用到相关加密文件及证书，需要重新进行curl的设置
     * @param string $xml
     * @param string $url
     * @return array
     * @author helei
     */
    protected function curlPost($xml, $url)
    {
        $curl = new Curl();
        $responseTxt = $curl->set([
            'CURLOPT_HEADER'    => 0,
            'CURLOPT_SSL_VERIFYHOST'    => false,
            'CURLOPT_SSLCERTTYPE'   => 'PEM', //默认支持的证书的类型，可以注释
            'CURLOPT_SSLCERT'   => $this->config->certPath,
            'CURLOPT_SSLKEY'    => $this->config->keyPath,
            'CURLOPT_CAINFO'    => $this->config->cacertPath,
        ])->post($xml)->submit($url);

        return $responseTxt;
    }
}