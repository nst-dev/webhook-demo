<?php

namespace Modules\App\Services;

use Illuminate\Support\Collection;
use Modules\App\Models\App;

class AppService implements AppServiceInterface
{
    /**
     * Find app by id
     *
     * @param int $id
     * @return App|null
     */
    public function find($id)
    {
        return App::find($id);
    }

    /**
     * Find app by name
     *
     * @param string $name
     * @return App|null
     */
    public function findByName($name)
    {
        return App::query()->where(compact('name'))->first();
    }

    /**
     * Find app by token
     *
     * @param string $token
     * @return App|null
     */
    public function findByToken($token)
    {
        list($id, $secret) = array_pad(explode('-', base64_decode($token), 2), 2, '');

        if (!$id || !$secret) {
            return null;
        }

        return (
            ($app = $this->find($id))
            && $this->generateToken($app) === $token
        ) ? $app : null;
    }

    /**
     * Generate app token
     *
     * @param App $app
     * @return string
     */
    public function generateToken(App $app)
    {
        return base64_encode($app->id . '-' . hash('sha256', $app->secret));
    }

    /**
     * Get list applications
     *
     * @param array $filter
     * @return Collection
     */
    public function lists(array $filter = [])
    {
        $query = App::query();

        if (isset($filter['name'])) {
            $query->where('name', $filter['name']);
        }

        return $query->get();
    }
}