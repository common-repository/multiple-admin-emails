<?php

$field_values = $this->field_settings;

$field_test = array();
$errors = array();
$sent_test = false;

if(isset($_POST[self::PREFIX.'fields_test'])){
    $field_test = $_POST[self::PREFIX.'fields_test'];
    if(empty($field_test['subject'])){
        $errors[] = 'Please enter the subject';
    }

    if(empty($errors)){
        $to = $field_test['to'];
        $subject = $field_test['subject'];
        $message = $field_test['message'];
        if(empty($to)){
            $to = get_option('admin_email');
        }

        wp_mail($to, $subject, $message);

        $sent_test = 'Sent email to '.$to;
    }
}

?>
<div class="wrap">
    <h2><?php echo _e('Multiple Admin Emails', self::TEXT_DOMAIN) ?></h2>

    <?php if($errors): ?>
        <div class="updated error">
            <p><?php echo implode("<br/>", $errors) ?></p>
        </div>
    <?php endif; ?>

    <?php if($sent_test): ?>
        <div class="updated saved">
            <p><?php echo $sent_test ?></p>
        </div>
    <?php endif; ?>

    <form action="<?php echo admin_url('options.php') ?>" method="post">
        <?php settings_fields( self::PREFIX.'group'); ?>
        <table style="width:100%;max-width: 600px;">
            <tr>
                <td style="width:150px;">From Name</td>
                <td>
                    <input type="text" class="widefat" name="<?php echo self::PREFIX ?>fields[from_name]" value="<?php echo $field_values['from_name'] ?>">
                </td>
            </tr>
            <tr>
                <td>From Email</td>
                <td>
                    <input type="text" class="widefat" name="<?php echo self::PREFIX ?>fields[from_email]" value="<?php echo $field_values['from_email'] ?>">
                </td>
            </tr>
            <tr>
                <td>Admin Emails</td>
                <td>
                    <textarea rows="3" name="<?php echo self::PREFIX ?>fields[emails]" class="widefat"><?php echo htmlspecialchars($field_values['emails']) ?></textarea>
                    <i>Each email per line</i>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button class="button-primary">Update Settings</button>
                </td>
            </tr>
        </table>
    </form>

    <h2><?php echo _e('Send Test Email', self::TEXT_DOMAIN) ?></h2>
    <form action="" method="post">
        <table style="width:100%;max-width: 600px;">
            <tr>
                <td style="width:150px;">Send To Email</td>
                <td>
                    <input type="text" class="widefat" name="<?php echo self::PREFIX ?>fields_test[to]" value="<?php echo $field_test['to'] ?>">
                    <i>Leave blank to use default above, many emails are separated by comma (,)</i>
                </td>
            </tr>
            <tr>
                <td>Subject</td>
                <td>
                    <input type="text" class="widefat" name="<?php echo self::PREFIX ?>fields_test[subject]" value="<?php echo $field_test['subject'] ?>">
                </td>
            </tr>
            <tr>
                <td>Message</td>
                <td>
                    <textarea rows="3" name="<?php echo self::PREFIX ?>fields_test[message]" class="widefat"><?php echo htmlspecialchars($field_test['message']) ?></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button class="button-primary">Send Test Email</button>
                </td>
            </tr>
        </table>
    </form>

</div>