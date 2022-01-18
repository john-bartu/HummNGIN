<?php

namespace HummNGIN\Controllers\Api;

use Error;
use JetBrains\PhpStorm\Pure;
use HummNGIN\Controllers\DefaultController;
use HummNGIN\Core\Http\JSONResponse;
use HummNGIN\Core\Http\Request;
use HummNGIN\Core\Http\Response;
use HummNGIN\Repository\DynamicRepository;

class DefaultRESTController extends DefaultController implements IRESTController
{
    private DynamicRepository $mainRepository;

    /**
     * @param DynamicRepository $mainRepository
     */
    #[Pure] public function __construct(DynamicRepository $mainRepository)
    {
        parent::__construct();
        $this->mainRepository = $mainRepository;
    }

    public function handle(Request $request): Response
    {
        return match ($request->getMethod()) {
            Request::METHOD_GET => $this->get($request),
            Request::METHOD_POST => $this->post($request),
            Request::METHOD_PUT => $this->put($request),
            Request::METHOD_DELETE => $this->delete($request),
            default => throw new \Error("CRUD don't handle this method " . $request->getMethod(), 404),
        };
    }

    public function get(Request $request): Response
    {
        if (!$request->GET()->has('id'))
            return new JSONResponse(json_encode(["error" => "No id parameter"]), Response::HTTP_BAD_REQUEST);

        $entity = $this->mainRepository->getOne("id", $request->GET()->get('id'));

        if (isset($entity)) {
            return new JSONResponse(json_encode($entity->getVars()));
        } else {
            return new JSONResponse(json_encode(["error" => "object not found in " . $this->mainRepository->tableName()]), Response::HTTP_NOT_FOUND);
        }
    }

    public function put(Request $request): Response
    {
        try {
            $jsonRequest = $request->JSON()->getContent();

            $id = $jsonRequest['id'];
            unset($jsonRequest['id']);
            $update = $jsonRequest;

            $this->mainRepository->updateAt($update, $id);

            return new JSONResponse(json_encode(["ok" => "done"]), Response::HTTP_OK);
        } catch (Error $e) {
            return new JSONResponse(json_encode(["error" => $e->getMessage()]), Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    public function post(Request $request): Response
    {
        // TODO: Implement post() method.
        throw new \Error("Not implemented", 404);
    }

    public function delete(Request $request): Response
    {
        // TODO: Implement delete() method.
        throw new \Error("Not implemented", 404);
    }

}