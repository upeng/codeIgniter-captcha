<?php
/**
 * 生成验证码并提交验证
 * 支持自定义验证码字符个数，图片宽度和高度
 *
 */
class Page  extends CI_Controller
{

    const CAPTCHA_CHARACTERS_NUM = 5;   //验证码字符个数
    const CAPTCHA_IMAGE_WIDTH = 200;    //验证码图片宽度
    const CAPTCHA_IMAGE_HEIGHT = 40;    //验证码图片高度

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'url', 'string']);
        $this->load->library(['session', 'captcha', 'form_validation']);
    }


    /**
     * 生成验证码图片地址，调用此方法即可显示image
     */
    public function getCaptchaImg()
    {
        $captchaCode = $this->captcha->getCaptcha(self::CAPTCHA_CHARACTERS_NUM); //不传参，默认为4
        $this->session->set_userdata('captcha', $captchaCode);
        $this->captcha->showImg(self::CAPTCHA_IMAGE_WIDTH, self::CAPTCHA_IMAGE_HEIGHT); //不传参默认100,30
    }


    /**
     * 验证提交的验证码是否正确
     */
    public function codeValidate()
    {
        $config = array(
            array(
                'field' => 'code',
                'label' => '验证码',
                'rules' => 'required',
                'errors' => array(
                    'required' => '%s不能为空！',
                )
            )
        );

        $this->form_validation->set_rules($config);

        //默认没有提交表单时，展示验证码和待提交表单
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('page_view');
        }
        else
        {
            //获取提交表单的code字段
            $code = $this->input->post('code');
            //获取生成验证码图片时存储的验证码文字session值 captcha
            $captchaCode = $this->session->userdata('captcha');

            if ($code == $captchaCode)
            {
                echo '验证通过！';
            }
            else
            {
                $data['validate_failed'] = '验证失败！';
                $this->load->view('page_view', $data);
            }
        }
    }
}