<?php

namespace App\Controllers;

class CartController extends BaseController
{
    public function add()
    {
        $itemId = $this->request->getPost('itemId');
        $name = $this->request->getPost('name');
        $price = $this->request->getPost('price');
        $quantity = $this->request->getPost('quantity');
        $image = $this->request->getPost('image');
        $notes = $this->request->getPost('notes');

        // Add to cart
        addToCart($itemId, $name, $price, $quantity, $image, $notes);

        // Redirect back to prevent form resubmission
        return redirect()->back()->with('success', 'Item added to cart!');
    }

    public function view()
    {
        $data['cartItems'] = getCartItems();
        $data['subTotal'] = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $data['cartItems']));
        return view('pages/public/cart', $data);
        
    }

    public function update()
    {
        $index = $this->request->getPost('itemIndex');
        $itemId = $this->request->getPost('itemId');
        $name = $this->request->getPost('name');
        $price = $this->request->getPost('price');
        $quantity = $this->request->getPost('quantity');
        $image = $this->request->getPost('image');
        $notes = $this->request->getPost('notes');
    
        // Update cart item
        updateCartItem($index, $itemId, $name, $price, $quantity, $image, $notes);
    
        return redirect()->to('/cart')->with('success', 'Item updated successfully!');
    }

    public function remove($index)
    {
        removeFromCart($index);
        return redirect()->to('/cart');
    }

    public function clear()
    {
        clearCart();
        return redirect()->to('/cart');
    }
}