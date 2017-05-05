<?php

declare(strict_types=1);

/**
 * @copyright   Copyright (c) 2017 gameeapp.com <hello@gameeapp.com>
 * @author      Pavel Janda <pavel@gameeapp.com>
 * @package     Gamee
 */

namespace Gamee\RabbitMQ\Producer;

use Gamee\RabbitMQ\Connection\Connection;
use Gamee\RabbitMQ\Exchange\Exchange;
use Gamee\RabbitMQ\Queue\Queue;

final class Producer
{

	const DELIVERY_MODE_NON_PERSISTENT = 1;
	const DELIVERY_MODE_PERSISTENT = 2;

	/**
	 * @var Connection
	 */
	private $connection;

	/**
	 * @var Exchange|NULL
	 */
	private $exchange;

	/**
	 * @var Queue|NULL
	 */
	private $queue;

	/**
	 * @var string
	 */
	private $contentType;

	/**
	 * @var string
	 */
	private $deliveryMode;


	public function __construct(
		Connection $connection,
		Exchange $exchange = NULL,
		Queue $queue = NULL,
		string $contentType,
		int $deliveryMode
	) {
		$this->connection = $connection;
		$this->exchange = $exchange;
		$this->queue = $queue;
		$this->contentType = $contentType;
		$this->deliveryMode = $deliveryMode;
	}


	public function publish(string $message): void
	{
		/**
		 * @todo Headers
		 * @todo Routing key
		 */
		$this->connection->getChannel()->publish(
			$message,
			[],
			'',
			$this->exchange ? $this->exchange->getName() : $this->queue->getName()
		);
	}

}