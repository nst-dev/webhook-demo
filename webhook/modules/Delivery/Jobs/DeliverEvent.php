<?php

namespace Modules\Delivery\Jobs;

use App\Base\Job;
use Carbon\Carbon;
use Modules\Delivery\Models\Delivery;
use Modules\Delivery\Services\DeliveryStatus;
use Modules\Delivery\Services\Response;
use Modules\Delivery\Services\ResponseInterface;
use Modules\Service;

class DeliverEvent extends Job
{
    /**
     * @var int
     */
    public $deliveryId;

    public $queue = 'delivery';

    /**
     * DeliverEvent constructor
     *
     * @param $deliveryId
     */
    public function __construct($deliveryId)
    {
        $this->deliveryId = $deliveryId;
    }

    /**
     * Handle job
     */
    public function handle()
    {
        if (
            !($delivery = $this->findDelivery($this->deliveryId))
            || !$delivery->webhook
            || !$delivery->event
            || $delivery->status === DeliveryStatus::SUCCESS
        ) {
            return;
        }

        $this->deliver($delivery);
    }

    /**
     * @param int $id
     * @return Delivery|null
     */
    protected function findDelivery($id)
    {
        return Delivery::find($id);
    }

    /**
     * @param Delivery $delivery
     */
    protected function deliver(Delivery $delivery)
    {
        $delivery = $this->markDeliverAsDelivering($delivery);

        $response = Service::delivery()->shipper()->send($delivery);

        $this->updateDeliveryResponse($delivery, $response);

        if ($response->getStatus() === Response::STATUS_SUCCESS) {
            $delivery->update(['status' => DeliveryStatus::SUCCESS]);
            return;
        }

        $delivery->update(['status' => DeliveryStatus::FAILED]);

        $this->release($this->calculateDelay($delivery->attempts));
    }

    /**
     * @param Delivery $delivery
     * @return Delivery
     */
    protected function markDeliverAsDelivering(Delivery $delivery)
    {
        $webhook = $delivery->webhook;
        $requestToken = $this->generateRequestToken($webhook->secret);

        $delivery->update([
            'status' => DeliveryStatus::DELIVERING,
            'attempts' => $delivery->attempts + 1,
            'request_url' => $webhook->payload_url,
            'request_token' => $requestToken,
            'request_time' => Carbon::now(),
        ]);

        return $delivery;
    }

    /**
     * @param string $secret
     * @return null|string
     */
    protected function generateRequestToken($secret)
    {
        return $secret ? hash('sha256', $secret) : null;
    }

    /**
     * @param Delivery $delivery
     * @param ResponseInterface $response
     * @return Delivery
     */
    protected function updateDeliveryResponse(Delivery $delivery, ResponseInterface $response)
    {
        $delivery->update([
            'response_status' => $response->getStatus(),
            'response_body' => $response->getBody(),
        ]);

        return $delivery;
    }

    /**
     * @param int $attempts
     * @return int
     */
    protected function calculateDelay($attempts)
    {
        return $attempts * config('webhook.delay', 60);
    }
}