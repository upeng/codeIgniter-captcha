<?php
//验证码工具类

class Captcha
{
    private $codeNum;
    private $code;
    private $im;
    const CODE_NUM = 4;
    const CAPTCHA_WIDTH = 80;
    const CAPTCHA_HEIGHT = 30;

    function showImg($width = self::CAPTCHA_WIDTH, $height = self::CAPTCHA_HEIGHT){
        //创建图片
        $this->createImg($width, $height);
        //设置干扰元素
        $this->setDisturb($width, $height);
        //设置验证码
        $this->setCaptcha($width, $height, $this->codeNum);
        //输出图片
        $this->outputImg();
    }

    function getCaptcha($codeNum = self::CODE_NUM){
        $this->codeNum = $codeNum;
        $this->code = random_string('alnum', $this->codeNum); //使用CI string辅助函数
        return $this->code;
    }

    private function createImg($width, $height){
        $this->im = imagecreatetruecolor($width, $height);
        $bgColor = imagecolorallocate($this->im, 0, 0, 0);
        imagefill($this->im, 0, 0, $bgColor);
    }

    private function setDisturb($width, $height){
        $area = ($width * $height) / 20;
        $disturbNum = ($area > 250) ? 250 : $area;
        //加入点干扰
        for ($i = 0; $i < $disturbNum; $i++) {
            $color = imagecolorallocate($this->im, rand(0, 255), rand(0, 255), rand(0, 255));
            imagesetpixel($this->im, rand(1, $width - 2), rand(1, $height - 2), $color);
        }
        //加入弧线
        for ($i = 0; $i <= 5; $i++) {
            $color = imagecolorallocate($this->im, rand(128, 255), rand(125, 255), rand(100, 255));
            imagearc($this->im, rand(0, $width), rand(0, $height), rand(30, 300), rand(20, 200), 50, 30, $color);
        }
    }

    private function setCaptcha($width, $height, $codeNum){
        for ($i = 0; $i < $codeNum; $i++) {
            $color = imagecolorallocate($this->im, rand(50, 250), rand(100, 250), rand(128, 250));
            $size = rand(floor($height / 5), floor($height / 3));
            $x = floor($width / $codeNum) * $i + 5;
            $y = rand(0, $height - 20);
            imagechar($this->im, $size, $x, $y, $this->code{$i}, $color);
        }
    }

    private function outputImg(){
        if (imagetypes() & IMG_JPG) {
            header('Content-type:image/jpeg');
            imagejpeg($this->im);
        } elseif (imagetypes() & IMG_GIF) {
            header('Content-type: image/gif');
            imagegif($this->im);
        } elseif (imagetype() & IMG_PNG) {
            header('Content-type: image/png');
            imagepng($this->im);
        } else {
            die("Don't support image type!");
        }
    }

}