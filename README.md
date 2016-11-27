## Captcha

验证码类-CI框架下使用示例

1. 创建library/captcha类

```
注：如果将getCaptcha函数体改成如下，这样captcha可以跳出CI限制，直接装箱使用

function getCaptcha(){
	$str = "23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKMNPQRSTUVWXYZ";
	for ($i = 0; $i < $this->codeNum; $i++) {
	    $this->code .= $str{rand(0, strlen($str) - 1)};
	}
	return $this->code;
}
```
> 此处用于CI,所以可以直接引用这里创建的Captcha类即可

2. 自定义验证码
```
const CAPTCHA_CHARACTERS_NUM = 5;   //设置验证码字符个数
const CAPTCHA_IMAGE_WIDTH = 200;    //设置验证码图片宽度
const CAPTCHA_IMAGE_HEIGHT = 40;    //设置验证码图片高度
```

3. getCaptchaImg用于生成验证码图片，存储验证码字符；
在CI中直接访问 page/getcaptchaimg就可以返回验证码图片
```
注：因存储验证码图片的方式不唯一，此处设置sess_driver为files,因此需要设置sess_save_path

$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = sys_get_temp_dir();
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
```

4. codeValidate
用户提交的的验证码表单，进行验证
