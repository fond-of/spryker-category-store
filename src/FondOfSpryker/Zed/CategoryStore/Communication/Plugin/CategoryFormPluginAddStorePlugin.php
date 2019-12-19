<?php

namespace FondOfSpryker\Zed\CategoryStore\Communication\Plugin;

use Generated\Shared\Transfer\CategoryTransfer;
use Spryker\Zed\Category\Communication\Form\CategoryType;
use Spryker\Zed\Category\Dependency\Plugin\CategoryFormPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @method \FondOfSpryker\Zed\CategoryStore\Communication\CategoryStoreCommunicationFactory getFactory()
 */
class CategoryFormPluginAddStorePlugin extends AbstractPlugin implements CategoryFormPluginInterface
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder): void
    {
        $categoryQueryContainer = $this->getFactory()->getCategoryQueryContainer();

        $idStore = $this->getFactory()->getStoreFacade()->getCurrentStore()->getIdStore();

        $builder->add(CategoryType::FIELD_CATEGORY_KEY, TextType::class, [
            'constraints' => [
                new NotBlank(),
                new Callback([
                    'callback' => function ($key, ExecutionContextInterface $context) use ($categoryQueryContainer, $idStore) {
                        $data = $context->getRoot()->getData();

                        $exists = false;
                        if ($data instanceof CategoryTransfer) {
                            $exists = $categoryQueryContainer
                                    ->queryCategoryByKey($key)
                                    ->filterByFkStore($idStore)
                                    ->filterByIdCategory($data->getIdCategory(), Criteria::NOT_EQUAL)
                                    ->count() > 0;
                        }

                        if ($exists) {
                            $context->addViolation(sprintf('Category with key "%s" already in use, please choose another one.', $key));
                        }
                    },
                ]),
            ],
        ]);
    }
}
