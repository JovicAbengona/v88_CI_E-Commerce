<?php
    class Product extends CI_Model{
        public function checkCart(){
            $this->db->select("*");
            $this->db->from("carts");
            $query = $this->db->get();

            if($query->result_array() == NULL){
                $data = array(
                    "created_at" => date("Y-m-d, H:i:s"),
                    "updated_at" => date("Y-m-d, H:i:s"),
                );

                $this->db->insert("carts", $data);
                $this->session->set_userdata("cart_id", $this->db->insert_id());
            }
            else{
                $this->session->set_userdata("cart_id", $query->row_array()["id"]);
            }
        }

        public function countCart($cart_id){
            $this->db->select("COUNT(*) AS cartQuantity");
            $this->db->from("cart_details");
            $this->db->where("cart_id", $cart_id);
            $this->db->where("status", "added");
            $query = $this->db->get();

            return $query->row_array();
        }

        public function addToCart($form_data){
            $this->db->select("*");
            $this->db->from("cart_details");
            $this->db->where("product_id", $form_data["product_id"]);
            $this->db->where("status", NULL);
            $query = $this->db->get();

            if($query->row_array() != NULL){ // Update cart if product_id already exists
                $data = array(
                    "quantity" => $query->row_array()["quantity"] + $form_data["quantity"],
                    "updated_at" => date("Y-m-d, H:i:s")
                );

                $this->db->where("product_id", $form_data["product_id"]);
                return $this->db->update("cart_details", $data);
            }
            else{ // Insert data if product_id does not exist
                $data = array(
                    "cart_id" => $form_data["cart_id"],
                    "product_id" => $form_data["product_id"],
                    "quantity" => $form_data["quantity"],
                    "status" => "added",
                    "created_at" => date("Y-m-d, H:i:s"),
                    "updated_at" => date("Y-m-d, H:i:s")
                );
    
                return $this->db->insert("cart_details", $data);
            }
        }

        public function deleteItem($id){
            $this->db->where("id", $id);
            return $this->db->delete("cart_details");        
        }

        public function getCartItems($cart_id){
            $this->db->select("cart_details.id, cart_details.cart_id,cart_details.quantity, products.name, products.price");
            $this->db->from("cart_details");
            $this->db->join("products", "products.id = cart_details.product_id");
            $this->db->where("cart_details.cart_id", $cart_id);
            $this->db->where("cart_details.status", "added");
            $query = $this->db->get();

            return $query->result_array();
        }

        public function getProducts(){
            $this->db->select("*");
            $this->db->from("products");
            $query = $this->db->get();

            return $query->result_array();
        }

        public function processCheckout($checkout_data){
            $data = array(
                "status" => "bought",
                "updated_at" => date("Y-m-d, H:i:s")
            );

            $this->db->where("cart_id", $checkout_data["cart_id"]);
            $this->db->update("cart_details", $data); 

            return $this->db->insert("billing", $checkout_data);
        }
    }
?>