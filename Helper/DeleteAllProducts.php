<?php

namespace Spydemon\CatalogProductDeleteAll\Helper;

use Exception;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;

class DeleteAllProducts
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepositoryInterface;

    /**
     * @var Registry
     */
    protected $regitry;

    public function __construct(
        LoggerInterface $logger,
        ProductCollectionFactory $productCollectionFactory,
        ProductRepositoryInterface $productRepositoryInterface,
        Registry $registry
    ) {
        $this->logger = $logger;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->registry = $registry;
    }

    public function deleteAllProducts() : void
    {
        $this->cleanDatabase();
    }

    protected function cleanDatabase() : void
    {
        $this->logMessageInfo('Start to delete all products in database.');
        $this->registry->register('isSecureArea', true, true);
        $allProductCollection = $this->productCollectionFactory->create();
        foreach ($allProductCollection as $currentProduct) {
            try {
                $this->productRepositoryInterface->delete($currentProduct);
            } catch (StateException $e) {
                $this->logMessageError(
                    "Cannot delete product {$currentProduct->getId()}: {$e->getPrevious()->getMessage()}"
                );
            } catch (Exception $e) {
                $this->logMessageError("Cannot delete product {$currentProduct->getId()}: {$e->getMessage()}");
            }
        }
        $this->registry->register('isSecureArea',false, true);
        $this->logMessageInfo('End delete all products in database.');
    }

    protected function logMessageError(string $message) : void
    {
        $this->logger->error($message);
    }

    protected function logMessageInfo(string $message) :  void
    {
        $this->logger->info($message);
    }
}
