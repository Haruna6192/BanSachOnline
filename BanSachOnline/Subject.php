<?php

// Subject interface
interface Subject {
    public function attach(Observer $observer);
    public function detach(Observer $observer);
    public function notify();
}

// Concrete Subject class
class ProductList implements Subject {
    private $observers;
    private $products;

    public function __construct() {
        $this->observers = [];
        $this->products = [];
    }

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        $key = array_search($observer, $this->observers);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this->products);
        }
    }

    public function addProduct($product) {
        $this->products[] = $product;
        $this->notify();
    }

    public function removeProduct($product) {
        $key = array_search($product, $this->products);
        if ($key !== false) {
            unset($this->products[$key]);
            $this->notify();
        }
    }
}

// Observer interface
interface Observer {
    public function update($products);
}

// Concrete Observer class
class ProductView implements Observer {
    public function update($products) {
        echo "Product list updated: \n";
        foreach ($products as $product) {
            echo "- " . $product->getName() . "\n";
        }
    }
}

// Example usage
$productList = new ProductList();
$productView = new ProductView();

$productList->attach($productView);

$productList->addProduct(new Product("Product 1"));
$productList->addProduct(new Product("Product 2"));

$productList->removeProduct(new Product("Product 1"));

?>