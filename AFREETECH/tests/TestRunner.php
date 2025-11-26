<?php
/**
 * Simple Test Runner
 * 
 * Scans the tests directory for files ending in Test.php and executes them.
 * Assumes tests are simple classes with methods starting with 'test'.
 */

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Running Tests...\n\n";

$testDir = __DIR__;
$files = scandir($testDir);
$passCount = 0;
$failCount = 0;

foreach ($files as $file) {
    if (strpos($file, 'Test.php') !== false) {
        require_once $testDir . '/' . $file;
        $className = str_replace('.php', '', $file);
        
        if (class_exists($className)) {
            $testObj = new $className();
            $methods = get_class_methods($testObj);
            
            echo "Testing $className:\n";
            
            foreach ($methods as $method) {
                if (strpos($method, 'test') === 0) {
                    try {
                        $testObj->$method();
                        echo "  [PASS] $method\n";
                        $passCount++;
                    } catch (Exception $e) {
                        echo "  [FAIL] $method - " . $e->getMessage() . "\n";
                        $failCount++;
                    }
                }
            }
            echo "\n";
        }
    }
}

echo "--------------------------------------------------\n";
echo "Total Passed: $passCount\n";
echo "Total Failed: $failCount\n";

if ($failCount > 0) {
    exit(1);
}
exit(0);
