<?php

namespace SwagAdvDevBundle2\Components\Api\Resource;

use Shopware\Components\Api\Exception as ApiException;
use Shopware\Components\Api\Resource\Article;
use Shopware\Components\Api\Resource\Resource;
use SwagAdvDevBundle2\Models\Bundle as BundleModel;

class Bundle extends Resource
{
    /**
     * @param $offset
     * @param $limit
     * @param $filter
     * @param $sort
     *
     * @return array
     */
    public function getList($offset, $limit, $filter, $sort)
    {
        // todo Implement a QueryBuilder to read bundles
        $builder = $this->getBaseQuery();
        $builder->setFirstResult($offset);
        $builder->setMaxResults($limit);

        if(!empty($filter)){
            $builder->addFilter($filter);
        }

        if(!empty($sort)){
            $builder->addOrderBy($sort);
        }
        $query = $builder->getQuery();
        $query->setHydrationMode($this->getResultMode());

        $bundles = $query->execute();

        $paginator = $this->getManager()->createPaginator($query);

        $bundles = $paginator->getIterator()->getArrayCopy();
        $totalResult = $paginator->count();

        // The QueryBuilder should take $offset and $limit into account
        // Return the list as object or array depending on $this->resultMode

        // Additional todo: The QueryBuilder should also be aware of $filter and $sort

        return ['data' => $bundles, 'total' => $totalResult];
    }

    /**
     * @param $id
     *
     * @throws ApiException\NotFoundException
     *
     * @return BundleModel
     */
    public function getOne($id)
    {
        // todo Implement the getOne method
        $builder = $this->getBaseQuery();
        $builder->where('bundle.id = :id')
                ->setParameter('id', $id);

        $bundle = $builder->getQuery()->getOneOrNullResult($this->getResultMode());
        if(!$bundle){
            throw new ApiException\NotFoundException('bundle with id '.$id.' notfound');
        }
        // It should select the bundle with ID $id .
        // If the bundle does not exist, raise the exception ApiException\NotFoundException

        // Return the list as object or array depending on $this->resultMode

        return $bundle;
    }

    /**
     * @param $data
     *
     * @throws ApiException\ValidationException
     *
     * @return BundleModel
     */
    public function create($data)
    {
        $data = $this->prepareBundleData($data);
        // todo Implement the create method
        $bundle = new \SwagAdvDevBundle2\Models\Bundle();
        $bundle->fromArray($data);

        $violations = $this->getManager()->validate($bundle);

        if($violations->count() >= 1){
            throw new ApiException\ValidationException($violations);
        }

        $this->getManager()->persist($bundle);
        $this->getManager()->flush();
        // - You can prepare the data $data using the `prepareBundleData`
        // - Create a bundle model
        // - Populate the bundle model with the `fromArray` method
        // - Save and return the model


        return $bundle;
    }

    /**
     * @param $id
     * @param array $data
     *
     * @throws ApiException\NotFoundException
     * @throws ApiException\ParameterMissingException
     * @throws ApiException\ValidationException
     *
     * @return BundleModel
     */
    public function update($id, array $data)
    {
        if(empty($id)){
            throw new ApiException\ParameterMissingException('Id is missing'.$id);
        }

        $bundle = $this->getManager()->find(BundleModel::class, $id);

        if(!$bundle){
            throw new ApiException\NotFoundException('Bundle with id '.$id.'not found');
        }

        $data = $this->prepareBundleData($data);
        $bundle->fromArray($data);

        $this->getManager()->flush();
        // todo implement the update method
        // - throw ApiException\ParameterMissingException, if $id was not provided
        // - Find the bundle with ID $id
        // - Throw the ApiException\NotFoundException, if not bundle with ID $id exists
        // - Use `prepareBundleData` to prepare the bundle data
        // - Save the changes to the model
        // - return the model

        return $bundle;
    }

    /**
     * @param $id
     *
     * @throws ApiException\NotFoundException
     * @throws ApiException\ParameterMissingException
     */
    public function delete($id)
    {
        if(empty($id)){
            throw new ApiException\ParameterMissingException('Id not found');
        }

        $bundle = $this->getManager()->find(BundleModel::class,$id);
        if(!$bundle){
            throw new ApiException\NotFoundException('Bundle not found');
        }

        $this->getManager()->remove($bundle);
        $this->getManager()->flush();
    }

    /**
     * @param array $data
     *
     * @throws ApiException\NotFoundException
     *
     * @return array
     */
    protected function prepareBundleData(array $data)
    {
        if(!array_key_exists('products', $data)){
            return $data;
        }
        $products = [];
        foreach ($data['products'] as $productId){
            $product = $this->getManager()->find(\Shopware\Models\Article\Article::class, $productId);
            if(!$product){
                throw new ApiException\NotFoundException('Product with id: '.$productId.' not found');
            }

            $products[] = $product;
        }

        $data['products'] = $products;
        // implement the `prepareBundleData` method
        // - the array $data['products'] should contain product entities instead of product IDs
        // - if an ID is missing, throw ApiException\NotFoundException
        // only do that if the array key 'products' exists

        return $data;
    }

    private function getBaseQuery()
    {
        $builder = $this->getManager()->createQueryBuilder();
        $builder->addSelect(['bundle','products'])
            ->from(\SwagAdvDevBundle2\Models\Bundle::class,'bundle')
            ->leftJoin('bundle.products','products');
        return $builder;
    }
}
