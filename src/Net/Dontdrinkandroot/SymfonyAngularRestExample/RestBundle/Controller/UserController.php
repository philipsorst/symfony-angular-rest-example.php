<?php


namespace Net\Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Net\Dontdrinkandroot\SymfonyAngularRestExample\RestBundle\Model\UserCredentials;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends RestBaseController
{

    /**
     * @Get("")
     *
     * @return Response
     */
    public function listUsersAction()
    {
        $users = $this->getUserService()->listUsers();

        $view = $this->view($users);

        return $this->handleView($view);
    }

    /**
     * @Get("/{id}")
     *
     * @param integer|string $id
     *
     * @return Response
     *
     * @throws \InvalidArgumentException
     */
    public function getUserAction($id)
    {
        if (is_numeric($id)) {
            $user = $this->getUserService()->getUser($id);
        } else {
            if ($id === 'me') {
                $user = $this->getUser();
            } else {
                throw new \InvalidArgumentException("Unknown identifier '$id'. Can be 'me' or an id");
            }
        }

        $view = $this->view($user);

        return $this->handleView($view);
    }

    /**
     * @Post("/createapikey")
     *
     * @param Request $request
     */
    public function createApiKeyAction(Request $request)
    {
        /** @var UserCredentials $credentials */
        $credentials = $this->deserializeJson($request, get_class(new UserCredentials()));
        $apiKey = $this->getUserService()->createApiKey($credentials->getUsername(), $credentials->getPassword());

        $view = $this->view($apiKey, Response::HTTP_CREATED);

        return $this->handleView($view);
    }

    /**
     * @Post("/invalidateapikey")
     *
     * @param Request $request
     */
    public function invalidateApiKeyAction(Request $request)
    {
        //TODO: implement
    }
}