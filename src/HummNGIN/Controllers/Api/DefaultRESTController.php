<?php

namespace HummNGIN\Controllers\Api;

use Error;
use HummNGIN\Controllers\AppController;
use HummNGIN\Core\Http\JSONResponse;
use HummNGIN\Core\Http\Request;
use HummNGIN\Core\Http\Response;
use HummNGIN\Core\Kernel;
use HummNGIN\Repository\DynamicRepository;
use JetBrains\PhpStorm\Pure;

class DefaultRESTController extends AppController implements IRESTController
{
    static string $crud_admin_route = "";
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

    public function post(Request $request): Response
    {
        try {

            $data = $request->JSON()->getContent();

            $id = $this->mainRepository->insertOne($data);

            return new JSONResponse(json_encode(["ok" => "done", "id" => $id, 'item_link' => Kernel::generateUrl(static::$crud_admin_route, ["id" => $id])]), Response::HTTP_OK);
        } catch (Error $e) {
            return new JSONResponse(json_encode(["error" => $e->getMessage()]), Response::HTTP_NOT_ACCEPTABLE);
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

    public function delete(Request $request): Response
    {
        try {

            $id = $request->JSON()->getContent()['id'];

            $this->mainRepository->removeAt($id);

            return new JSONResponse(json_encode(["ok" => "done"]), Response::HTTP_OK);
        } catch (Error $e) {
            return new JSONResponse(json_encode(["error" => $e->getMessage()]), Response::HTTP_NOT_ACCEPTABLE);
        }
    }

}