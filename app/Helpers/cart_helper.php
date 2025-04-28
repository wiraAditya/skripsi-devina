<?php
function addToCart($itemId, $name, $price, $quantity = 1, $image = '', $notes = '') {
    
    if (!session()->has('cart')) {
        session()->set('cart', []);
    }
    
    $cart = session()->get('cart');
    
    // Check if item already exists in cart
    $existingKey = null;
    foreach ($cart as $key => $item) {
        if ($item['id'] == $itemId && $item['notes'] == $notes) {
            $existingKey = $key;
            break;
        }
    }
    
    if ($existingKey !== null) {
        // Update quantity if item exists
        $cart[$existingKey]['quantity'] += $quantity;
    } else {
        // Add new item
        $cart[] = [
            'id' => $itemId,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $image,
            'notes' => $notes,
        ];
    }
    
    session()->set('cart', $cart);
    
}

function getCartCount() {
    $cart = session()->get('cart', []);
    return empty($cart) ? 0 : array_sum(array_column($cart, 'quantity'));
}

function getCartItems() {
    return session()->get('cart', []);
}

function removeFromCart($index) {
    $cart = session()->get('cart', []);
    
    if (isset($cart[$index])) {
        unset($cart[$index]);
        $cart = array_values($cart); // Reindex array
        session()->set('cart', $cart);
    }
}

function clearCart() {
    session()->remove('cart');
}

function updateCartItem($index, $id, $name, $price, $quantity, $image, $notes)
{
    $cart = session()->get('cart') ?? [];
    
    if (isset($cart[$index])) {
        $cart[$index] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $image,
            'notes' => $notes
        ];
        
        session()->set('cart', $cart);
        return true;
    }
    
    return false;
}