<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Products extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('Product_model');
    }

    public function before_action()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('login');
            exit;
        }
    }

    public function index()
    {
        $this->call->view('products/index', [
            'title' => 'Products',
            'products' => $this->Product_model->newest(),
            'username' => $this->session->userdata('username'),
        ]);
    }

    public function create()
    {
        $this->call->view('products/form', [
            'title' => 'Add product',
            'product' => null,
            'action' => 'products/create',
            'errors' => [],
        ]);
    }

    public function store()
    {
        $data = $this->product_data();
        $errors = $this->validate_product($data);
        if ($errors) {
            $this->call->view('products/form', ['title' => 'Add product', 'product' => $data, 'action' => 'products/create', 'errors' => $errors]);
            return;
        }

        $this->Product_model->insert($data);
        redirect('products');
        exit;
    }

    public function edit($id)
    {
        $product = $this->Product_model->find((int) $id);
        if (!$product) {
            show_404();
        }

        $this->call->view('products/form', [
            'title' => 'Edit product',
            'product' => $product,
            'action' => 'products/edit/' . (int) $id,
            'errors' => [],
        ]);
    }

    public function update($id)
    {
        $data = $this->product_data();
        $errors = $this->validate_product($data);
        if ($errors) {
            $data['id'] = (int) $id;
            $this->call->view('products/form', ['title' => 'Edit product', 'product' => $data, 'action' => 'products/edit/' . (int) $id, 'errors' => $errors]);
            return;
        }

        $this->Product_model->update((int) $id, $data);
        redirect('products');
        exit;
    }

    public function delete($id)
    {
        $this->Product_model->delete((int) $id);
        redirect('products');
        exit;
    }

    private function product_data()
    {
        return [
            'product_name' => trim((string) $this->request->post('product_name')),
            'description' => trim((string) $this->request->post('description')),
            'price' => (string) $this->request->post('price'),
            'quantity' => (string) $this->request->post('quantity'),
        ];
    }

    private function validate_product($data)
    {
        $errors = [];
        if ($data['product_name'] === '') $errors[] = 'Product name is required.';
        if ($data['price'] === '' || !is_numeric($data['price']) || (float) $data['price'] < 0) $errors[] = 'Enter a valid non-negative price.';
        if ($data['quantity'] === '' || filter_var($data['quantity'], FILTER_VALIDATE_INT) === false || (int) $data['quantity'] < 0) $errors[] = 'Enter a valid non-negative quantity.';
        return $errors;
    }
}