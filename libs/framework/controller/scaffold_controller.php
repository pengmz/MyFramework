<?php

class ScaffoldController extends Controller {
	
	private $model;
	
	public function __construct($table) {
		parent::__construct();
		$this->model = new ScaffoldModel($table);
	}
	
	public function index() {
		$list = $this->model->findAll();
		$this->setAttribute('list', $list);
		return $this->render('_list');
	}

	public function add() {
		$fields = $this->getModelFields();
		$this->setAttribute('fields', $fields);
		return $this->renderForm('_form');
	}

	public function save() {
		$form = $this->getScaffoldForm();
		if ($form && $form->isValid()) {
			$this->model->save($form->data());
		}
		$fields = $this->getModelFields();
		$this->setAttribute('fields', $fields);				
		return $this->redirectToIndex();
	}
	
	public function edit() {
		$id = $this->get('id');
		$obj = $this->model->findById($id);
		$fields = $this->getModelFields();
		$this->setAttribute('fields', $fields);		
		return $this->renderForm('_form', $obj);
	}
	
	public function update() {
		$id = $this->get('id');
		$form = $this->getScaffoldForm();
		if ($id && $form) {
			$this->model->updateById($id, $form->data());
		}		
		$fields = $this->getModelFields();
		$this->setAttribute('fields', $fields);				
		return $this->redirectToIndex();
	}
		
	public function redirectToIndex() {
		return $this->redirect(array('d' => 'index'));
	}
		
	public function getModelFields() {
		return $this->model->getFields();
	}
	
	public function getScaffoldForm() {
		$form_fields = array();
		$fields = $this->getModelFields();
		if (! empty($fields)) {
			foreach ($fields as $field) {
				$form_fields[] = $field->Field;
			}
		}
		return new ScaffoldForm($this->context->request->data(), $form_fields);
	}
	
}
?>