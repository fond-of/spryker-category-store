<?php

namespace FondOfSpryker\Zed\CategoryStore\Communication;

use FondOfSpryker\Zed\Category\Persistence\CategoryQueryContainer;
use FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageDependencyProvider;
use FondOfSpryker\Zed\CategoryStore\CategoryStoreDependencyProvider;
use Spryker\Zed\Category\Persistence\CategoryQueryContainerInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class CategoryStoreCommunicationFactory extends AbstractCommunicationFactory {

    /**
     * @return \Spryker\Zed\Category\Persistence\CategoryQueryContainerInterface
     */
    public function getCategoryQueryContainer(): CategoryQueryContainerInterface
    {
        return new CategoryQueryContainer();
    }

    /**
     * @throws
     *
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    public function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(CategoryStoreDependencyProvider::FACADE_STORE);
    }
}
