<?php
class Product
{
    private $product_id;
    private $product_name;
    private $category;
    private $description;
    private $rating;
    private $product_image_name;
    private $price;
    private $Quantity;

    function displayInTable()
    {

        $row = <<<REC
        <tr>
        <td><figure><img src="images/$this->product_image_name" alt="$this->product_image_name" width=160>
        <figcaption>$this->product_image_name</figcaption></figure></td>
        <td><a href="view.php?action=view&id=$this->product_id">$this->product_id</a></td>
        <td>$this->product_name</td>
        <td>$this->category</td>
        <td>$this->price</td>
        <td>$this->Quantity</td>
        <td><a href="edit.php?action=edit&id=$this->product_id"><img src="images/edit.png" alt="edit"></a>
            <a href="delete.php?action=delete&id=$this->product_id"><img src="images/delete.png" alt="delete"></a>
            </td>
    </tr>
REC;
        return $row;
    }

    function displayProdcutPage()
    {

        $main = <<<REC
        <main>
        <figure><img src="images/$this->product_image_name" alt="$this->product_image_name" width=260></figure>
        <h3>Product ID: $this->product_id , $this->product_name</h3>
        <ul>
        <li>Price: $this->price </li>
        <li>Category: $this->category </li>
        <li>Rating: $this->rating /5</li>
        </ul>
        <h3>Descrption: </h3>
        
REC;
        // Split the description into points
        $desc_point = explode(".", $this->description);

        // Append each point as a list item
        foreach ($desc_point as $point) {
            $main .= "<li>{$point}</li>";
        }

        $main .= "</ul>";
        $main .= "</main>";

        return $main;
    }

    public function getProductID()
    {
        return $this->product_id;
    }

    public function getProductName()
    {
        return $this->product_name;
    }

    public function setProductName($product_name)
    {
        $this->product_name = $product_name;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function getProductImageName()
    {
        return $this->product_image_name;
    }

    public function setProductImageName($product_image_name)
    {
        $this->product_image_name = $product_image_name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getQuantity()
    {
        return $this->Quantity;
    }

    public function setQuantity($quantity)
    {
        $this->Quantity = $quantity;
    }
}
