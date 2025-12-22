<?php

use App\Models\CmsSetting;
use Illuminate\Support\Facades\Request;

if (!function_exists('cms')) {
    /**
     * Get CMS content with visual editor attributes.
     *
     * @param string $key Unique key for the content
     * @param string $default Default content if key doesn't exist
     * @param string $type Type of content (text, image, richtext)
     * @return string|\Illuminate\Contracts\Support\Htmlable
     */
    function cms($key, $default = '', $type = 'text')
    {
        // Try to get content from database
        $content = CmsSetting::get($key, $default);
        
        // If content is an array (legacy or specific components), return as is or handle differently
        if (is_array($content)) {
            return $default; // Fallback for complex types not supported by simple string helper yet
        }

        // Check if we are in CMS Edit Mode
        // This is usually set by the iframe URL param ?cms_mode=true
        $isEditMode = Request::has('cms_mode') || session('cms_mode', false);

        if ($isEditMode) {
            // Return wrapped content for the editor
            // We use different wrappers based on type
            if ($type === 'image') {
               // For images, we typically return just the URL, but the editor needs to know.
               // Actually, for <img> tags, usages is usually src="{{ cms(...) }}"
               // This makes it hard to wrap in a <span>. 
               // Strategy: The helper should probably output the URL, and we assume the developer 
               // adds data-cms-key to the <img> tag manually OR we use a different helper directive.
               
               // Alternative: If type is 'src', return just the string.
               return $content; 
            }
            
            // For text/richtext, wrap in span/div
            $tag = ($type === 'richtext') ? 'div' : 'span';
            return sprintf(
                '<%s data-cms-key="%s" data-cms-type="%s" class="cms-editable">%s</%s>',
                $tag,
                $key,
                $type,
                $content,
                $tag
            );
        }

        return $content;
    }
}
