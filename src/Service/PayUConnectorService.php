<?php

namespace App\Service;

class PayUConnectorService
{
	const ORDER_STATUS_PENDING = 'PENDING';
	const ORDER_STATUS_COMPLETED = 'COMPLETED';
	const ORDER_STATUS_CANCELED = 'CANCELED';

	/**
	 * @var bool
	 */
	private $enabled = false;

	/**
	 * @var string
	 */
	private $env;

	/**
	 * @var string
	 */
	private $merchantPosId;

	/**
	 * @var string
	 */
	private $signatureKey;

	/**
	 * @var string
	 */
	private $oauthClientId;

	/**
	 * @var string
	 */
	private $oauthClientSecret;

	public function __construct(bool $enabled, string $env, string $merchantPosId, string $signatureKey, string $oauthClientId, string $oauthClientSecret)
	{
		$this->enabled = $enabled;
		$this->env = $env;
		$this->merchantPosId = $merchantPosId;
		$this->signatureKey = $signatureKey;
		$this->oauthClientId = $oauthClientId;
		$this->oauthClientSecret = $oauthClientSecret;

		$this->configurePayUAuth();
	}

	private function configurePayUAuth(): void
	{
		if (!$this->enabled) {
			return;
		}

		\OpenPayU_Configuration::setEnvironment($this->env);

		//set POS ID and Second MD5 Key (from merchant admin panel)
		\OpenPayU_Configuration::setMerchantPosId($this->merchantPosId);
		\OpenPayU_Configuration::setSignatureKey($this->signatureKey);

		//set Oauth Client Id and Oauth Client Secret (from merchant admin panel)
		\OpenPayU_Configuration::setOauthClientId($this->oauthClientId);
		\OpenPayU_Configuration::setOauthClientSecret($this->oauthClientSecret);

	}

	public static function getStatuses(): array
	{
		return [
			self::ORDER_STATUS_PENDING => 'adminOrder.orderStatus.pending',
			self::ORDER_STATUS_COMPLETED => 'adminOrder.orderStatus.completed',
			self::ORDER_STATUS_CANCELED => 'adminOrder.orderStatus.canceled',
		];
	}
}