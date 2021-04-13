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
			$this->session->set_userdata("error", "product quantity can't be empty!");
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
				$this->session->set_userdata("buy_success", "product has been added to cart!");
				redirect(base_url());
			}
		}
	}

	public function delete($id){
		$this->load->model("Product");
		$delete = $this->Product->deleteItem($id);

		if($delete){
			$this->session->set_userdata("delete_success", "product has been deleted");
			redirect("cart");
		}
	}

	public function cart(){
        $this->load->model("Product");
		$products = array("result" => $this->Product->getCartItems($this->session->userdata("cart_id"))); // Get products in cart

		$this->load->view("cart", $products);
	}

	public function checkout(){
		$this->load->model("Product");
		$products = array("result" => $this->Product->getCartItems($this->session->userdata("cart_id"))); // Get products in cart

		$this->load->view("checkout", $products);
	}

	public function processCheckout(){
		$this->form_validation->set_rules("name", "name", "required");
		$this->form_validation->set_rules("address", "address", "required");
		$this->form_validation->set_rules("card", "card", "required|regex_match[/^[0-9]{4}[-]{1}[0-9]{4}[-]{1}[0-9]{4}[-]{1}[0-9]{4}$/]");
		$this->form_validation->set_rules("valid_through", "valid through", "required");
		$this->form_validation->set_rules("cvc", "CVC", "trim|required|integer|max_length[4]");

		$this->form_validation->set_message("required", "%s can't be empty");
		$this->form_validation->set_message("regex_match", "please enter a valid card number");
		$this->form_validation->set_message("max_length", "please enter a valid CVC");
		$this->form_validation->set_message("integer", "please enter a valid CVC");

		$has_errors = false;

		if($this->input->post("valid_through") != NULL){
			$valid_through = explode("-", $this->input->post("valid_through"));

			if($valid_through[0] < date("Y")){
				$this->session->set_userdata("checkout_error_valid_through", "<p>card is no longer valid</p>");
				$has_errors = true;
			}
			else if($valid_through[0] == date("Y") AND $valid_through[1] < date("m")){
				$this->session->set_userdata("checkout_error_valid_through", "<p>card is no longer valid</p>");
				$has_errors = true;
			}
		}

		if($this->form_validation->run() == FALSE){
			$this->session->set_userdata("checkout_error_name", form_error("name"));
			$this->session->set_userdata("checkout_error_address", form_error("address"));
			$this->session->set_userdata("checkout_error_card", form_error("card"));
			$this->session->set_userdata("checkout_error_cvc", form_error("cvc"));
			if($this->session->userdata("checkout_error_valid_through") == NULL)
				$this->session->set_userdata("checkout_error_valid_through", form_error("valid_through"));
			$has_errors = true;
		}

		if($has_errors)
			redirect("checkout");
		else{
			$card = explode("-", $this->input->post("card")); // Explode - to get last four digits of card number
			$checkout_data = array(
				"cart_id" => $this->session->userdata("checkout_cart_id"),
				"amount" => $this->session->userdata("checkout_total"),
				"name" => $this->input->post("name"),
				"address" => $this->input->post("address"),
				"card_number" => $card["3"],
				"created_at" => date("Y-m-d, H:i:s"),
				"updated_at" => date("Y-m-d, H:i:s")
			);
	
			$this->load->model("Product");
			$checkout = $this->Product->processCheckout($checkout_data);
	
			if($checkout){
				$this->session->set_userdata("checkout_success", "Your order has been processed. Thank you for your purchase!");
				redirect(base_url());
			}
		}
	}
}