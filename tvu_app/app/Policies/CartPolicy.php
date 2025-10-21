<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;

class CartPolicy
{
    /**
     * Determine if the user can view the cart.
     */
    public function view(User $user, Cart $cart)
    {
        return $user->id === $cart->user_id;
    }

    /**
     * Determine if the user can delete the cart item.
     */
    public function delete(User $user, Cart $cart)
    {
        return $user->id === $cart->user_id;
    }
}
