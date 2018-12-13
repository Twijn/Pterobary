<?php
    function endsWith($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    class Allocation {
        private $id;
        private $ip;
        private $alias;
        private $port;
        private $assigned;

        function __construct($id, $ip, $alias, $port, $assigned) {
            $this->id = $id;
            $this->ip = $ip;
            $this->alias = $alias;
            $this->port = $port;
            $this->assigned = $assigned;
        }

        function getId() {
            return $this->id;
        }

        function getIp() {
            return $this->ip;
        }

        function getAlias() {
            return $this->alias;
        }

        function getPort() {
            return $this->port;
        }

        function getAssigned() {
            return $this->assigned;
        }
    }

    class Location {
        private $id;
        private $short;
        private $long;
        private $updatedAt;
        private $createdAt;
        
        function __construct($id, $short, $long, $updatedAt, $createdAt) {
            $this->id = $id;
            $this->short = $short;
            $this->long = $long;
            $this->updatedAt = $updatedAt;
            $this->createdAt = $createdAt;
        }

        function getId() {
            return $this->id;
        }

        function getShort() {
            return $this->short;
        }

        function getLong() {
            return $this->long;
        }

        function getUpdatedAt() {
            return $this->updatedAt;
        }

        function getCreatedAt() {
            return $this->createdAt;
        }

    }

    class Node {
        private $id;
        private $public;
        private $name;
        private $description;
        private $location_id;
        private $fqdn;
        private $scheme;
        private $memory;
        private $memory_overallocate;
        private $disk;
        private $disk_overallocate;
        private $upload_size;
        private $daemon_listen;
        private $daemon_sftp;
        private $daemon_base;
        private $createdAt;
        private $updatedAt;
        
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

        function getAllocations($ptero) {
            $allocations = $ptero->sendRequest("GET", "application/nodes/" . $this->id . "/allocations");

            if($allocations) {
                $allocationsResult = array();
                
                foreach($allocations["data"] as &$allocation) {
                    array_push($allocationsResult,Pterodactyl::processObject($allocation));
                }

                return $allocationsResult;
            }else{
                return false;
            }
        }

        function getId() {
            return $this->id;
        }

        function getPublic() {
            return $this->public;
        }

        function getName() {
            return $this->name;
        }

        function getDescription() {
            return $this->description;
        }

        function getLocationId() {
            return $this->location_id;
        }

        function getFQDN() {
            return $this->fqdn;
        }

        function getScheme() {
            return $this->scheme;
        }

        function getMemory() {
            return $this->memory;
        }

        function getMemoryOverallocate() {
            return $this->memory_overallocate;
        }

        function getDisk() {
            return $this->disk;
        }

        function getDiskOverallocate() {
            return $this->disk_overallocate;
        }

        function getUploadSize() {
            return $this->upload_size;
        }

        function getDaemonListen() {
            return $this->daemon_listen;
        }

        function getDaemonSFTP() {
            return $this->daemon_sftp;
        }

        function getDaemonBase() {
            return $this->daemon_base;
        }

        function getUpdatedAt() {
            return $this->updatedAt;
        }

        function getCreatedAt() {
            return $this->createdAt;
        }

    }

    class Limits {
        private $memory;
        private $swap;
        private $disk;
        private $io;
        private $cpu;

        function __construct($memory, $swap, $disk, $io, $cpu) {
            $this->memory = $memory;
            $this->swap = $swap;
            $this->disk = $disk;
            $this->io = $io;
            $this->cpu = $cpu;
        }

        function getMemory() {
            return $this->memory;
        }

        function getSwap() {
            return $this->swap;
        }

        function getIO() {
            return $this->io;
        }

        function getCPU() {
            return $this->cpu;
        }
    }

    class FeatureLimits {
        private $databases;
        private $allocations;

        function __construct($databases, $allocations) {
            $this->databases = $databases;
            $this->allocations = $allocations;
        }

        function getDatabases() {
            return $this->databases;
        }

        function getAllocations() {
            return $this->allocations;
        }

    }

    class ServerEnvironment {
        private $bungee_version;
        private $server_jarfile;
        private $startup;
        private $p_server_location;
        private $p_server_uuid;

        function __construct($bungee_version, $server_jarfile, $startup, $p_server_location, $p_server_uuid) {
            $this->bungee_version = $bungee_version;
            $this->server_jarfile = $server_jarfile;
            $this->startup = $startup;
            $this->p_server_location = $p_server_location;
            $this->p_server_uuid = $p_server_uuid;
        }

        function getBungeeVersion() {
            return $this->bungee_version;
        }

        function getServerJarFile() {
            return $this->server_jarfile;
        }

        function getStartup() {
            return $this->startup;
        }

        function getServerLocation() {
            return $this->p_server_location;
        }

        function getServerUUID() {
            return $this->p_server_uuid;
        }

    }
    
    class ServerContainer {
        private $startup_command;
        private $image;
        private $installed;
        private $environment;

        function __construct($startup_command, $image, $installed, $environment) {
            $this->startup_command = $startup_command;
            $this->image = $image;
            $this->installed = $installed;
            $this->environment = $environment;
        }

        public static function noObjects($startup_command, $image, $installed, $environmentBungee_version, $environmentServer_jarfile, $environmentStartup, $environmentP_server_location, $environmentP_server_uuid) {
            $environment = new ServerEnvironment($environmentBungee_version, $environmentServer_jarfile, $environmentStartup, $environmentP_server_location, $environmentP_server_uuid);
            return new self($startup_command, $image, $installed, $environment);
        }

        function getStartupCommand() {
            return $this->startup_command;
        }

        function getImage() {
            return $this->image;
        }

        function getInstalled() {
            return $this->installed;
        }

        function getEnvironment() {
            return $this->environment;
        }
    }

    class Server {
        private $id;
        private $external_id;
        private $uuid;
        private $identifier;
        private $name;
        private $description;
        private $suspended;
        private $limits;
        private $featureLimits;
        private $user;
        private $node;
        private $allocation;
        private $nest;
        private $egg;
        private $pack;
        private $container;
        private $updatedAt;
        private $createdAt;

        function __construct($id, $external_id, $uuid, $identifier, $name, $description, $suspended, $limits, $featureLimits, $user, $node, $allocation, $nest, $egg, $pack, $container, $updatedAt, $createdAt) {
            $this->id = $id;
            $this->external_id = $external_id;
            $this->uuid = $uuid;
            $this->identifier = $identifier;
            $this->name = $name;
            $this->description = $description;
            $this->suspended = $suspended;
            $this->limits = $limits;
            $this->featureLimits = $featureLimits;
            $this->user = $user;
            $this->node = $node;
            $this->allocation = $allocation;
            $this->nest = $nest;
            $this->egg = $egg;
            $this->pack = $pack;
            $this->container = $container;
            $this->updatedAt = $updatedAt;
            $this->createdAt = $createdAt;
        }

        public static function noObjects($id, $external_id, $uuid, $identifier, $name, $description, $suspended, $limitsMemory, $limitsSwap, $limitsDisk, $limitsIO,
                    $limitsCPU, $featureLimitsDatabases, $featureLimitsAllocations, $user, $node, $allocation, $nest, $egg, $pack, $containerStartup_command, $containerImage,
                    $containerInstalled, $containerEnvironmentBungee_version, $containerEnvironmentServer_jarfile, $containerEnvironmentStartup, $containerEnvironmentP_server_location,
                    $containerEnvironmentP_server_uuid, $updatedAt, $createdAt) {
            
            $limits = new Limits($limitsMemory, $limitsSwap, $limitsDisk, $limitsIO, $limitsCPU);
            $featureLimits = new FeatureLimits($featureLimitsDatabases, $featureLimitsAllocations);
            $container = ServerContainer::noObjects($containerStartup_command, $containerImage, $containerInstalled, $containerEnvironmentBungee_version, $containerEnvironmentServer_jarfile,
                        $containerEnvironmentStartup, $containerEnvironmentP_server_location, $containerEnvironmentP_server_uuid);
            
            return new self($id, $external_id, $uuid, $identifier, $name, $description, $suspended, $limits, $featureLimits, $user, $node, $allocation, $nest, $egg,
                        $pack, $container, $updatedAt, $createdAt);
        }

        function getId() {
            return $this->id;
        }

        function getExternalId() {
            return $this->external_id;
        }

        function getUUID() {
            return $this->uuid;
        }

        function getName() {
            return $this->name;
        }

        function getDescription() {
            return $this->description;
        }

        function getSuspended() {
            return $this->suspended;
        }

        function getLimits() {
            return $this->limits;
        }

        function getFeatureLimits() {
            return $this->featureLimits;
        }

        function getUser() {
            return $this->user;
        }

        function getNode() {
            return $this->node;
        }

        function getAllocation() {
            return $this->allocation;
        }

        function getNest() {
            return $this->nest;
        }

        function getEgg() {
            return $this->egg;
        }

        function getPack() {
            return $this->pack;
        }

        function getContainer() {
            return $this->container;
        }

        function getUpdatedAt() {
            return $this->updatedAt;
        }

        function getCreatedAt() {
            return $this->createdAt;
        }

    }

    class User {
        private $id;
        private $external_id;
        private $uuid;
        private $username;
        private $email;
        private $first_name;
        private $last_name;
        private $language;
        private $root_admin;
        private $twofa;
        private $createdAt;
        private $updatedAt;

        function __construct($id, $external_id, $uuid, $username, $email, $first_name, $last_name, $language, $root_admin, $twofa, $createdAt, $updatedAt) {
            $this->id = $id;
            $this->external_id = $external_id;
            $this->uuid = $uuid;
            $this->username = $username;
            $this->email = $email;
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->language = $language;
            $this->root_admin = $root_admin;
            $this->twofa = $twofa;
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;
        }
        
        function getId() {
            return $this->id;
        }
        
        function getExternalId() {
            return $this->external_id;
        }
        
        function getUUID() {
            return $this->uuid;
        }
        
        function getUsername() {
            return $this->username;
        }
        
        function getEmail() {
            return $this->email;
        }
        
        function getFirstName() {
            return $this->first_name;
        }
        
        function getLastName() {
            return $this->last_name;
        }
        
        function getLanguage() {
            return $this->language;
        }
        
        function getRootAdmin() {
            return $this->root_admin;
        }
        
        function getTwoFactorAuth() {
            return $this->twofa;
        }

        function getUpdatedAt() {
            return $this->updatedAt;
        }

        function getCreatedAt() {
            return $this->createdAt;
        }

    }

    class Pterodactyl {
        private $private;
        private $endpoint;

        function __construct($private,$endpoint) {
            $this->private = $private;
            $this->endpoint = $endpoint;
        }

        function sendRequest($method, $request) {
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

        public static function processObject($obj) {
            if($obj["object"] === "server") {
                $attr = $obj["attributes"];
                return Server::noObjects($attr["id"],$attr["external_id"],$attr["uuid"],$attr["identifier"],$attr["name"],
                            $attr["description"],$attr["suspended"],$attr["limits"]["memory"],$attr["limits"]["swap"],
                            $attr["limits"]["disk"],$attr["limits"]["io"],$attr["limits"]["cpu"],$attr["feature_limits"]["databases"],
                            $attr["feature_limits"]["allocations"],$attr["user"],$attr["node"],$attr["allocation"],$attr["nest"],
                            $attr["egg"],$attr["pack"],$attr["container"]["startup_command"],$attr["container"]["image"],
                            $attr["container"]["installed"],$attr["container"]["environment"]["BUNGEE_VERSION"],
                            $attr["container"]["environment"]["SERVER_JARFILE"],$attr["container"]["environment"]["STARTUP"],
                            $attr["container"]["environment"]["P_SERVER_LOCATION"],$attr["container"]["environment"]["P_SERVER_UUID"],
                            $attr["updated_at"], $attr["created_at"]);
            }else if($obj["object"] === "allocation") {
                $attr = $obj["attributes"];
                return new Allocation($attr["id"], $attr["ip"], $attr["alias"], $attr["port"], $attr["assigned"]);
            }else if($obj["object"] === "node") {
                $attr = $obj["attributes"];
                return new Node($attr["id"],$attr["public"], $attr["name"], $attr["description"], $attr["location_id"],
                            $attr["fqdn"], $attr["scheme"], $attr["memory"], $attr["memory_overallocate"], $attr["disk"],
                            $attr["disk_overallocate"], $attr["upload_size"], $attr["daemon_listen"], $attr["daemon_sftp"],
                            $attr["daemon_base"], $attr["created_at"], $attr["updated_at"]);
            }else if($obj["object"] === "location") {
                $attr = $obj["attributes"];
                return new Location($attr["id"], $attr["short"], $attr["long"], $attr["updated_at"], $attr["created_at"]);
            }else if($obj["object"] === "user") {
                $attr = $obj["attributes"];
                return new User($attr["id"], $attr["external_id"], $attr["uuid"], $attr["username"], $attr["email"], $attr["first_name"],
                            $attr["last_name"], $attr["language"], $attr["root_admin"], $attr["2fa"], $attr["created_at"], $attr["updated_at"]);
            }else{
                return false;
            }
        }

        public function getLocations() {
            $locations = $this->sendRequest("GET","application/locations");

            if($locations) {
                $locationResult = array();
                
                foreach($locations["data"] as &$location) {
                    array_push($locationResult,Pterodactyl::processObject($location));
                }

                return $locationResult;
            }else{
                return false;
            }
        }

        public function getLocation($id) {
            $location = $this->sendRequest("GET","application/locations/" . $id);
            
            if($location) {
                if(array_key_exists("errors",$location)) {
                    return false;
                }else{
                    return Pterodactyl::processObject($location);
                }
            }else{
                return false;
            }
        }

        public function getNodes() {
            $nodes = $this->sendRequest("GET","application/nodes");

            if($nodes) {
                $nodeResult = array();
                
                foreach($nodes["data"] as &$node) {
                    array_push($nodeResult,Pterodactyl::processObject($node));
                }

                return $nodeResult;
            }else{
                return false;
            }
        }

        public function getNode($id) {
            $node = $this->sendRequest("GET","application/nodes/" . $id);
            
            if($node) {
                if(array_key_exists("errors",$node)) {
                    return false;
                }else{
                    return Pterodactyl::processObject($node);
                }
            }else{
                return false;
            }
        }

        public function getServers() {
            $servers = $this->sendRequest("GET", "application/servers");

            if($servers) {
                $serverResult = array();
                
                foreach($servers["data"] as &$server) {
                    array_push($serverResult,Pterodactyl::processObject($server));
                }

                return $serverResult;
            }else{
                return false;
            }
        }

        public function getServer($id) {
            $server = $this->sendRequest("GET","application/servers/" . $id);
            
            if($server) {
                if(array_key_exists("errors",$server)) {
                    return false;
                }else{
                    return Pterodactyl::processObject($server);
                }
            }else{
                return false;
            }
        }

        public function getUsers() {
            $users = $this->sendRequest("GET", "application/users");

            if($users) {
                $userResult = array();
                
                foreach($users["data"] as &$user) {
                    array_push($userResult,Pterodactyl::processObject($user));
                }

                return $userResult;
            }else{
                return false;
            }
        }

        public function getUser($id) {
            $user = $this->sendRequest("GET", "application/users/" . $id);

            if($user) {
                if(array_key_exists("errors",$user)) {
                    return false;
                }else{
                    return Pterodactyl::processObject($user);
                }
            }else{
                return false;
            }
        }
        
    }
?>