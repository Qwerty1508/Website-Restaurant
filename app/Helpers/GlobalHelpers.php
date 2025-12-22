<?php
use App\Models\CmsSetting;
use Illuminate\Support\Facades\Request;
if (!function_exists('cms')) {
    function cms($key, $default = '', $type = 'text')
    {
        $content = CmsSetting::get($key, $default);
        if (is_array($content)) {
            return $default; 
        }
        $isEditMode = Request::has('cms_mode') || session('cms_mode', false);
        if ($isEditMode) {
            if ($type === 'image') {
               return $content; 
            }
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