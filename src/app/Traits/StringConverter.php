<?php
namespace App\Traits;

trait StringConverter
{
    /**
     * 文字列をbooleanに変換
     *  
     * @param string 変換する文字列
     * @return bool
     */
    public static function toBoolean(string $str): bool
    {
        $lowerString = mb_strtolower($str);
        if (!in_array($lowerString, ['true', 'false'], true)) {
            throw new \InvalidArgumentException('Invalid argument passed');
        }

        return ($lowerString === 'true') ? true : false;
    }
}