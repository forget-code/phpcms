   <?php
   defined('IN_PHPCMS') or exit('Access Denied');
   dir_create(PHPCMS_ROOT.'/data/mail/');
   dir_copy(PHPCMS_ROOT.'/mail/install/mail/',PHPCMS_ROOT.'/data/mail/');
   dir_delete(PHPCMS_ROOT.'/mail/install/mail/');

   ?>