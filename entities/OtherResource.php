<?php

require_once 'LibraryResource.php';

class OtherResource extends LibraryResource
{
    private $id;
    private $res_name;
    private $res_des;
    private $res_brand;

    public function __construct($id = null, $res_name = null, $res_des = null, $res_brand = null)
    {
        $this->id = $id;
        $this->res_name = $res_name;
        $this->res_des = $res_des;
        $this->res_brand = $res_brand;
    }

    public function AddResource($id, $res_name, $res_des, $res_brand)
    {
        $resource = [
            "id" => $id,
            "name" => $res_name,
            "description" => $res_des,
            "brand" => $res_brand
        ];

        $json_data = file_get_contents("resource.json");
        $resources = json_decode($json_data, true);

        $resources[] = $resource;

        $json_data = json_encode($resources, JSON_PRETTY_PRINT);

        file_put_contents("resource.json", $json_data);

        echo "Item Added! \n";
    }

    public function ResourceList()
    {
        $file_path = "resource.json";

        if (!file_exists($file_path)) {
            echo "No resources added\n";
            return;
        }

        $json_data = file_get_contents($file_path);
        $resources = json_decode($json_data, true);

        if (empty($resources)) {
            echo "No resources added\n";
        } else {
            foreach ($resources as $resource) {
                echo $this->getResourceInfo($resource['name'], $resource['id']) . "\n";
            }
        }
    }

    public function DeleteResource($id)
    {
        $json_data = file_get_contents("resource.json");
        $resources = json_decode($json_data, true);

        $found = false;

        foreach ($resources as $key => $resource) {
            if (strtolower($resource["id"]) == $id) {
                unset($resources[$key]);
                $found = true;
                break;
            }
        }
        if ($found) {
            $json_data = json_encode(array_values($resources), JSON_PRETTY_PRINT);
            file_put_contents("resource.json", $json_data);
            echo "Item deleted!\n";
        } else {
            echo "Item not found.\n";
        }
    }

    public function getResourceInfo($res_name, $id)
    {
        return "Resource name: " . $res_name . ", Resource ID: " . $id;
    }
}
