<?php

namespace Example\Controllers;

use HummNGIN\Core\Http\Request;
use HummNGIN\Core\Http\Response;
use HummNGIN\Util\Forms\Form;
use HummNGIN\Util\Forms\FormBuilder;

class AdminPageController extends DefaultController
{

    public function index(): ?Response
    {
        $pages = $this->pageRepository->getAll("name");
        return $this->render_layout('AdminPageIndex', ['pages' => $pages, 'url' => "/api/v1/page"]);
    }

    public function select(int $id): ?Response
    {
        $page = $this->pageRepository->getOne('id', $id);

        $form = new FormBuilder("/api/v1/page", Request::METHOD_PUT);
        $form->AddField("id", Form::FieldNumber, $page->get('id'));
        $form->AddField("name", Form::FieldText, $page->get('name'));
        $form->AddField("document", Form::FieldTextArea, $page->get('document'));

        return $this->render_layout('AdminFormEdit', $form->GetForm()->Serialize());
    }

    public function insert(): ?Response
    {

        $form = new FormBuilder("/api/v1/page", Request::METHOD_POST);
        $form->AddField("name", Form::FieldText);
        $form->AddField("document", Form::FieldTextArea);

        return $this->render_layout('AdminFormEdit', $form->GetForm()->Serialize());
    }
}