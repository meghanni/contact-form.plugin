<?php
add_shortcode('contact-form', 'cff_ContactForm');

function cff_ContactForm() 
{
    ob_start();
    $contact = new cff_Contact;
    
    if ($contact->IsValid()) 
    {
        $headers = 'From: "' . $contact->Name . '" <' . $contact->Email . '>';
        
        if (wp_mail(get_bloginfo('admin_email') , get_bloginfo('name') . ' -  Web Enquiry', $contact->Message, $headers)) 
        {
            echo "<h3>" . cff_PluginSettings::SentMessageHeading() . "</h3>";
            echo "<p>" . cff_PluginSettings::SentMessageBody() . "</p>";
        }
        else
        {
            echo "</p>Message Not Sent</p>";
        }
    }
    else
    {
        
        //here we need some jquery scripts and styles, so load them here
        if ( cff_PluginSettings::UseClientValidation() == true) {
            wp_enqueue_script('jquery-validate');
            wp_enqueue_script('jquery-meta');
            wp_enqueue_script('jquery-validate-contact-form');
        }
        
        //only load the stylesheet if required
        if ( cff_PluginSettings::LoadStyleSheet() == true)
             wp_enqueue_style('bootstrap');

        ?>

        <?php if ( $contact->RecaptchaPublicKey<>'' && $contact->RecaptchaPrivateKey<>'')  { ?>
        
         <script type="text/javascript">
         var RecaptchaOptions = {
            theme : '<?php echo cff_PluginSettings::Theme(); ?>'
         };
         </script>
         
        <?php } ?>

           <?php if ( strlen(cff_PluginSettings::Message()) > 0 ) { ?>
                <p><?php echo cff_PluginSettings::Message(); ?></p>
           <?php } ?>
                
            <form id="contact-form" name="frmContact" method="post">

            <?php wp_nonce_field('cff_contact','cff_nonce'); ?>
                
            <!-- Clean and Simple Contact Form. Version <?php echo CFF_VERSION_NUM; ?> -->
              <div class="control-group">
                  <div class="controls">
                  <p class="text-error"><?php if (isset($contact->Errors['recaptcha'])) echo $contact->Errors['recaptcha']; ?></p>
                  </div>
              </div>


              <!--email address -->
              <div class="control-group<?php 
                if (isset($contact->Errors['Email'])) echo ' error'; ?>">
                 <label class="control-label" for="cf-Email">Email Address:</label>
                 <div class="controls">
                   <input class="input-xlarge {email:true, required:true, messages:{required:'Please give your email address.',email:'Please enter a valid email address.'}}" type="text" id="cf-Email" name="cf-Email" value="<?php echo $contact->Email; ?>" placeholder="Your Email Address">
                   <span class="help-inline"><?php if (isset($contact->Errors['Email'])) echo $contact->Errors['Email']; ?></span>
                 </div>
              </div>
              
              <!--confirm email address -->
              <div class="control-group<?php 
                if (isset($contact->Errors['Confirm-Email'])) echo ' error'; ?>">
                 <label class="control-label" for="cfconfirm-email">Confirm Email Address:</label>
                 <div class="controls">
                   <input class="input-xlarge {email:true, required:true, equalTo:cfemail, messages:{equalTo:'Please repeat the email address above.', required:'Please give your email address.',email:'Please enter a valid email address.'}}" type="text" id="cfconfirm-email" name="cfconfirm-email" value="<?php echo $contact->ConfirmEmail; ?>" placeholder="Confirm Your Email Address">
                   <span class="help-inline"><?php if (isset($contact->Errors['Confirm-Email'])) echo $contact->Errors['Confirm-Email']; ?></span>
                 </div>
              </div>              

            <!-- name --> 
             <div class="control-group<?php 
                if (isset($contact->Errors['Name'])) echo ' error'; ?>">
                 <label class="control-label" for="cf-Name">Name:</label>
                 <div class="controls">
                   <input class="input-xlarge {required:true, messages:{required:'Please give your name.'}}" type="text" id="cf-Name" name="cf-Name" value="<?php echo $contact->Name; ?>" placeholder="Your Name">
                   <span class="help-inline"><?php if (isset($contact->Errors['Name'])) echo $contact->Errors['Name']; ?></span> 
                 </div>
              </div>  

             <!-- message -->
              <div class="control-group<?php 
                if (isset($contact->Errors['Message'])) echo ' error'; ?>">
                 <label class="control-label" for="cf-Message">Message:</label>
                 <div class="controls">
                   <textarea class="input-xlarge {required:true, messages:{required:'Please give a message.'}}" id="cf-Message" name="cf-Message" rows="10" placeholder="Your Message"><?php echo $contact->Message; ?></textarea>
                   <span class="help-inline"><?php if (isset($contact->Errors['Message'])) echo $contact->Errors['Message']; ?></span> 
                 </div>
              </div>

               <?php if ( $contact->RecaptchaPublicKey<>'' && $contact->RecaptchaPrivateKey<>'') { ?>
                  <div class="control-group<?php 
                    if (isset($contact->Errors['recaptcha'])) echo ' error'; ?>">
                     <div id="recaptcha_div" class="controls">
                            <?php echo recaptcha_get_html($contact->RecaptchaPublicKey); ?>
                       <span class="help-inline"><?php if (isset($contact->Errors['recaptcha'])) echo $contact->Errors['recaptcha']; ?></span> 
                     </div>
                  </div>	
              <?php } ?>  

              <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn">Send Message</button>
                </div>
              </div>	  
            </form>

           
           
  

         <?php
    }
    $string = ob_get_contents();
    ob_end_clean();
    
    return $string;
}



