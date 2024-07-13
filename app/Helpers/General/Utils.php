<?php

namespace App\Helpers\General;

class Utils
{
    static function arrayToKeyValue(array $options) {
        $types = [];
        foreach ($options as $type) {
            $types[$type] = $type;
        }
        return $types;
    }

    static public function keyValueToString(array $array , string $separator) : string {
        $str = '';
        foreach ($array as $key => $value) {
            $str .= $key.','.$value;
            $str .= $separator;
        }
        $str = substr($str, 0, -1);
        return $str;
    }

    static public function stringToKeyValue(string $string, string $separator) : array {
        $explodedString = explode($separator, $string);
        $array = [];
        foreach ($explodedString as $key => $value){
            $value = explode(",", $value);
            $array[$value[0]] = $value[1];
        }
        return $array;
    }

    static function arrayToMatrix(array|null $array, string $value = 'value', string $key = 'key') {
        if (is_null($array)) {
            return null;
        }

        $matrix = [];
        foreach ($array as $k => $v) {
            $arr = [];
            $arr[$key] = $k;
            $arr[$value] = $v;
            $matrix[] = $arr;
        }
        return $matrix;
    }

    static function matrixToArray(array|null $matrix, string $value = 'value', string $key = 'key') {
        if (is_null($matrix)) {
            return null;
        }

        $array = [];
        foreach ($matrix as $v) {
            if (isset($v[$key]))
                $array[$v[$key]] = $v[$value];
            else
                $array[] = $v[$value];
        }
        return $array;
    }


    static function cal($conditions, $value, \Closure $callback): void {
        $operators = ['==', '!=', '>=', '<=', '>', '<'];

        if ($conditions && is_array($conditions)) {
            $flag = false;
            foreach ($conditions as $condition => $result) {
                foreach ($operators as $operator) {
                    $cast = is_numeric($value) ? 'intval' : '';
                    eval("\$flag = ( Str::contains(\$condition, \$operator) && " .$cast."(\$value) ". $operator." ".$cast."(Str::after(\$condition, \$operator)) ); " );
                    if ($flag) {
                        break;
                    }
                }

                if ($flag === true || ($flag === false && $condition == $value))
                    $callback($result, $condition);
            }
        }
    }
}
