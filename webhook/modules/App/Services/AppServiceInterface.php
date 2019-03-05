<?php

namespace Modules\App\Services;

use Illuminate\Support\Collection;
use Modules\App\Models\App;

interface AppServiceInterface
{
    /**
     * Find app by id
     *
     * @param int $id
     * @return App|null
     */
    public function find($id);

    /**
     * Find app by token
     *
     * @param string $token
     * @return App|null
     */
    public function findByToken($token);

    /**
     * Generate app token
     *
     * @param App $app
     * @return string
     */
    public function generateToken(App $app);

    /**
     * Find app by name
     *
     * @param string $name
     * @return App|null
     */
    public function findByName($name);

    /**
     * Get list applications
     *
     * @param array $filter
     * @return Collection
     */
    public function lists(array $filter = []);
}