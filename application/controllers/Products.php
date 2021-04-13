<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller{
    public function index(){
        $this->load->model("Product");
		$this->Product->checkCart(); // Create a cart if there is none
		$countCart = $this->Product->countCart($this->session->userdata("cart_id")); // Count products in the cart
        $products = array("result" => $this->Product->getProducts()); // Get all products
		$data = array(
			"cart" => $countCart,
			"products" => $products
		);
        $this->load->view("index", $data);
    }

	public function buy($product_id){
		$this->form_validation->set_rules("quantity", "quantity", "trim|required");
		$this->form_validation->set_message("required", "%s can't be empty");

		if($this->form_validation->run() == FALSE){
			$this->session->set_userdata("error", form_error("quantity"));
			redirect(base_url());
		}
		else{
			$form_array = array(
				"cart_id" => $this->session->userdata("cart_id"),
				"product_id" => $product_id,
				"quantity" => $this->input->post("quantity")
			);
	
			$this->load->model("Product");
			$buy = $this->Product->addToCart($form_array);
	
			if($buy){
				redirect(base_url());
			}
		}
	}

	public function delete($id){
		$this->load->model("Product");
		$delete = $this->Product->deleteItem($id);

		if($delete){
			redirect();
		}
	}

	public function cart(){
        $this->load->model("Product");
		$products = array("result" => $this->Product->getCartItems($this->session->userdata("cart_id"))); // Get products in cart

		$this->load->view("cart", $products);
	}
}