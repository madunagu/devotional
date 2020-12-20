<?php

namespace App\Traits;

use stdClass;

trait Orderable
{
    public function orderParams(array $params)
    {
        $query = empty($params['q']) ? '' : $params['q'];
        $orderKey = empty($params['o']) ? '' : $params['o'];
        $direction = empty($params['d']) ? '' : $params['d'];

        switch ($orderKey) {
            case 'l':
                $order = 'likes';
                break;
            case 'c':
                $order =  'comments';
                break;
            case 'd':
                $order =  'created_at';
                break;
            case 'v':
                $order =  'views';
                break;

            default:
                $order =  'id';
                break;
        }

        $direction = ($direction == 'u') ? 'ASC' : 'DESC';
        $res = new stdClass();
        $res->query = $query;
        $res->order = $order;
        $res->direction = $direction;
        return $res;
    }
}
