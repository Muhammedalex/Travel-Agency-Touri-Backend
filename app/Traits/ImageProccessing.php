<?php
namespace App\Traits;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// use Image;

trait ImageProccessing{
    public function get_mime($mime){
        if($mime == 'image/jpeg')
        $extension = '.jpg';
        elseif($mime == 'image/gif')
        $extension = '.gif';
        elseif($mime == 'image/png')
        $extension = '.png';
        elseif($mime == 'image/svg+xml')
        $extension = '.svg';
        elseif($mime == 'image/webp')
        $extension = '.webp';

        return $extension;
    }

    /************************** */

    public function saveImage($image , $ext){
        $manager = new ImageManager(new Driver());   
        $img = $manager->read($image);
       

        $str_random = Str::random(8);
        $imgPath = $str_random.time().$ext;
        $img->save(storage_path('app/imagesfp').'/'.$imgPath);

        return $imgPath ;
    }
    /********************** */

    // public function aspect4resize($image,$width,$heigh)
    // {
    //     $img = Image::make($image);
    //     $extension = $this->git_mime($img->mime());
    //     $str_random = Str::random(8);
    //     $img->resize($width,$heigh,function($constraint){
    //         $constraint->aspectRatio();
    //     });
    //     $imgPath = $str_random.time().$extension;
    //     $img->save(storage_path('app/imagesfp').'/'.$imgPath);

    //     return $imgPath;
    // }
    // /*********************** */

    // public function aspect4height($image,$width,$heigh)
    // {
    //     $img = Image::make($image);
    //     $extension = $this->git_mime($img->mime());
    //     $str_random = Str::random(8);
    //     $img->resize(null,$heigh,function($constraint){
    //         $constraint->aspectRatio();
    //     });
    //     if($img->width() < $width){
    //         $img->resize($width,null);
    //     }
    //     else if($img->width()> $width){
    //         $img->crop($width,$heigh,0,0);
    //     }
    //     $imgPath = $str_random.time().$extension;
    //     $img->save(storage_path('app/imagesfp').'/'.$imgPath);

    //     return $imgPath;
    // }

    //     /*********************** */

    //    public function saveImgAndThumbnail($Thefile,$thumb = false)
    //    {
    //         $dataX = array();
    //         $dataX['image']=$this->saveImage($Thefile);

    //         if($thumb){
    //             $dataX['thumbnailsm']=$this->aspect4resize($Thefile,256,144);
    //             $dataX['thumbnailmd']=$this->aspect4resize($Thefile,426,240);
    //             $dataX['thumbnailxl']=$this->aspect4resize($Thefile,640,360);
    //         }

    //         return $dataX;
    //    } 

    //    /************** */

       public function deleteImage($filePath)
       {
            if(is_file(Storage::disk('imagesfp')->exists($filePath))){
                if(file_exists(Storage::disk('imagesfp')->exists($filePath))){
                    unlink(Storage::disk('imagesfp')->delete($filePath));
                }
            }        
       }
    }
