<?php
namespace Breadlesscode\Blog\FlowQuery\Operations;

use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Eel\FlowQuery\Operations\AbstractOperation;
use Neos\Eel\Exception as EelException;

class FilterByCategoriesOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    static protected $shortName = 'filterByCategories';

    /**
     * {@inheritdoc}
     *
     * @param FlowQuery $flowQuery the FlowQuery object
     * @param array $arguments the arguments for this operation
     * @return void
     */
    public function evaluate(FlowQuery $flowQuery, array $arguments)
    {
        if (!is_array($arguments[0])) {
            throw new EelException('The first parameter of '.self::$shortName.' should be an array');
        }
        $context = $flowQuery->getContext();

        $context = \array_filter($context, function ($node) use ($arguments) {
            $categories = $node->getProperty('categories');

            if ($categories === null) {
                return false;
            }
            return count(array_intersect($categories, $arguments[0])) > 0;
        });

        $flowQuery->setContext($context);
    }
}
