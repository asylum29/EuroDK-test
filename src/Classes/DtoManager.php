<?php

namespace App\Classes;

//use App\Annotation\DtoParamArrayType;
//use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use ReflectionException;

class DtoManager
{
    /**
     * Заполняет объект Dto полями из массива.
     *
     * @param string $class
     * @param array $fields
     *
     * @return mixed
     *
     * @throws ReflectionException
     */
    public static function fill(string $class, array $fields)
    {
        $dto = new $class();

        $params = [];
        foreach ($fields as $key => $value) {
            $newKey = strtr(ucwords(strtr($key, ['_' => ' '])), [' ' => '']);
            $newKey = mb_strtolower(mb_substr($newKey, 0, 1)).mb_substr($newKey, 1);
            $params[$newKey] = $value;
        }

        $reflection = new ReflectionClass($class);
        $methods = $reflection->getMethods();
        foreach ($methods as $method) {
            $methodName = $method->getName();
            if ('set' == mb_substr($methodName, 0, 3)) {
                $field = mb_substr($methodName, 3);
                $field = mb_strtolower(mb_substr($field, 0, 1)).mb_substr($field, 1);
                if (isset($params[$field])) {
                    if (is_scalar($params[$field])) {
                        $dto->$methodName(trim($params[$field]));
                    } elseif (is_array($params[$field])) { // not need in this project
//                        $reader = new AnnotationReader();
//                        /** @var DtoParamArrayType $annotation */
//                        $annotation = $reader->getMethodAnnotation($method, DtoParamArrayType::class);
//                        if (!empty($annotation)) {
//                            $type = $annotation->type;
//                        }
//                        if (empty($type)) {
//                            $dto->$methodName($params[$field]);
//                        } else {
//                            $array = [];
//                            foreach ($params[$field] as $element) {
//                                $array[] = self::fill($type, $element);
//                            }
//                            $dto->$methodName($array);
//                        }
                    }
                }
            }
        }

        return $dto;
    }
}
