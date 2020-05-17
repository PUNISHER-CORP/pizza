<?php

namespace App\Service;

use App\Entity\Admin\Dimension;
use App\Entity\Admin\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class CartService
{
    /**
     * @var SessionInterface
     */
    private $sessionStorage;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var Security
     */
    private $security;

		/**
		 * @var string
		 */
    private $currentLanguage;

    public function __construct(SessionInterface $sessionStorage, TranslatorInterface $translator, Security $security)
    {
        $this->sessionStorage = $sessionStorage;
        $this->translator = $translator;
        $this->security = $security;
				$this->currentLanguage = $sessionStorage->get('_locale', 'pl');
    }

    public function getProducts(): array
    {
        $products = $this->sessionStorage->get('cart');
        if (!$products) {
            return [];
        }

        return $products;
    }

    public function addProduct(Product $product, int $quantity, $dimensionId)
    {
        $products = $this->getProducts();
        $dimensionItem = $this->getDimension($product, $dimensionId);

        if(isset($products['products'][$product->getId()])) {
        		if(isset($products['products'][$product->getId()][$dimensionItem['id']])){
								$products['products'][$product->getId()][$dimensionItem['id']]['quantity'] += $quantity;
						} else {
								$products['products'][$product->getId()][$dimensionItem['id']] = [
										'id' => $product->getId(),
										'quantity' => $quantity,
								];
						}
        } else {
						$products['products'][$product->getId()][$dimensionItem['id']] = [
								'id' => $product->getId(),
								'quantity' => $quantity,
								'price' => $dimensionItem['price'],
						];
				}

        $products['quantity'] = 0;

        foreach ($products['products'] as $dimensions) {
						foreach ($dimensions as $dimensionId => $product) {
								$products['quantity'] += $product['quantity'];
						}
        }

        $this->save($products);

        return $products;
    }

    private function getDimension(Product $product, int $dimensionId): array
    {
        $dimensionItem = null;
        $productsDimensions = $product->getProductsDimensions();

        foreach ($productsDimensions as $productsDimension) {
            $dimension = $productsDimension->getDimension();
            if($dimensionId == $dimension->getId()){
                $dimensionItem['id'] = $dimension->getId();
                $dimensionItem['name'] = $dimension->getName();
                $dimensionItem['price'] = $productsDimension->getPrice();
                break;
            }
        }

        return $dimensionItem;
    }

    public function save(array $cart = []): void
    {
        $this->sessionStorage->set('cart', $cart);
    }
}