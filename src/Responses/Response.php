<?php

declare(strict_types=1);

class Response
{
    public static function json(mixed $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        
        $jsonData = self::processData($data);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(500);
            echo json_encode([
                'error' => 'JSON encoding failed: ' . json_last_error_msg()
            ]);
            exit;
        }

        echo $jsonData;
        exit;
    }

    private static function processData(mixed $data): string
    {
        if (is_array($data)) {
            return json_encode(array_map(fn($item) => self::convertToArray($item), $data));
        }
        
        return json_encode(self::convertToArray($data));
    }

    private static function convertToArray(mixed $data): mixed
    {
        if ($data instanceof JsonSerializable) {
            return $data->jsonSerialize();
        }

        if (is_object($data)) {
            // Se o objeto tem um método toArray, use-o
            if (method_exists($data, 'toArray')) {
                return $data->toArray();
            }
            
            // Caso contrário, tente obter todas as propriedades do objeto
            $reflection = new ReflectionClass($data);
            $properties = $reflection->getProperties();
            
            $array = [];
            foreach ($properties as $property) {
                $property->setAccessible(true);
                $array[$property->getName()] = $property->getValue($data);
            }
            
            return $array;
        }

        return $data;
    }

    public static function error(string $message, int $status = 400): never
    {
        self::json(['error' => $message], $status);
    }
}