<?php

namespace App\Helper;

use App\Exceptions\SMException;
use App\Http\Enums\EDateFormat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use JetBrains\PhpStorm\Pure;

class Helper
{
    /**
     * @param $fileName
     * @param $file_folder_name
     * @param $type
     * @return bool|string
     * @throws SMException
     */
    public static function unlinkUploadedFile($fileName, $file_folder_name, $type = null): bool|string
    {
        if ($type === "admin") {
            $image = public_path() . '/admin/uploads/' . $file_folder_name . '/' . $fileName;
            $image_1 = public_path() . '/admin/uploads/' . $file_folder_name . '/img-' . $fileName;
        } else {
            $image = public_path() . '/front/uploads/' . $file_folder_name . '/' . $fileName;
            $image_1 = public_path() . '/front/uploads/' . $file_folder_name . '/img-' . $fileName;
        }
        if (file_exists($image_1)) {
            unlink($image_1);
        }
        if (file_exists($image)) {
            unlink($image);
            return true;
        }
        return "file not found";
    }

    /**
     * @param $file
     * @param $file_folder_name
     * @param $type
     * @return string
     */
    public static function uploadFile($file, $file_folder_name, $width = 100 , $height = 100 , $type = null): string
    {
        $imageName = $file->getClientOriginalName();
        if ($type === "admin") {
            $path = public_path() . '/admin/uploads/' . $file_folder_name;
        } else {
            $path = public_path() . '/front/uploads/' . $file_folder_name;
        }
        $fileName = date('Y-m-d-h-i-s') . '-' . str_replace('[ ]', '-', $imageName);
        $success = $file->move($path, $fileName);
        if($success && !in_array($file->getClientOriginalExtension(), ['pdf', 'doc', 'docx', 'ppt', 'txt', 'xls'])) {
            Image::make($path."/". $fileName)-> resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })-> save($path.'/img-'.$fileName);
        }
        return $fileName;
    }

    /**
     * @param $password
     * @return string
     */
    public static function passwordHashing($password): string
    {
        $new_password = self::getSaltedPassword($password);
        return Hash::make($new_password);
    }

    /**
     * @param $password
     * @return string
     */
    public static function getSaltedPassword($password): string
    {
        $salt_password = "Sales1!2@3#4$5%";
        return $salt_password . $password . $salt_password;
    }

    /**
     * @param $password
     * @param $savedPassword
     * @return bool
     */
    public static function checkPassword($password, $savedPassword): bool
    {
        $new_password = self::getSaltedPassword($password);
        return Hash::check($new_password, $savedPassword);
    }

    /**
     * @param $string
     * @return array|string
     */
    public static function getSlug($string): array|string
    {
        $string = strtolower($string);
        $string = html_entity_decode($string);
        $string = str_replace(array('ä', 'ü', 'ö', 'ß'), array('ae', 'ue', 'oe', 'ss'), $string);
        $string = preg_replace('#[^\w\säüöß]#', null, $string);
        $string = preg_replace('#[\s]{2,}#', ' ', $string);
        return str_replace(array(' '), array('-'), $string) . "-" . time();
    }

    /**
     * @param $string
     * @return array|string
     */
    public static function getSlugSimple($string): array|string
    {
        $string = strtolower($string);
        $string = html_entity_decode($string);
        $string = str_replace(array('ä', 'ü', 'ö', 'ß'), array('ae', 'ue', 'oe', 'ss'), $string);
        $string = preg_replace('#[^\w\säüöß]#', null, $string);
        $string = preg_replace('#[\s]{2,}#', ' ', $string);
        return str_replace(array(' '), array('-'), $string);
    }

    /**
     * @param $string
     * @return array|string
     */
    public static function getSlugSimple2($string): array|string
    {
        $string = strtolower($string);
        $string = html_entity_decode($string);
        $string = str_replace(array('ä', 'ü', 'ö', 'ß'), array('ae', 'ue', 'oe', 'ss'), $string);
        $string = preg_replace('#[^\w\säüöß]#', null, $string);
        $string = preg_replace('#[\s]{2,}#', ' ', $string);
        return str_replace(array(' '), array('_'), $string);
    }

    public static function smCombine3ArrayByKeyName(array $one_array, array $two_array, array $three_array, array $byNewKeys): array
    {
        $res = array_map(null, $one_array, $two_array, $three_array);
        return array_map(static function ($e) use ($byNewKeys) {
            return array_combine($byNewKeys, $e);
        }, $res);
    }

    public static function successResponseAPI($message, $data = ""): JsonResponse
    {
        return Response()->json(
            [
                'status' => 1,
                'status_code' => 200,
                'message' => $message,
                'data' => $data,
            ],
            200,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public static function errorResponseAPI($message, $data = "", $code = 400, $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {

        return Response()->json([
            'status' => 0,
            'status_code' => $code,
            'message' => $message,
            'data' => $data,
        ],
            $status,
            [],
            JSON_PRETTY_PRINT
        );
    }

    /**
     * @param string $date
     * @param EDateFormat $eDateFormat
     * @return string
     */
    public static function smDate(string $date, EDateFormat $eDateFormat = EDateFormat::Ymdhisa): string
    {
        $dateAndTime = strtotime($date);
        return date($eDateFormat->value, $dateAndTime) ?? '';
    }

    /**
     * @param string $date
     * @return string
     */
    #[Pure] public static function smdFrom(string $date): string
    {
        return self::smDate($date, EDateFormat::YmdHis);
    }

    /**
     * @param string $date
     * @return string
     */
    #[Pure(true)] public static function smdTo(string $date): string
    {
        $ymd = self::smDate($date, EDateFormat::Ymd);
        $hms = self::smDate($date, EDateFormat::His);
        $secondDif = strtotime($hms) - strtotime('00:00:00');
        return $secondDif === 0 ? "$ymd 23:59:59" : self::smDate($date, EDateFormat::YmdHis);
    }

    /**
     * @return string
     * @return string
     */
    public static function smTodayInYmd(): string
    {
        return now()->format('Y-m-d');
    }

    public static function smTodayInYmdHis(): string
    {
        return now()->format(EDateFormat::YmdHis->value);
    }

    public static function smCombine4ArrayByKeyName(array $one_array, array $two_array, array $three_array, array $four_array, array $byNewKeys): array
    {
        $res = array_map(null, $one_array, $two_array, $three_array, $four_array);
        return array_map(static function ($e) use ($byNewKeys) {
            return array_combine($byNewKeys, $e);
        }, $res);
    }

    public static function smCombine5ArrayByKeyName(array $one_array, array $two_array, array $three_array, array $four_array, array $five_array, array $byNewKeys): array
    {
        $res = array_map(null, $one_array, $two_array, $three_array, $four_array,$five_array);
        return array_map(static function ($e) use ($byNewKeys) {
            return array_combine($byNewKeys, $e);
        }, $res);
    }
    public static function smCombine6ArrayByKeyName(array $one_array, array $two_array, array $three_array, array $four_array, array $five_array, array $six_array, array $byNewKeys): array
    {
        $res = array_map(null, $one_array, $two_array, $three_array, $four_array,$five_array , $six_array);
        return array_map(static function ($e) use ($byNewKeys) {
            return array_combine($byNewKeys, $e);
        }, $res);
    }

    public static function generateCartNumber(): string
    {
        return "HM-CN-".(time()+ rand(1,1000));
    }

    public static function generateOrderNumber(): string
    {
        return "HM-order-".(time()+ rand(1,1000));
    }

    public static function countReviewStar($review): float|int
    {
        $total_star = $review->sum('review_star');
        $reviewer = $review->count();
        if($reviewer == 0)
        {
            return 0;
        }
        $star = round($total_star/$reviewer , 1 );
        $whole = floor($star);
        $fraction = $star - $whole;
        return ($fraction > 0.5)? ($whole + 1) : ($whole + 0.5);
    }
}
