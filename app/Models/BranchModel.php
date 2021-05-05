<?php

namespace App\Models;

use App\Database\DBConnection;
use Ballen\Distical\Calculator as DistanceCalculator;
use Ballen\Distical\Entities\LatLong;

require_once DB;

class Branch
{
    public function __construct()
    {
    }

    /**
     * Calculates the distance between 2 coordinates
     * Return the distance in km with 2 decimals
     * @param $branch_lat
     * @param $branch_lon
     * @param $user_lat
     * @param $user_lon
     * @return string
     */
    private function calcDistance($branch_lat, $branch_lon, $user_lat, $user_lon): string
    {
        $user_address = new LatLong($user_lat, $user_lon);
        $branch_address = new LatLong($branch_lat, $branch_lon);
        $distanceCalculator = new DistanceCalculator($user_address, $branch_address);

        return number_format($distanceCalculator->get()->asKilometres(), 2, ',', '');
    }

    /**
     * Validate coordinates
     * @param $lat
     * @param $long
     * @return false|int
     */
    private function validateCoordinates($data)
    {
        if (isset($data['lat'], $data['lon'])) {
            return preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?),[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $data['lat'] . ',' . $data['lon']);
        }
        return 0;
    }

    /**
     * Get all products from branches
     * Returns array of products sorted
     * @param $user_lat
     * @param $user_lon
     * @return mixed
     */
    public function getBranches($data)
    {
        if (!$this->validateCoordinates($data)) {
            throw new \Exception('Invalid coordinates');
        }
        if (!isset($data['quantity']) || $data['quantity'] < 0) {
            throw new \Exception('Invalid quantity');
        }
        $db = DBConnection::getInstance();
        $query = "SELECT s.id, p.name as product_name, p.id as product_id, p.price, s.quantity, b.name as branch_name, b.id as branch_id, b.lat, b.lon 
        FROM stocks as s 
        INNER JOIN branches as b ON b.id = s.branch_id
        INNER JOIN products as p ON p.id = s.product_id
        WHERE s.quantity >=" . (int)$data['quantity'];
        $result = $db->query($query);
        $branches = [];
        while ($row = $result->fetch_assoc()) {
            $branches[] = [
                'stock_id' => $row['id'],
                'product_id' => $row['product_id'],
                'product_name' => $row['product_name'],
                'branch_id' => $row['branch_id'],
                'branch_name' => $row['branch_name'],
                'price' => $row['price'],
                'stock' => $row['quantity'],
                'distance' => (float)$this->calcDistance($row['lat'], $row['lon'], $data['lat'], $data['lon']),
            ];
        }
        $distance = array_column($branches, 'distance');
        array_multisort($distance, SORT_ASC, $branches);

        return $branches;
    }

    /**
     * Buy products, update stock & create sales record
     * Returns tables updated
     * @param $values
     * @return mixed
     */
    public function buy($product)
    {
        if (isset($product['product'])) {
            $product = json_decode($product['product']);
        }
        if (!isset($product->stock_id, $product->branch_id, $product->product_id, $product->quantity, $product->lat, $product->lon)) {
            throw new \Exception('Error in checkout, try again!');
        }
        $db = DBConnection::getInstance();
        $stock_id = $db->escape($product->stock_id);
        $quantity = $db->escape($product->quantity);
        $branch_id = $db->escape($product->branch_id);
        $product_id = $db->escape($product->product_id);
        $lat = $db->escape($product->lat);
        $lon = $db->escape($product->lon);
        $stock = $db->query("SELECT quantity FROM stocks WHERE id = '$stock_id'");
        $update_stock = $stock->fetch_assoc()['quantity'] - $quantity;
        $db->query("UPDATE stocks SET quantity = '$update_stock' WHERE id = '$stock_id'");
        $query = "INSERT INTO sales (branch_id, product_id, quantity, lat, lon) VALUES ('$branch_id', '$product_id', '$quantity', '$lat', '$lon')";

        return $db->query($query);
    }
}