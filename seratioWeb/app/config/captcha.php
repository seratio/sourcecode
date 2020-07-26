<?php if (!class_exists('CaptchaConfiguration')) { return; }

// BotDetect PHP Captcha configuration options

return array(
  // Captcha configuration for example page
  'ExampleCaptcha' => array(
    'UserInputID' => 'CaptchaCode',
    'ImageWidth' => 250,
    'ImageHeight' => 50,
  ),

);
