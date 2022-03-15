<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

class ApiEncoder implements EncoderInterface, DecoderInterface
{
    public function decode(string $data, string $format, array $context = [])
    {
        return json_decode($data);
    }

    public function supportsDecoding(string $format): bool
    {
        return 'api' == $format;
    }

    public function encode($data, string $format, array $context = []): string
    {
        $result = [];
        $result['success'] = true;
        if ($context['success']) {
            $result['data'] = $data;
            $result['meta'] = [];
            if (!empty($context['current_page'])) {
                $result['meta']['currentPage'] = $context['current_page'];
            }
            if (!empty($context['per_page'])) {
                $result['meta']['perPage'] = $context['per_page'];
            }
            if (isset($context['total']) && !empty($context['per_page'])) {
                $result['meta']['pagesTotal'] = ceil($context['total'] / $context['per_page']);
            }
        } else {
            $result['success'] = false;
            if (!empty($context['error_message'])) {
                $result['message'] = $context['error_message'];
            }
            if (!empty($context['error_code'])) {
                $result['code'] = $context['error_code'];
            }
            if (!empty($context['error_traceback'])) {
                $result['traceback'] = $context['error_traceback'];
            }
            if (!empty($context['error_file'])) {
                $result['file'] = $context['error_file'];
            }
            if (!empty($context['error_line'])) {
                $result['line'] = $context['error_line'];
            }
        }

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function supportsEncoding(string $format): bool
    {
        return 'api' == $format;
    }
}
