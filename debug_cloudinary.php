<?php
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

try {
    echo "Testing Cloudinary Connection...\n";
    echo "Environment URL: " . config('cloudinary.cloud_url') . "\n"; // Check if config is loaded
    echo "Raw ENV: " . env('CLOUDINARY_URL') . "\n";
    
    // Try to parse the URL manually to see if it breaks
    $url = env('CLOUDINARY_URL');
    if (!$url) {
        throw new Exception("CLOUDINARY_URL is empty!");
    }
    
    // Upload test
    echo "Attempting to upload a test string...\n";
    $upload = Cloudinary::upload("https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&h=300&fit=crop");
    echo "Upload Success! URL: " . $upload->getSecurePath() . "\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
