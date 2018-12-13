<?php
    function endsWith($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    class Location {
        public $id;
        public $short;
        public $long;
        public $updatedAt;
        public $createdAt;
        
        function __construct($id, $short, $long, $updatedAt, $createdAt) {
            $this->id = $id;
            $this->short = $short;
            $this->long = $long;
            $this->updatedAt = $updatedAt;
            $this->createdAt = $createdAt;
        }

    }

    class Node {
        public $id;
        public $public;
        public $name;
        public $description;
        public $location_id;
        public $fqdn;
        public $scheme;
        public $memory;
        public $memory_overallocate;
        public $disk;
        public $disk_overallocate;
        public $upload_size;
        public $daemon_listen;
        public $daemon_sftp;
        public $daemon_base;
        public $createdAt;
        public $updatedAt;
        
        function __construct($id, $public, $name, $description, $location_id, $fqdn, $scheme,
                $memory, $memory_overallocate, $disk,
                $disk_overallocate, $upload_size, $daemon_listen, $daemon_sftp, $daemon_base,
                $createdAt, $updatedAt) {
            
            $this->id = $id;
            $this->public = $public;
            $this->name = $name;
            $this->description = $description;
            $this->location_id = $location_id;
            $this->fqdn = $fqdn;
            $this->scheme = $scheme;
            $this->memory = $memory;
            $this->memory_overallocate = $memory_overallocate;
            $this->disk = $disk;
            $this->disk_overallocate = $disk_overallocate;
            $this->upload_size = $upload_size;
            $this->daemon_listen = $daemon_listen;
            $this->daemon_sftp = $daemon_sftp;
            $this->daemon_base = $daemon_base;
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;
        }

    }

    class Limits {
        public $memory;
        public $swap;
        public $disk;
        public $io;
        public $cpu;

        function __construct($memory, $swap, $disk, $io, $cpu) {
            $this->memory = $memory;
            $this->swap = $swap;
            $this->disk = $disk;
            $this->io = $io;
            $this->cpu = $cpu;
        }
    }

    class FeatureLimits {
        public $databases;
        public $allocations;

        function __construct($databases, $allocations) {
            $this->databases = $databases;
            $this->allocations = $allocations;
        }
    }

    class Server {
        public $id;
        public $external_id;
        public $uuid;
        public $identifier;
        public $name;
        public $description;
        public $suspended;
        public $limits;
        public $featureLimits;
        public $user;
        public $node;
        public $allocation;
        public $nest;
        public $egg;
        public $pack;
        public $container;
        public $updatedAt;
        public $createdAt;

        function __construct() {

        }

    }

    class Pterodactyl {
        private $private;
        private $endpoint;

        function __construct($private,$endpoint) {
            $this->private = $private;
            $this->endpoint = $endpoint;
        }

        private function sendRequest($method, $request) {
            $curl = curl_init($this->endpoint . $request);

            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept: application/json','Authorization: Bearer ' . $this->private]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, $method, true);

            $json = curl_exec($curl);

            if($json) {
                $data = json_decode($json, true);
                return $data;
            }else{
                return false;
            }
        }

        private function processObject($obj) {
            if($obj["object"] === "server") {

            }else if($obj["object"] === "node") {

            }else if($obj["object"] === "location") {
                $attr = $obj["attributes"];
                return new Location($attr["id"], $attr["short"], $attr["long"], $attr["updated_at"], $attr["created_at"]);
            }
        }

        function getLocations() {
            $locations = $this->sendRequest("GET","application/locations");

            if($locations) {
                $locationResult = array();
                
                foreach($locations["data"] as &$location) {
                    array_push($locationResult,processObject($location));
                }

                return $locationResult;
            }else{
                return false;
            }
        }

        function getLocation($id) {
            $location = $this->sendRequest("GET","application/locations/" . $id);
            
            if($location) {
                if(array_key_exists("errors",$location)) {
                    return false;
                }else{
                    return processObject($location);
                }
            }else{
                return false;
            }
        }

        function getNodes() {
            $nodes = $this->sendRequest("GET","application/nodes");

            if($nodes) {
                $nodeResult = array();
                
                foreach($nodes["data"] as &$node) {
                    $attr = $node["attributes"];
                    $nod = new Node($attr["id"],$attr["public"], $attr["name"], $attr["description"], $attr["location_id"],
                            $attr["fqdn"], $attr["scheme"], $attr["memory"],
                            $attr["memory_overallocate"], $attr["disk"], $attr["disk_overallocate"], $attr["upload_size"],
                            $attr["daemon_listen"], $attr["daemon_sftp"], $attr["daemon_base"], $attr["created_at"], $attr["updated_at"]);
                    array_push($nodeResult,$nod);
                }

                return $nodeResult;
            }else{
                return false;
            }
        }

        function getNode($id) {
            $node = $this->sendRequest("GET","application/nodes/" . $id);
            
            if($node) {
                if(array_key_exists("errors",$node)) {
                    return false;
                }else{
                    $attr = $node["attributes"];

                    return new Node($attr["id"],$attr["public"], $attr["name"], $attr["description"], $attr["location_id"],
                    $attr["fqdn"], $attr["scheme"], $attr["memory"],
                    $attr["memory_overallocate"], $attr["disk"], $attr["disk_overallocate"], $attr["upload_size"],
                    $attr["daemon_listen"], $attr["daemon_sftp"], $attr["daemon_base"], $attr["created_at"], $attr["updated_at"]);
                }
            }else{
                return false;
            }
        }

        function getServers() {
            $servers = $this->sendRequest("GET", "application/servers");

            if($servers) {

            }else{
                return false;
            }
        }
    }
?>