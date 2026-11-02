<?php
class UploadService {
    public static function saveResume(array $file): ?string {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || ($file['size'] ?? 0) > 5*1024*1024) return null;
        $tmp=$file['tmp_name']??''; if (!is_uploaded_file($tmp)) return null;
        $finfo=new finfo(FILEINFO_MIME_TYPE); if ($finfo->file($tmp)!=='application/pdf') return null;
        $dir=BASE_PATH.'/storage/uploads/resumes'; if (!is_dir($dir)) mkdir($dir,0750,true);
        $name=bin2hex(random_bytes(18)).'.pdf'; return move_uploaded_file($tmp,$dir.'/'.$name)?$name:null;
    }
    /** Validates and resizes raster images. Requires PHP GD for safe optimization. */
    public static function saveImage(array $file, string $folder, int $maxWidth=1200, int $maxHeight=1200): ?string {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE)!==UPLOAD_ERR_OK || ($file['size']??0)>5*1024*1024) return null;
        $tmp=$file['tmp_name']??''; if (!is_uploaded_file($tmp) || !function_exists('imagecreatetruecolor')) return null;
        $info=@getimagesize($tmp); if (!$info) return null;
        $mime=$info['mime']??'';
        $load=match($mime) {'image/jpeg'=>@imagecreatefromjpeg($tmp),'image/png'=>@imagecreatefrompng($tmp),'image/webp'=>function_exists('imagecreatefromwebp')?@imagecreatefromwebp($tmp):false,default=>false};
        if (!$load) return null;
        [$w,$h]=$info; if ($w<1 || $h<1 || $w>8000 || $h>8000) { imagedestroy($load); return null; }
        $scale=min(1,$maxWidth/$w,$maxHeight/$h); $nw=max(1,(int)round($w*$scale)); $nh=max(1,(int)round($h*$scale));
        $out=imagecreatetruecolor($nw,$nh); $bg=imagecolorallocate($out,255,255,255); imagefill($out,0,0,$bg);
        imagecopyresampled($out,$load,0,0,0,0,$nw,$nh,$w,$h); imagedestroy($load);
        $dir=BASE_PATH.'/storage/uploads/'.$folder; if (!is_dir($dir) && !mkdir($dir,0750,true) && !is_dir($dir)) { imagedestroy($out); return null; }
        $name=bin2hex(random_bytes(18)).'.jpg'; $ok=imagejpeg($out,$dir.'/'.$name,82); imagedestroy($out);
        return $ok?$name:null;
    }
}
