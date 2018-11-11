<?php 
/**
 * 自定义函数
 */

 

/**
 *
 * Notes:简易加密解密的AES方式
 * 建议$ostr的长度位32位字符串
 * 推荐使用 aes_encode aes_decode方法。
 * @param   string     $ostr
 * @param   string    $securekey
 * @param   string   $type   encrypt|decrypt
 *
 * @return string
 */
function aes($ostr, $securekey, $type = 'encrypt')
{
    if ($ostr == '') {
        return '';
    }
    $key = $securekey;
    $iv = @strrev($securekey);
    $td = @mcrypt_module_open('rijndael-256', '', 'ofb', '');
    @mcrypt_generic_init($td, $key, $iv);
    $str = '';
    switch ($type) {
        case 'encrypt':
            $str = @base64_encode(@mcrypt_generic($td, $ostr));
            break;
        case 'decrypt':
            $str = @mdecrypt_generic($td, @base64_decode($ostr));
            break;
    }
    @mcrypt_generic_deinit($td);
    
    return $str;
}
