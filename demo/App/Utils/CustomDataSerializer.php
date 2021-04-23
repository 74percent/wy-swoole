<?php

namespace App\Utils;

use League\Fractal\Serializer\ArraySerializer;

class CustomDataSerializer extends ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }
        return $data;
    }

    public function item($resourceKey, array $data)
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }
        return $data;
    }
}
