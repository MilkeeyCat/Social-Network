<?php

function finalizeData(&$posts)
{
    foreach ($posts as &$post) {
        $post['text'] = mb_substr($post['text'], 0, 160) . '...';
        $post['pub_date'] = date("F j Y", strtotime($post['pub_date']));
        @$post['links'] = json_decode(@$post['links'], true);
        @$post['tags'] = json_decode(@$post['tags'], true);
    }

    return $posts;
}

function beautifyDate(&$data, $pubDateFieldName = 'pub_date')
{
    foreach ($data as &$dataItem) {
        $dataItem[$pubDateFieldName] = date("F j Y", strtotime($dataItem[$pubDateFieldName]));
    }

    return $data;
}

function getAvatarByEmail(&$data, $emailAddressFieldName = 'email')
{
    foreach ($data as &$dataItem) {
        $dataItem['avatar'] = 'http://gravatar.com/avatar/' . md5(strtolower(trim($dataItem[$emailAddressFieldName])));
    }

    return $data;
}

function isAssoc(array $arr)
{
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function sanitizeData(&$data) {
    if(is_array($data) && isAssoc($data)) {
        foreach ($data as $value => &$key) {
            $key = filter_var($key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
    } elseif (is_array($data) && !isAssoc($data)) {
        foreach ($data as $value) {
            $value = filter_var($key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
    }
    else if(is_string($data)) {
        $data = filter_var($key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    } else {
        return $data;
    }
}