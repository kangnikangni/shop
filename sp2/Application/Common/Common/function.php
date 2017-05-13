<?php
/**
 * @Author   LaoYang
 * @DateTime 2017-04-14
 * @param    [string]     $string [需要处理的字符串]
 * @return   [string]             [处理完毕的字符串]
 */
function filterXSS($string){
    //相对index.php入口文件，引入HTMLPurifier.auto.php核心文件
    require_once './Public/Admin/htmlpurifier/HTMLPurifier.auto.php';
    // 生成配置对象
    $cfg = HTMLPurifier_Config::createDefault();
    // 以下就是配置：
    $cfg -> set('Core.Encoding', 'UTF-8');
    // 设置允许使用的HTML标签
    $cfg -> set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,br,p[style],span[style],img[width|height|alt|src]');
    // 设置允许出现的CSS样式属性
    $cfg -> set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    // 设置a标签上是否允许使用target="_blank"
    $cfg -> set('HTML.TargetBlank', TRUE);
    // 使用配置生成过滤用的对象
    $obj = new HTMLPurifier($cfg);
    // 过滤字符串
    return $obj -> purify($string);
}

/**
 * @Author   LaoYang
 * @DateTime 2017-04-17
 * @param    [string]     $pwd [需要加密的原始明文密码]
 * @return   [string]          [返回加密的结果的加密密码]
 */
function getPwd($pwd){
    $key = substr(sha1('bjPHPhm03'),9,20);
    $pwd = substr(sha1($pwd),19,20);
    return sha1($key . $pwd);
}