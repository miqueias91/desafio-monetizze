<?php

declare(strict_types=1);

class Cache 
{
    private int $ttl;

    public function __construct(int $ttl = 3600) // 1 hora padrão
    {
        if (!function_exists('apcu_enabled') || !apcu_enabled()) {
            throw new RuntimeException('APCu não está habilitado');
        }
        $this->ttl = $ttl;
    }

    public function remember(string $key, callable $callback)
    {
        $data = apcu_fetch($key, $success);
        
        if ($success) {
            return $data;
        }

        $data = $callback();
        apcu_store($key, $data, $this->ttl);
        
        return $data;
    }

    public function get(string $key)
    {
        return apcu_fetch($key);
    }

    public function set(string $key, $data): bool
    {
        return apcu_store($key, $data, $this->ttl);
    }

    public function forget(string $key): bool
    {
        return apcu_delete($key);
    }

    public function clear(): bool
    {
        return apcu_clear_cache();
    }
}