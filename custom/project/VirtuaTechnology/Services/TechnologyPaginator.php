<?php
namespace VirtuaTechnology\Services;

use Enlight_Controller_Request_RequestHttp;
use Shopware\Components\Routing\Router;

class TechnologyPaginator
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getPaginationData(Enlight_Controller_Request_RequestHttp $request): array
    {
        $perPage = $request->getParam('s',3);
        $pageNumber = $request->getParam('n',1);

        if($pageNumber >1 ){
            $prevPageRoute = $this->router->assemble(
                ['s'=>$perPage, 'n'=>$pageNumber-1]
            );
        }

        $nextPageRoute = $this->router->assemble(
            ['s'=>$perPage, 'n'=>$pageNumber+1]
        );

        $offset = $this->getOffset($perPage,$pageNumber);

        return [
            'perPage'=>$perPage,
            'offset'=> $offset,
            'pageNumber'=>$pageNumber,
            'prevPageUrl'=> $prevPageRoute,
            'nextPageUrl'=> $nextPageRoute
        ];
    }

    private function getOffset($perPage, $pageNumber)
    {
        if($pageNumber <= 1){
            return 0;
        }

        return $perPage*($pageNumber-1);
    }
}
