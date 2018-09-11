<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/11 0011 23:03
 * Email: brximl@163.com
 * Name:
 */

namespace sR;


class Mime
{
    const Name = 'mime.types';
    private static $mimeType;
    /**
     * @return string
     */
    static function getFilename(){
        return __DIR__.'/'. self::Name;
    }

    /**
     * 获取mime 数据类型
     * @param null|string $filename
     * @return array
     */
    static function getMimeTypes($filename=null){
        $mimeTypes = [];
        if((empty($filename) && empty(self::$mimeType)) || ($filename && is_file($filename))){
            $filename = $filename ?? self::getFilename();
            $fp = fopen($filename, 'r');
            while (($buffer = fgets($fp, 4096)) !== false) {
                $buffer = trim($buffer);
                if(empty($buffer) || '#' == substr($buffer, 0, 1)){
                    continue;
                }
                $row = explode(' ', $buffer);
                $newRow = [];
                foreach ($row as $v){
                    $v = trim($v);
                    if($v){
                        $newRow[] = $v;
                    }
                }
                $type = array_shift($newRow);
                $mimeTypes[] = ['type'=> $type, 'ext' => $newRow];
            }
            self::$mimeType = $mimeTypes;
            fclose($fp);
        }
        return $mimeTypes;
    }

    /**
     * 获取mime类型
     * @param string $file
     * @return null|string
     */
    static function mime($file){
        $mime = null;
        $info = pathinfo($file);
        $dick = is_array(self::$mimeType)? self::$mimeType : [];
        if(!empty($dick)){
            $extension = $info['extension'];
            foreach ($dick as $row){
                if(in_array($extension, $row['ext'])){
                    $mime = $row['type'];
                    break;
                }
            }
        }
        return $mime;
    }
}